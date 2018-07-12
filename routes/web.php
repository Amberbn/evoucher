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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'web\AuthController@index')->name('auth.form');
Route::post('/', 'web\AuthController@login')->name('auth.login');
Route::middleware(['login-session'])->group(function () {
    Route::get('/logout', 'web\AuthController@logout')->name('auth.logout');
    Route::resource('/user', 'web\UserController');
    Route::get('/client', 'web\ClientController@index')->name('client');
});
