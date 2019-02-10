<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Invisnik\LaravelSteamAuth\SteamAuth;
use Illuminate\Support\Facades\Crypt;

class SteamController extends Controller
{
    /**
     * @var object
     */
    private $steam;
    private $cookie;

    /**
     * SteamController constructor.
     * @param SteamAuth $steam
     */
    public function __construct(SteamAuth $steam)
    {
        $this->steam = $steam;
        $this->cookie = app()->make('cookie');
    }

    public function login()
    {
        if ($this->steam->validate()) {

            $steamUserData = $this->steam->getUserInfo();

            if ($steamUserData) {

                $eCookieSteamId = Crypt::encrypt($steamUserData->steamID64);

                $this->cookie->queue('SteamId',
                    $eCookieSteamId,
                    10080
                );

                return redirect()->route('web.redirect.method', ['fetchMethod' => 'steamid']);
            }
        }
        return $this->steam->redirect();
    }
}
