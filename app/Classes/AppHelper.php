<?php

if (!function_exists('urlGenerator')) {

    /**
     * @return \Laravel\Lumen\Routing\UrlGenerator
     */
    function urlGenerator()
    {
        return new \Laravel\Lumen\Routing\UrlGenerator(app());
    }
}

if (!function_exists('asset')) {

    /**
     * @param $path
     * @param bool $secured
     *
     * @return string
     */
    function asset($path, $secured = true)
    {
        if (env('APP_DEBUG')) {
            $secured = false;
        }

        return urlGenerator()->asset('assets/'.$path, $secured);
    }
}


if (!function_exists('isValidURL')) {

    /**
     * @param $url
     * @return bool
     */
    function isValidURL($url)
    {
        try {

            $exists = true;
            $headers = get_headers($url);

            if ($headers === false) {
                return false;
            }

            $invalidHeaders = ['404', '403', '500'];

            foreach ($invalidHeaders as $header) {

                if (strstr($headers[0], $header)) {
                    $exists = false;
                    break;
                }
            }

            return $exists;

        } catch (Exception $e) {
            return false;
        }
    }
}
