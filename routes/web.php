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

Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->name('home');
Route::get('/plugins', 'Plugin\PluginController@index')->name('plugins.index');
Route::post('/plugins', 'Plugin\PluginController@store')->name('plugins.store');
Route::get('/plugins/create', 'Plugin\PluginController@create')->name('plugins.create');

Route::middleware(StripPluginSlug::class)->prefix('/plugins/{plugin_slug}/{plugin}')->group(function () {
    Route::get('/', 'Plugin\PluginController@show')->name('plugins.show');
    Route::get('/edit', 'Plugin\PluginController@edit')->name('plugins.edit');
    Route::patch('/', 'Plugin\PluginController@update')->name('plugins.update');
    Route::delete('/', 'Plugin\PluginController@destroy')->name('plugins.destroy');

    Route::prefix('/files')->group(function () {
        Route::post('/', 'Plugin\PluginFileController@store')->name('plugins.files.store');
        Route::get('/create', 'Plugin\PluginFileController@create')->name('plugins.files.create');
        Route::delete('/{pluginFile}', 'Plugin\PluginFileController@destroy')->name('plugins.files.destroy');

        Route::get('/{pluginFile}/download', 'Plugin\PluginFileDownloadController@show')->name('plugins.files.download');
    });
});
