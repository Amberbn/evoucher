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
Route::middleware('auth')->group(function () {
    Route::get('/home', 'Web\HomeController@index')->name('home');
    Route::get('/chage-password', 'Web\AccountController@changePassword')->name('account.change.password');
    Route::resource('/user', 'Web\UserController');
    Route::get('/users', 'Web\UserController@indexDatatable')->name('user.list.datatable');
    Route::resource('/client', 'Web\ClientController');
    Route::get('/clients', 'Web\ClientController@indexDatatable')->name('client.list.datatable');
    Route::get('/general-setting/{param}/{parent?}', 'Web\GeneralSettingController@index')->name('chain.dropdown');
});
