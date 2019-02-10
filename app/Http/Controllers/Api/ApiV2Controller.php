<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Cache;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Classes\AppResponseVDF;

class ApiV2Controller extends Controller
{
    private $requestData;

    public function createRequest(Request $request)
    {
        $this->requestData = [
            'serverIp' => $request->ip(),
            'steamId' => $request->steamId,
            'playerIp' => $request->playerIp,
            'url' => $request->url,
            'fetchMethod' => $request->fetchMethod,
            'customParams' => $request->customParams,
        ];

        $this->validateRequestData();
        $this->cacheRequest();
    }

    private function cacheRequest()
    {
        $cacheData = json_encode([
            'steamId' => $this->requestData['steamId'],
            'serverIp' => $this->requestData['serverIp'],
            'playerIp' => $this->requestData['playerIp'],
            'url' => $this->requestData['url'],
            'fetchMethod' => $this->requestData['fetchMethod'],
            'customParams' => $this->requestData['customParams'],
            'created_at' => time(),
        ]);

        $cacheKey = $this->requestData['playerIp'];

        if ($this->requestData['fetchMethod'] === 'steamid') {

            $cacheKey = $this->requestData['steamId'];
        }

        Cache::put($cacheKey, $cacheData, env('CACHE_TIME', 5));

        AppResponseVDF::sendSuccess(array(
            'code' => '200',
            'http_code' => 'API_REQUEST_SUCCESS',
            'message' => 'WEB LINKS REQUEST CREATED',
        ));
    }

    private function validateRequestData()
    {
        $validator = Validator::make($this->requestData, [
            'steamId' => 'required|digits:17',
            'playerIp' => 'required|ip',
            'url' => 'required|url',
            'fetchMethod' => 'required', Rule::in(['ip', 'steamid']),
            'customParams' => 'required',
        ]);

        if ($validator->fails() || ($this->requestData['serverIp'] === $this->requestData['playerIp'])) {

            AppResponseVDF::sendError([
                'code' => '400',
                'http_code' => 'API_PREPROCESS_CHECK_FAILED',
                'message' => 'There is an error processing your request. Please check your request and try again later.',
            ]);
        }
    }
}
