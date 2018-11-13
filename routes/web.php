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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/plugins', 'Plugin\PluginController@index')->name('plugins.index');
Route::post('/plugins', 'Plugin\PluginController@store')->name('plugins.store');
Route::get('/plugins/create', 'Plugin\PluginController@create')->name('plugins.create');
Route::get('/plugins/{slug}/{plugin}', 'Plugin\PluginController@show')->name('plugins.show');

Route::post('/plugins/{slug}/{plugin}/files', 'Plugin\PluginFileController@store')->name('plugins.files.store');

Auth::routes(['verify' => true]);
