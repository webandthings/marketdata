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

//List
Route::get('articles', 'ArticleController@index');

//Get one
Route::get('article/{id}', 'ArticleController@show');

//Create new
Route::post('article', 'ArticleController@store');

//Edit id
Route::put('article/{id}', 'ArticleController@store');

//Delete id
Route::delete('article/{id}', 'ArticleController@destroy');
