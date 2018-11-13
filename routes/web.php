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
Route::post('/keyword_authors', 'IndexController@keyword_authors');
Route::post('/author_keywords', 'IndexController@author_keywords');
// Route::get('/search-keyword', 'KeywordController@searchFromAPI');
Route::get('/keyword_show', 'KeywordController@detail');
Route::get('/data_show', 'KeywordController@searchEvent');
Route::get('/author_show', 'KeywordController@searchAuthor');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

// Route::get('/reddit', 'RedditDataController@filter');
// Route::get('/twitter', 'TwitterDataController@filter');
// Route::get('/search-twitter', 'TwitterDataController@search');
// Route::get('/search-reddit', 'RedditDataController@search');



