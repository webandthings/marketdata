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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/exchange', 'ExchangeDataController@index');
Route::get('/exchange/{coin_name}', 'ExchangeDataController@get_currency');
Route::get('/exchange/{coin_name}/{convert_to}', 'ExchangeDataController@convert_currency');
Route::get('/news', 'ExchangeDataController@latest_news');

