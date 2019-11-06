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

Route::get('/','PhotoController@index');
Route::resource('photos', 'PhotoController');
// w = width, h = height, img = imagename, 
Route::get('showimage/{w}/{h}/{img}','PhotoController@generateImage')->where(['w' => '[0-9]+','h' => '[0-9]+', 'name' => '[a-z]+'])->name('generateImage');
// Auth::routes();
Route::post('downloadall', 'PhotoController@createZip')->name('createzip');
Route::get('downloadall/{filename}', 'PhotoController@downloadAll')->name('downloadall');