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

$app->get('/', [ 'as' => 'home', function () use ($app) {

    return view('errors.403');
}]);

$app->group([
    'as'     => 'error',
    'prefix' => 'error',
    'middleware' => ['throttle:20,4']
], function () use ($app) {

    $app->get('failed', [
        'as' => 'failed', 'uses' => 'PageController@errorFailed'
    ]);

    $app->get('not-available', [
        'as' => 'not-available', 'uses' => 'PageController@errorNotAvailable'
    ]);
});

$app->group([
        'middleware' => ['throttle:20,4', 'api.agent:internal']
], function () use ($app) {

    $app->get('to/{steamId}', [
        'as' => 'web.redirect.to', 'uses' => 'WebController@redirectTo'
    ]);

});

$app->group([
        'prefix' => 'api/v1',
        'middleware' => ['throttle:30,1', 'api.agent']
    ], function () use ($app) {

    $app->get('redirect/{steamId}/{playerIp}', [
        'as' => 'api.request', 'uses' => 'ApiController@redirectRequest'
    ]);

});