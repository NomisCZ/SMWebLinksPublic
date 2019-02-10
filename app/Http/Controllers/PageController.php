<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;

class PageController extends Controller
{
    private $cookie;

    public function index()
    {
        return view('errors.403');
    }

    public function logout(Request $request)
    {
        if (!$request->cookie('SteamId')) {
            return view('auth.logout', ['notLogged' => true]);
        }

        $this->cookie = app()->make('cookie');

        $this->cookie->queue('SteamId',
            null,
            0
        );

        return view('auth.logout');
    }

    public function errorNotAvailable(Request $request)
    {
        $url = $request->input('url');
        return view('errors.not-available', ['url' => $url]);
    }

    public function errorFailed()
    {
        return view('errors.failed');
    }

    public function errorLoginCanceled()
    {
        return view('errors.login-canceled');
    }
}