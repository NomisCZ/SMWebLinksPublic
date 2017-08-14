<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Validator;

class WebController extends Controller
{
    private $requestData;
    private $localData;

    public function redirectTo(Request $request, $steamId) {

        $this->requestData = array(
            'clientIp' => $request->ip(),
            'steamId' => $steamId,
        );

        if (!$this->validateRequestData() || !Cache::has($steamId)) {

            return view('errors.failed');
        }

        $this->localData = json_decode(Cache::pull($this->requestData['steamId']));

        if (!$this->validateRequestIps()) {

            return view('redirect-internal', ['url' => route('error.failed')]);
        }

        if (!isValidURL($this->localData->url)) {

            return view('redirect-internal', ['url' => route('error.not-available', ['url' => $this->localData->url])]);
        }

        return view('redirect', ['requestData' => $this->localData]);
    }

    private function validateRequestIps() {

        return ($this->requestData['clientIp'] == $this->localData->playerIp) ? true : false;
    }

    private function validateRequestData() {

        $validator = Validator::make($this->requestData, [
            'steamId' => 'required|size:17',
        ]);

        return ($validator->fails()) ? false : true;
    }

}