<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/exchange', 'ExchangeDataController@index');
Route::get('/exchange/{coin_name}', 'ExchangeDataController@get_currency');
Route::get('/exchange/{coin_name}/{convert}', 'ExchangeDataController@convert_currency');
Route::get('/news', 'ExchangeDataController@latest_news');
