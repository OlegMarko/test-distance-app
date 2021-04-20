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

Route::group(['prefix' => '/route'], function ()  {
    Route::get('/graph', 'RouteController@getGraph');
});

Route::group(['prefix' => '/upload-file'], function () {
    Route::get('/', 'UploadRouteController@uploadForm');
    Route::post('/', 'UploadRouteController@uploadFile');
});
