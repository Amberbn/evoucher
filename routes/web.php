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
Route::get('/', 'Web\HomeController@index');
Route::get('/welcome', 'Web\WelcomeController@welcome');
Route::get('/terms-and-condition', 'Web\WelcomeController@termsAndCondition');
Route::middleware(['auth', 'check-permission'])->group(function () {
    Route::get('/home', 'Web\HomeController@index')->name('home');
    Route::get('/chage-password', 'Web\AccountController@index')->name('account.change.password');
    Route::post('/chage-password', 'Web\AccountController@changePassword')->name('user.change.password');
    Route::resource('/user', 'Web\UserController');
    Route::put('/user-delete', 'Web\UserController@destroyFromArray')->name('users.delete');
    Route::get('/users', 'Web\UserController@indexDatatable')->name('user.list.datatable');
    Route::resource('/client', 'Web\ClientController');
    Route::put('/client-detete', 'Web\ClientController@destroyFromArray')->name('clients.delete');
    Route::get('/clients', 'Web\ClientController@indexDatatable')->name('client.list.datatable');
    Route::get('/general-setting/{param}/{parent?}', 'Web\GeneralSettingController@index')->name('chain.dropdown');

    Route::resource('/merchant', 'Web\MerchantController');
    Route::get('/merchants', 'Web\MerchantController@indexDatatable')->name('merchant.list.datatable');
    // Route::get('/merchant/create', 'Web\MerchantController@create')->name('merchant.create');
    //  Route::post('/merchant/create', 'Web\MerchantController@create')->name('merchant.save');
});
