<?php

namespace App\Classes;

use App;
use Response;

class AppResponseVDF
{

    /**
     * @param $responseData
     */
    public static function sendError($responseData) {

        self::sendResponse($responseData, 'error');
    }

    /**
     * @param $responseData
     */
    public static function sendSuccess($responseData) {

        self::sendResponse($responseData, 'success');
    }

    /**
     * @param $responseData
     * @param $responseStatus
     */
    private static function sendResponse($responseData, $responseStatus) {

        $responseData['response_type'] = 'VDF';

        response(
            self::vdf_encode([
                'response' => [
                    $responseStatus => $responseData,
                    'client' => [
                        'ip_address' => \Request::ip(),
                        'request' => \Request::url()
                    ],
                    'app' => [
                        'name' => env('APP_NAME'),
                        'version' => env('APP_VERSION')
                    ]
                ]
            ], true), $responseData['code'], ['Content-Type' => 'text/plain'])->send();
        exit();
    }

    /**
     * @param $text
     * @return array|null
     */
    public static function vdf_decode($text) {

        if(!is_string($text)) {
            trigger_error("vdf_decode expects parameter 1 to be a string, " . gettype($text) . " given.", E_USER_NOTICE);
            return NULL;
        }
        // detect and convert utf-16, utf-32 and convert to utf8
        if      (substr($text, 0, 2) == "\xFE\xFF")         $text = mb_convert_encoding($text, 'UTF-8', 'UTF-16BE');
        else if (substr($text, 0, 2) == "\xFF\xFE")         $text = mb_convert_encoding($text, 'UTF-8', 'UTF-16LE');
        else if (substr($text, 0, 4) == "\x00\x00\xFE\xFF") $text = mb_convert_encoding($text, 'UTF-8', 'UTF-32BE');
        else if (substr($text, 0, 4) == "\xFF\xFE\x00\x00") $text = mb_convert_encoding($text, 'UTF-8', 'UTF-32LE');
        // strip BOM
        $text = preg_replace('/^[\xef\xbb\xbf\xff\xfe\xfe\xff]*/', '', $text);
        $lines = preg_split('/\n/', $text);
        $arr = array();
        $stack = array(0=>&$arr);
        $expect_bracket = false;
        $name = "";
        $re_keyvalue = '~^("(?P<qkey>(?:\\\\.|[^\\\\"])+)"|(?P<key>[a-z0-9\\-\\_]+))' .
            '([ \t]*(' .
            '"(?P<qval>(?:\\\\.|[^\\\\"])*)(?P<vq_end>")?' .
            '|(?P<val>[a-z0-9\\-\\_]+)' .
            '))?~iu';
        $j = count($lines);
        for($i = 0; $i < $j; $i++) {
            $line = trim($lines[$i]);
            // skip empty and comment lines
            if( $line == "" || $line[0] == '/') { continue; }
            // one level deeper
            if( $line[0] == "{" ) {
                $expect_bracket = false;
                continue;
            }
            if($expect_bracket) {
                trigger_error("vdf_decode: invalid syntax, expected a '}' on line " . ($i+1), E_USER_NOTICE);
                return Null;
            }
            // one level back
            if( $line[0] == "}" ) {
                array_pop($stack);
                continue;
            }
            // nessesary for multiline values
            while(True) {
                preg_match($re_keyvalue, $line, $m);
                if(!$m) {
                    trigger_error("vdf_decode: invalid syntax on line " . ($i+1), E_USER_NOTICE);
                    return NULL;
                }
                $key = (isset($m['key']) && $m['key'] !== "")
                    ? $m['key']
                    : $m['qkey'];
                $val = (isset($m['qval']) && (!isset($m['vq_end']) || $m['vq_end'] !== ""))
                    ? $m['qval']
                    : (isset($m['val']) ? $m['val'] : False);
                if($val === False) {
                    // chain (merge*) duplicate key
                    if(!isset($stack[count($stack)-1][$key])) {
                        $stack[count($stack)-1][$key] = array();
                    }
                    $stack[count($stack)] = &$stack[count($stack)-1][$key];
                    $expect_bracket = true;
                }
                else {
                    // if don't match a closing quote for value, we consome one more line, until we find it
                    if(!isset($m['vq_end']) && isset($m['qval'])) {
                        $line .= "\n" . $lines[++$i];
                        continue;
                    }
                    $stack[count($stack)-1][$key] = $val;
                }
                break;
            }
        }
        if(count($stack) !== 1)  {
            trigger_error("vdf_decode: open parentheses somewhere", E_USER_NOTICE);
            return null;
        }
        return $arr;
    }

    /**
     * @param $arr
     * @param bool $pretty
     * @return null|string
     */
    public static function vdf_encode($arr, $pretty = false) {

        if(!is_array($arr)) {
            return null;
        }
        $pretty = (boolean) $pretty;
        return self::vdf_encode_step($arr, $pretty, 0);
    }

    /**
     * @param $arr
     * @param $pretty
     * @param $level
     * @return null|string
     */
    private static function vdf_encode_step($arr, $pretty, $level) {

        if(!is_array($arr)) {
            return null;
        }
        $buf = "";
        $line_indent = ($pretty) ? str_repeat("\t", $level) : "";
        foreach($arr as $k => $v) {
            if(is_string($v)) {
                $buf .= "$line_indent\"$k\" \"$v\"\n";
            }
            else {
                $res = self::vdf_encode_step($v, $pretty, $level + 1);
                if($res === NULL) return NULL;
                $buf .= "$line_indent\"$k\"\n$line_indent{\n$res$line_indent}\n";
            }
        }
        return $buf;
    }
}

