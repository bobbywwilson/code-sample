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

Route::get('/welcome', function () {
    return view('welcome');
});

Route::group(['prefix' => 'api'], function () {
//    Route::get('/bracketorder{params?}', 'BracketOrderController@getBracket')->where('params', '&from={from}&to={to}');
    Route::get('/account', 'BracketOrderController@index');
    Route::get('/chart-data{params?}', 'BracketOrderController@chartData');
    Route::get('/bracketorder{params?}', 'BracketOrderController@getBracket');
    Route::get('/bracketorder/historical-accuracy{params?}', 'BracketOrderController@getBracketAccuracy')->where('params', '&from={from}&to={to}');
});

Route::group(['prefix' => 'api/markets'], function () {
    Route::get('/', 'MarketController@getMarkets');
});

Route::group(['prefix' => 'api/quote'], function () {
    Route::get('/', 'BracketOrderController@getQuote');
});

Route::group(['prefix' => 'api/charts'], function () {
    Route::get('{params?}', 'ChartController@getDefaultChart');
});

Route::group(['prefix' => 'api/fundamentals'], function () {
    Route::get('{params?}', 'FundamentalsController@getFundamentals');
});

Route::group(['prefix' => 'api/technicals'], function () {
    Route::get('{params?}', 'TechnicalsController@getTechnicals');
});

Route::group(['prefix' => 'api/symbols'], function () {
    Route::get('{params?}', 'BracketOrderController@getSymbols');
});