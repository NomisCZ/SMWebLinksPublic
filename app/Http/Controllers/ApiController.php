<?php

namespace App\Http\Controllers;

use App\Classes\AppResponseVDF;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Validator;

class ApiController extends Controller
{
    private $requestData;

    public function redirectRequest(Request $request, $steamId, $playerIp) {

        $this->requestData = array(
            'serverIp' => $request->ip(),
            'steamId' => $steamId,
            'playerIp' => $playerIp,
            'url' => $request->input('url'),
            'customParams' => $request->input('params'),
        );

        $this->validateRequestData();
        $this->createRedirectRequest();

        AppResponseVDF::sendSuccess(array(
            'code'      => '200',
            'http_code' => 'API_REQUEST_SUCCESS',
            'message' => 'WEB LINKS REQUEST CREATED'
        ));
    }

    private function createRedirectRequest() {

        $cacheData = json_encode(array(
            'steamId' => $this->requestData['steamId'],
            'serverIp' => $this->requestData['serverIp'],
            'playerIp' => $this->requestData['playerIp'],
            'url' => $this->requestData['url'],
            'customParams' => $this->requestData['customParams'],
            'created_at' => time(),
        ));

        Cache::put($this->requestData['steamId'], $cacheData, env('CACHE_TIME', 5));
    }

    private function validateRequestData() {

        $validator = Validator::make($this->requestData, [
            'steamId' => 'required|size:17',
            'playerIp' => 'required|ip',
            'url' => 'required|url',
            'customParams' => 'required',
        ]);

        if ($validator->fails() || ($this->requestData['serverIp'] == $this->requestData['playerIp'])) {

            AppResponseVDF::sendError(array(
                'code'      => '400',
                'http_code' => 'API_PREPROCESS_CHECK_FAILED',
                'message' => 'There is an error processing your request. Please check your request and try again later.'
            ));
        }
    }

}
