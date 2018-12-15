<?php

use App\Http\Middleware\Plugin\StripPluginSlug;

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

Route::get('/plugins', 'Plugin\PluginController@index')->name('plugins.index');
Route::post('/plugins', 'Plugin\PluginController@store')->name('plugins.store');
Route::get('/plugins/create', 'Plugin\PluginController@create')->name('plugins.create');

Route::middleware(StripPluginSlug::class)->group(function () {
    Route::get('/plugins/{plugin_slug}/{plugin}', 'Plugin\PluginController@show')->name('plugins.show');
    Route::get('/plugins/{plugin_slug}/{plugin}/edit', 'Plugin\PluginController@edit')->name('plugins.edit');
    Route::patch('/plugins/{plugin_slug}/{plugin}', 'Plugin\PluginController@update')->name('plugins.update');
    Route::delete('/plugins/{plugin_slug}/{plugin}', 'Plugin\PluginController@destroy')->name('plugins.destroy');

    Route::post('/plugins/{plugin_slug}/{plugin}/files', 'Plugin\PluginFileController@store')->name('plugins.files.store');
    Route::get('/plugins/{plugin_slug}/{plugin}/files/create', 'Plugin\PluginFileController@create')->name('plugins.files.create');
    Route::delete('/plugins/{plugin_slug}/{plugin}/files/{pluginFile}', 'Plugin\PluginFileController@destroy')->name('plugins.files.destroy');

    Route::get('/plugins/{plugin_slug}/{plugin}/files/{pluginFile}/download', 'Plugin\PluginFileDownloadController@show')->name('plugins.files.download');
});

Route::get('/', 'HomeController@index')->name('home');

Auth::routes(['verify' => true]);
