<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', ['as' => 'index', 'uses' => 'PageController@index']);

$router->group([
    'as'     => 'error',
    'prefix' => 'error',
    'middleware' => ['throttle:20,4']
], function () use ($router) {

    $router->get('failed', [
        'as' => 'failed', 'uses' => 'PageController@errorFailed'
    ]);

    $router->get('not-available', [
        'as' => 'not-available', 'uses' => 'PageController@errorNotAvailable'
    ]);

    $router->get('login-canceled', [
        'as' => 'login-canceled', 'uses' => 'PageController@errorLoginCanceled'
    ]);
});

// => Auth
$router->group([
    'as'     => 'auth',
    'prefix' => 'auth',
    'middleware' => ['throttle:5', 'api.agent:internal']
], function () use ($router) {

    $router->get('logout', [
        'as' => 'logout', 'uses' => 'PageController@logout'
    ]);

    $router->get('provider/steam', [
        'as' => 'provider.steam', 'uses' => 'Auth\SteamController@login'
    ]);
});

$router->group([
        'middleware' => ['throttle:20', 'api.agent:internal']
], function () use ($router) {

    /**
     * @deprecated Redirect for old plugin version
     */
    $router->get('to/{steamId:[0-9]{17}}', [
        'as' => 'web.redirect.to', 'uses' => 'WebController@redirectTo'
    ]);

    $router->get('method/{fetchMethod:ip|steamid}', [
        'as' => 'web.redirect.method', 'uses' => 'WebController@redirectMethod'
    ]);

    $router->get('method/{fetchMethod:steamid}/{steamId:[0-9]{17}}', [
        'as' => 'web.redirect.method.steamId', 'uses' => 'WebController@redirectMethod'
    ]);
});

/**
 * @deprecated Api for old plugin version
 */
$router->group([
    'prefix' => 'api/v1',
    'middleware' => ['throttle:60', 'api.agent']
], function () use ($router) {

    $router->get('redirect/{steamId}/{playerIp}', [
        'as' => 'api.request', 'uses' => 'ApiController@redirectRequest'
    ]);
});

$router->group([
    'prefix' => 'api/v2',
    'middleware' => ['throttle:60', 'api.agent']
], function () use ($router) {

    $router->post('request/create', [
        'as' => 'api.request.create', 'uses' => 'Api\ApiV2Controller@createRequest'
    ]);
});