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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function() {
    Route::get('/cekdb',['uses' => 'ApiController@index']);
    Route::get('/client',['uses' => 'ClientController@getClients']);
    Route::get('/clients/{clientId}',['uses' => 'ClientController@getClient']);
    Route::post('/client/store',['uses' => 'ClientController@store']);
    Route::post('/client/update',['uses' => 'ClientController@update']);

    Route::post('/login', ['uses' => 'AuthController@login']);

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('/me',['uses' => 'AuthController@getAuthUser']);
    });
});
