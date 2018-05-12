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

Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function () {
    Route::get('/cekdb/', ['uses' => 'ApiController@index']);
    Route::post('/login', ['uses' => 'AuthController@login']);

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('/me', ['uses' => 'AuthController@getAuthUser']);
        Route::get('/client', ['uses' => 'ClientController@getClients']);
        Route::get('/client/{clientId}', ['uses' => 'ClientController@getClient']);
        Route::post('/client/store', ['uses' => 'ClientController@store']);
        Route::put('/client/update/{clientId}', ['uses' => 'ClientController@update']);
        Route::post('/client/delete/{clientId}', ['uses' => 'ClientController@delete']);

        //ROUTE FOR GLOBAL PARAMETER
        Route::get('/global-parameter', ['uses' => 'GlobalParameterController@getGlobalParameters']);
        Route::post('/global-parameter/store', ['uses' => 'GlobalParameterController@store']);
        Route::get('/global-parameter/{parameters_id}', ['uses' => 'GlobalParameterController@getGlobalParameter']);
        Route::post('/global-parameter/update/{parameters_id}', ['uses' => 'GlobalParameterController@update']);
        //END ROUTE FOR GLOBAL PARAMETER

        //ROUTE FOR USER
        Route::get('/user', ['uses' => 'UserController@getUsers']);
        Route::post('/user/store', ['uses' => 'UserController@store']);
        Route::get('/user/{id}', ['uses' => 'UserController@getUser']);
        Route::post('/user/update/{id}', ['uses' => 'UserController@update']);
        //END ROUTE FOR USER

        Route::get('/role', ['uses' => 'RoleController@index']);
        Route::post('/role/store', ['uses' => 'RoleController@store']);
        Route::put('/role/update/{roleCode}', ['uses' => 'RoleController@update']);
        Route::post('/role/delete/{roleCode}', ['uses' => 'RoleController@delete']);
    });
});
