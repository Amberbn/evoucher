<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Auth::routes();
Route::get('/redeem/{voucherId}', 'Web\RedeemController@redeem')->name('voucher.get.outlet');
Route::post('/redeem/{voucherId}', 'Web\RedeemController@redeemSave')->name('voucher.save.outlet');
Route::get('/', 'Web\HomeController@index');
Route::get('/welcome', 'Web\WelcomeController@welcome');
Route::get('/terms-and-condition', 'Web\WelcomeController@termsAndCondition');
Route::middleware(['auth', 'check-permission'])->group(function () {
    Route::get('/home', 'Web\HomeController@index')->name('home');
    Route::get('/chage-password', 'Web\AccountController@index')->name('account.change.password');
    Route::post('/chage-password', 'Web\AccountController@changePassword')->name('user.change.password');
    Route::resource('/user', 'Web\UserController');
    Route::put('/user-delete', 'Web\UserController@destroyFromArray')->name('users.delete.custom');
    Route::get('/users', 'Web\UserController@indexDatatable')->name('user.list.datatable');
    Route::resource('/client', 'Web\ClientController');
    Route::put('/client-detete', 'Web\ClientController@destroyFromArray')->name('clients.delete.custom');
    Route::get('/clients', 'Web\ClientController@indexDatatable')->name('client.list.datatable');
    Route::get('/general-setting/{param}/{parent?}', 'Web\GeneralSettingController@index')->name('chain.dropdown');

    Route::resource('/merchant', 'Web\MerchantController');
    Route::get('/merchants', 'Web\MerchantController@indexDatatable')->name('merchant.list.datatable');
    Route::put('/merchant-detete', 'Web\MerchantController@destroyFromArray')->name('merchant.delete.custom');

    Route::resource('/outlet', 'Web\OutletController');
    Route::get('/outlet-create/{id}', 'Web\OutletController@create')->name('merchant.outlet.create');
    Route::post('/outlet-create/{id}', 'Web\OutletController@store')->name('merchant.outlet.store');

    Route::get('/vouchers', 'Web\VoucherController@index')->name('voucher.index');

    Route::post('/save-voucher-profile', 'Web\VoucherController@saveVoucherProfile')->name('voucher.profile.store');
    Route::get('/voucher-form-detail/{id}', 'Web\VoucherController@voucherDetail')->name('voucher.detail');
    Route::post('/save-voucher-detail/{id}', 'Web\VoucherController@saveVoucherDetail')->name('voucher.detail.store');
    Route::get('/voucher-form-merchant/{id}', 'Web\VoucherController@voucherMercant')->name('voucher.merchant');
    Route::post('/save-form-merchant/{id}', 'Web\VoucherController@saveVoucherMercant')->name('voucher.merchant.store');

    Route::get('/outlet-by-merchant/{id}', 'Web\VoucherController@getOutlet')->name('voucher.get.outlet');

    
});
