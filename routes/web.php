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

Route::get('/', 'IndexController@show');

Route::get('/twitter', function () {
    return view('twitter');
});

Route::get('/reddit', 'RedditDataController@filter');
Route::get('/twitter', 'TwitterDataController@filter');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/twitter-datas', function () {
// 	$datas = DB::table('twitter_datas')->get();
//     return view('data', compact('datas'));
// });

Route::get('/result', function () {
    return view('result');
});

Route::get('/search-twitter', 'TwitterDataController@search');
Route::get('/search-reddit', 'RedditDataController@search');

Route::get('/search-keyword', 'KeywordController@search');
// Route::get('/keyword_show', 'KeywordController@detail');
Route::get('/keyword_show', function () {
    return view('keyword_show');
});
// Route::get('/search/{word}', 'KeywordController@getKeyword');
