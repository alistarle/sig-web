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

Route::get('/', 'UserController@index');
Route::get('/polygon', 'MapController@polygon');

Route::group(['prefix' => 'api'], function () {
    Route::post('register', 'UserController@store');
    Route::get('user/{device}', 'UserController@get');
    Route::get('user/{device}/hunts', 'HuntController@index');
    Route::get('user/{device}/reset', 'UserController@reset');
    Route::get('user/{device}/hunt/{hunt}', 'HuntController@get');
    Route::patch('user/{device}/hunt/{hunt}', 'UserController@hunt');

    Route::post('hunt/store', 'HuntController@store');
    Route::delete('hunt/{hunt}', 'HuntController@delete');
    Route::patch('hunt/{hunt}', 'HuntController@update');
    Route::get('hunt/highscore', 'HuntController@highscore');
});
