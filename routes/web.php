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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/account-closed', 'PageController@accountClosed');

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/close-account', 'HomeController@closeAccount')->name('closeAccount');
