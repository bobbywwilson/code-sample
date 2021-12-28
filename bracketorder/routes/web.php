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

Auth::routes();

Route::prefix('dashboard')->group(function () {
    Route::get('/', 'AccountController@index');
    Route::get('/news/news-carousel', 'NewsController@getTopNews');
    Route::get('/news/news-article', 'NewsController@getNewsArticle');
    Route::get('/get-indicator', 'ChartController@getIndicator');
    Route::get('/bracketorder{params?}', 'BracketOrderController@bracketOrder');
    Route::get('/technicals{params?}', 'TechnicalsController@getTechnicals');

    Route::get('/chart', 'ChartController@getChart');
});

// Route::get('/', 'AccountController@index');

// Route::get('/desktop', 'HomeController@index');
// Route::get('/desktop/market-quote', 'AccountController@marketQuote');
// Route::get('/desktop/stock-quote{params?}', 'BracketOrderController@getQuote');
// Route::get('/desktop/bracketorder{params?}', 'BracketOrderController@bracketOrder');
// Route::get('/desktop/market-technicals{params?}', 'TechnicalsController@MarketTechnicals');
// Route::get('/desktop/technicals{params?}', 'TechnicalsController@getTechnicals');
// Route::get('/desktop/watchlist', 'WatchlistController@showWatchlist');
// Route::get('/desktop/watchlist-desktop', 'WatchlistController@showDesktopWatchlist');
// Route::get('/desktop/get-watchlist{params?}', 'WatchlistController@getWatchlist');
// Route::get('/desktop/watchlist-button{params?}', 'WatchlistController@addWatchlistButton');


// Route::get('/mobile/new/charts/basic-chart', 'MobileChart@ChartController');



Route::get('logout', 'Auth\LoginController@logout');
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

// Route::get('/privacy', 'DisclosureController@privacy');
// Route::get('/{params?}', 'AccountController@index');
// Route::get('/market-quote', 'AccountController@marketQuote');
// Route::get('/market-technicals{params?}', 'TechnicalsController@MarketTechnicals');
// Route::get('/news/top-news', 'NewsController@getTopNews');
// Route::get('/news/business', 'NewsController@getBusinessNews');
// Route::get('/news/technology', 'NewsController@getTechnologyNews');
// Route::get('/news/us', 'NewsController@getUSNews');
// Route::get('/news/world', 'NewsController@getWorldNews');
// Route::get('/watchlist', 'WatchlistController@showWatchlist');
// Route::get('/watchlist-desktop', 'WatchlistController@showDesktopWatchlist');
// Route::get('/add-to-watchlist{params?}', 'WatchlistController@addToWatchlist');
// Route::get('/delete-watchlist{params?}', 'WatchlistController@DeleteWatchlist');
// Route::get('/get-watchlist{params?}', 'WatchlistController@getWatchlist');
// Route::get('/watchlist-button{params?}', 'WatchlistController@addWatchlistButton');
// Route::get('/chart-settings{params?}', 'ChartController@addChartSettings');
// Route::get('/save-chart{params?}', 'ChartController@saveChart');
// Route::get('/get-indicator', 'ChartController@getIndicator');
// Route::get('/get-sma', 'ChartController@getSMA');
// Route::get('/stock-quote{params?}', 'BracketOrderController@getQuote');
// Route::get('/bracketorder{params?}', 'BracketOrderController@bracketOrder');
// Route::get('/profile{params?}', 'FundamentalsController@getProfile');
// Route::get('/technicals{params?}', 'TechnicalsController@getTechnicals');
// Route::get('/stock-news{params?}', 'BracketOrderController@getNews');


