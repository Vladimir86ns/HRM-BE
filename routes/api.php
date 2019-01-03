<?php

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

        // ACCOUNT
        $api->group(['prefix' => 'account'], function ($api) {
            $api->post('create', 'AccountController@create');
            $api->get('/{id}', 'AccountController@getAccount');
            $api->get('/{id}/companies', 'AccountController@getCompanies');
        });

        // COMPANY
        $api->group(['prefix' => 'company'], function ($api) {
            $api->get('/{id}', 'CompanyController@getCompany');
            $api->get('/{id}/employees', 'CompanyController@getCompanyEmployees');
            $api->patch('/{id}', 'CompanyController@updateCompanyInfo');
            $api->post('save_comphp apany_settings', 'CompanyController@saveCompanyInfo');

            // POSITIONS
            $api->group(['prefix' => 'positions'], function ($api) {
                $api->post('/save', 'PositionController@bulkSave');
            });
        });

        // USER
        $api->group(['prefix' => 'user'], function ($api) {
            $api->get('/{id}', 'UserController@getUser');
            $api->patch('/{id}/update', 'UserController@updateProfile');
        });

    });
});
