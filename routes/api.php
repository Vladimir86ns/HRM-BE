<?php

use Illuminate\Http\Request;
use Dingo\Api\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
$api = app(Router::class);

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

$api->version('v1', function ($api) {
    $api->group(['namespace' => 'App\Http\Controllers', 'middleware' => 'api'], function (Router $api) {
        $api->get('register-test', 'KreiramController@test');
    });
});
