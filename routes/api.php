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
    Route::post('/redeem/{voucherNumber}', ['uses' => 'RedeemController@redeem']);
    Route::get('/cekdb', ['uses' => 'ApiController@checkDB']);
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
        Route::get('/user-datatable', ['uses' => 'UserController@getUsersDatatable'])->name('users.datatable');
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
        Route::post('/voucher-catalog/store', ['uses' => 'VoucherCatalogController@store']);
        Route::put('/voucher-catalog/update/{voucheCatalogId}', ['uses' => 'VoucherCatalogController@update']);
        //END ROUTER FOR CATALOG

        //ROUTE FOR VOUCHER CATALOG OUTLET
        Route::get('/voucher-catalog-outlet/{nomorVoucher}', ['uses' => 'VoucherCatalogOutletController@index']);
        Route::post('/voucher-catalog-outlet/store', ['uses' => 'VoucherCatalogOutletController@store']);
        //END ROUTE FOR VOUCHER CATALOG OUTLET

        //ROUTE FOR VOUCHER CAMPAIGN
        Route::get('/campaign', ['uses' => 'CampaignController@getCampaigns']);
        Route::get('/campaign/{id}', ['uses' => 'CampaignController@getCampaign']);
        Route::post('/campaign/create', ['uses' => 'CampaignController@createCampaign']);
        Route::post('/campaign/recipient', ['uses' => 'CampaignController@createRecipient']);
        Route::get('/campaign-voucher', ['uses' => 'CampaignController@getCampaignVouchers']);
        Route::get('/campaign-voucher/{id}', ['uses' => 'CampaignController@getCampaignVoucher']);
        Route::get('/campaign-recipient', ['uses' => 'CampaignController@getCampaignRecipients']);
        Route::get('/campaign-recipient/{id}', ['uses' => 'CampaignController@getCampaignRecipient']);
        Route::post('/open-campaign', ['uses' => 'CampaignController@openCampaign']);
        //END ROUTER FOR CAMPAIGN

        Route::get('/resource', ['uses' => 'ResourceController@index']);

        //ROUTE FOR GENERATED VOUCHER
        Route::get('/generate-voucher/{id}', ['uses' => 'VoucherGeneratedController@generatedVoucher']);
        //END ROUTER FOR GENERATED VOUCHER

        //ROUTE FOR GENERAL SETTINGS
        Route::get('/general-setting/{parameter}', ['uses' => 'GeneralSetting@getSetting']);
        Route::get('/all-setting', ['uses' => 'GeneralSetting@getAllSettings']);
        //END ROUTER FOR GENERAL SETTINGS

    });
    //END ROUTE GROUP BY REQUIRED LOGIN

});
