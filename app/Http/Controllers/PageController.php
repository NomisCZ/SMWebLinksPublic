<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function errorNotAvailable(Request $request) {

        $url = $request->input('url');

        return view('errors.not-available', ['url' => $url]);
    }

    public function errorFailed() {

        return view('errors.failed');
    }
}