<?php

// use Illuminate\Http\Request;

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

Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function() {
    Route::get('/cekdb/',['uses' => 'ApiController@index']);
    Route::post('/login', ['uses' => 'AuthController@login']);

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('/me',['uses' => 'AuthController@getAuthUser']);
        Route::get('/client',['uses' => 'ClientController@getClients']);
        Route::get('/client/{clientId}',['uses' => 'ClientController@getClient']);
        Route::post('/client/store',['uses' => 'ClientController@store']);
        Route::post('/client/update/{clientId}',['uses' => 'ClientController@update']);
        Route::post('/client/delete/{clientId}',['uses' => 'ClientController@delete']);

        Route::get('/global-parameter/{parameters_id}',['uses' => 'GlobalParameterController@getGlobalParameter']);

        Route::get('/role',['uses' => 'RoleController@index']);
        Route::post('/role/store',['uses' => 'RoleController@store']);
        Route::put('/role/update/{roleCode}',['uses' => 'RoleController@update']);
        Route::post('/role/delete/{roleCode}',['uses' => 'RoleController@delete']);
    });
});
