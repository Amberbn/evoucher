<?php
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
    Route::get('/cekdb', ['uses' => 'ApiController@index']);
    Route::post('/login', ['uses' => 'AuthController@login']);
    Route::get('campaign-csv', ['uses' => 'CampaignController@csv']);

    //ROUTE GROUP BY REQUIRED LOGIN

    Route::group(['middleware' => 'jwt.auth'], function () {

        //ROUTE PROFILE MANAGEMENT
        Route::get('/me', ['uses' => 'AuthController@getAuthUser']);
        Route::post('/me/change-password', ['uses' => 'AuthController@changePassword']);
        //END ROUTE FOR PROFILE MANAGEMENT

        //ROUTE FOR CLIENT MANAGEMENT
        Route::get('/client', ['uses' => 'ClientController@getClients']);
        Route::get('/client/{clientId}', ['uses' => 'ClientController@getClient']);
        Route::post('/client/store', ['uses' => 'ClientController@store']);
        Route::put('/client/update/{clientId}', ['uses' => 'ClientController@update']);
        Route::delete('/client/delete/{clientId}', ['uses' => 'ClientController@delete']);
        //END ROUTE FOR CLIENT MANAGEMENT

        //ROUTE FOR GLOBAL PARAMETER
        Route::get('/global-parameter', ['uses' => 'GlobalParameterController@getGlobalParameters']);
        Route::post('/global-parameter/store', ['uses' => 'GlobalParameterController@store']);
        Route::get('/global-parameter/{parameters_id}', ['uses' => 'GlobalParameterController@getGlobalParameter']);
        Route::put('/global-parameter/update/{parameters_id}', ['uses' => 'GlobalParameterController@update']);
        //END ROUTE FOR GLOBAL PARAMETER

        //ROUTE FOR USER
        Route::get('/user', ['uses' => 'UserController@getUsers']);
        Route::post('/user/store', ['uses' => 'UserController@store']);
        Route::get('/user/{id}', ['uses' => 'UserController@getUser']);
        Route::put('/user/update/{id}', ['uses' => 'UserController@update']);
        //END ROUTE FOR USER

        //ROUTE FOR ROLE MANAGEMENT
        Route::get('/role', ['uses' => 'RoleController@index']);
        Route::post('/role/store', ['uses' => 'RoleController@store']);
        Route::put('/role/update/{roleId}', ['uses' => 'RoleController@update']);
        Route::delete('/role/delete/{roleId}', ['uses' => 'RoleController@delete']);
        //END ROUTE FOR CLIENT MANAGEMENT

        //ROUTE FOR USERROLE
        Route::get('/user-role', ['uses' => 'UserRoleController@index']);
        Route::post('/user-role/store', ['uses' => 'UserRoleController@store']);

        Route::get('/user-role/{userRoleId}', ['uses' => 'UserRoleController@show']);
        Route::put('/user-role/update/{userRoleId}', ['uses' => 'UserRoleController@update']);
        //END ROUTE FOR USERROLE

        //ROUTE FOR MERCHANT
        Route::get('/merchant', ['uses' => 'MerchantController@index']);
        Route::post('/merchant/store', ['uses' => 'MerchantController@store']);
        Route::get('/merchant/{merchantId}', ['uses' => 'MerchantController@show']);
        Route::put('/merchant/update/{merchantId}', ['uses' => 'MerchantController@update']);
        //END ROUTE FOR MERCHANT

        //ROUTE FOR OUTLET MANAGEMENT
        Route::get('/outlets', ['uses' => 'OutletController@outlets']);
        Route::get('/outlet/{outletId}', ['uses' => 'OutletController@outlet']);
        Route::post('/outlet/store', ['uses' => 'OutletController@store']);
        Route::put('/outlet/update/{outletId}', ['uses' => 'OutletController@update']);
        Route::delete('/outlet/delete/{outletId}', ['uses' => 'OutletController@delete']);
        //END ROUTE FOR CLIENT MANAGEMENT

        //ROUTE FOR VOUCHER CATALOG
        Route::get('/voucher-catalog', ['uses' => 'VoucherCatalogController@index']);
        Route::get('/voucher-catalog/store', ['uses' => 'VoucherCatalogController@store']);
        //END ROUTER FOR CATALOG

        //ROUTE FOR VOUCHER CAMPAIGN
        Route::get('/campaign', ['uses' => 'CampaignController@getCampaigns']);
        Route::get('/campaign/{id}', ['uses' => 'CampaignController@getCampaign']);
        Route::post('/campaign/create', ['uses' => 'CampaignController@createCampaign']);
        //END ROUTER FOR CAMPAIGN

    });
    //END ROUTE GROUP BY REQUIRED LOGIN

});
