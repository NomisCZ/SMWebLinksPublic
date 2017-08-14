<?php

namespace App\Classes;

use App;
use Illuminate\Support\Facades\Request;

class AppUserAgent {

    private $userAgent;
    private $userAgentData;

    private $allowedSteamApps = array('730', '240', '4000', '500', '550', '440');

    public function __construct() {

        $this->userAgent = Request::header('User-Agent');
        $this->parseUserAgent();
    }

    private function parseUserAgent() {

        $pattern = '/(^\s*\()|(\)\s*$)/';

        $parts = explode(" ", $this->userAgent);

        $version = preg_replace($pattern, '', end($parts));

        $this->userAgentData = array (
            'name' => $parts[0],
            'version' => $version
        );
    }

    public function isValveClient() {

        return (in_array($this->userAgentData['version'], $this->allowedSteamApps));
    }

    public function isValveInGameBrowser() {

        return (preg_match("/Valve Client/", $this->userAgent));
    }

}