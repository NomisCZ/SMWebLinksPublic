<?php

namespace App\Http\Controllers;

use App;
use Cache;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class WebController extends Controller
{
    private $requestData;
    private $cookie;

    /**
     * WebController constructor.
     */
    public function __construct()
    {
        $this->cookie = app()->make('cookie');
    }

    /**
     * Pull data from cache by Ip or SteamId
     * @param Request $request
     * @param $fetchMethod
     * @param null $steamId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View|\Laravel\Lumen\Http\Redirector
     */
    public function redirectMethod(Request $request, $fetchMethod, $steamId = null)
    {
        $this->requestData = [
            'clientIp' => $request->ip(),
            'fallbackUrl' => $request->input('fallbackUrl'),
            'cookies' => [
                'eSteamId' => $request->cookie('SteamId'),
                'eFallbackUrl' => $request->cookie('FallbackUrl')
            ]
        ];

        $cacheKey = $this->requestData['clientIp'];

        if ($fetchMethod === 'steamid' && $steamId) {

            $cacheKey = $steamId;

        } else if ($fetchMethod === 'steamid') {

            $cookieSteamId = null;

            if ($this->requestData['cookies']['eSteamId']) {

                try {
                    $cookieSteamId = Crypt::decrypt($this->requestData['cookies']['eSteamId']);
                } catch (DecryptException $e) {

                }
            }

            if (!$cookieSteamId) {

                // If is defined fallbackUrl save it temporary as cookie, because Steam login redirect
                if ($this->requestData['fallbackUrl']) {

                    $eCookieFallbackUrl = Crypt::encrypt($this->requestData['fallbackUrl']);

                    $this->cookie->queue('FallbackUrl',
                        $eCookieFallbackUrl,
                        5
                    );
                }

                return view('auth.login');
            }

            $cacheKey = $cookieSteamId;
        }

        if (!Cache::has($cacheKey)) {

            $fallbackUrl = $this->requestData['fallbackUrl'];

            if ($fetchMethod === 'steamid') {

                if ($this->requestData['cookies']['eFallbackUrl']) {

                    try {
                        $fallbackUrl = Crypt::decrypt($this->requestData['cookies']['eFallbackUrl']);
                    } catch (DecryptException $e) {

                    }

                    $this->cookie->queue('FallbackUrl',
                        null,
                        0
                    );
                }
            }

            return $fallbackUrl ? redirect($fallbackUrl) : view('errors.failed');
        }

        $cachedData = json_decode(Cache::pull($cacheKey));

        if ($fetchMethod === 'steamid') {

            $this->cookie->queue('FallbackUrl',
                null,
                0
            );
        }

        if (($this->requestData['clientIp'] !== $cachedData->playerIp) || ($fetchMethod !== $cachedData->fetchMethod)) {

            return view('errors.failed');
        }

        if (!isValidURL($cachedData->url)) {

            return view('error.not-available', ['url' => $cachedData->url]);
        }

        return redirect($cachedData->url);
    }

    /**
     * Pull data from cache by SteamId
     * @param Request $request
     * @param $steamId
     * @return mixed
     * @deprecated Redirect for old plugin version
     */
    public function redirectTo(Request $request, $steamId)
    {
        $this->requestData = [
            'clientIp' => $request->ip(),
        ];

        if (!Cache::has($steamId)) {

            return view('errors.failed');
        }

        $cachedData = json_decode(Cache::pull($steamId));

        if ($this->requestData['clientIp'] !== $cachedData->playerIp) {

            return view('redirect-internal', ['url' => route('error.failed')]);
        }

        if (!isValidURL($cachedData->url)) {

            return view('redirect-internal', ['url' => route('error.not-available', ['url' => $cachedData->url])]);
        }

        return view('redirect', ['requestData' => $cachedData]);
    }
}