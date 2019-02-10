<?php

namespace App\Http\Controllers;

use App\Classes\AppResponseVDF;

use Cache;
use Illuminate\Http\Request;
use Validator;

/**
 * Class ApiController
 * @package App\Http\Controllers
 * @deprecated Api for old plugin version
 */
class ApiController extends Controller
{
    private $requestData;

    public function redirectRequest(Request $request, $steamId, $playerIp)
    {
        $this->requestData = [
            'serverIp' => $request->ip(),
            'steamId' => $steamId,
            'playerIp' => $playerIp,
            'url' => $request->input('url'),
            'customParams' => $request->input('params'),
        ];

        $this->validateRequestData();
        $this->createRedirectRequest();
    }

    private function createRedirectRequest()
    {
        $cacheData = json_encode([
            'steamId' => $this->requestData['steamId'],
            'serverIp' => $this->requestData['serverIp'],
            'playerIp' => $this->requestData['playerIp'],
            'url' => $this->requestData['url'],
            'customParams' => $this->requestData['customParams'],
            'created_at' => time(),
        ]);

        Cache::put($this->requestData['steamId'], $cacheData, env('CACHE_TIME', 5));

        AppResponseVDF::sendSuccess([
            'code'      => '200',
            'http_code' => 'API_REQUEST_SUCCESS',
            'message' => 'WEB LINKS REQUEST CREATED'
        ]);
    }

    private function validateRequestData()
    {
        $validator = Validator::make($this->requestData, [
            'steamId' => 'required|digits:17',
            'playerIp' => 'required|ip',
            'url' => 'required|url',
            'customParams' => 'required',
        ]);

        if ($validator->fails() || ($this->requestData['serverIp'] === $this->requestData['playerIp'])) {

            AppResponseVDF::sendError([
                'code'      => '400',
                'http_code' => 'API_PREPROCESS_CHECK_FAILED',
                'message' => 'There is an error processing your request. Please check your request and try again later.'
            ]);
        }
    }
}
