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

Route::get('/', 'Plugin\PluginController@index')->name('home');

Auth::routes();

Route::resource('plugins', 'Plugin\PluginController', ['except' => 'show']);

Route::group(['prefix' => 'plugins'], function () {
    Route::group(['prefix' => '{plugin}/files'], function () {
        Route::get('/', 'Plugin\File\PluginFileController@index')->name('plugins.files.index');

        Route::post('/', 'Plugin\File\PluginFileController@store')->name('plugins.files.store');

        Route::get('create','Plugin\File\PluginFileController@create')->name('plugins.files.create');

        Route::group(['prefix' => '{pluginFile}'], function () {
            Route::get('download', 'Plugin\File\PluginFileDownloadController')->name('plugins.files.download');

            Route::get('edit', 'Plugin\File\PluginFileController@edit')->name('plugins.files.edit');

            Route::put('/', 'Plugin\File\PluginFileController@update')->name('plugins.files.update');

            Route::get('/', 'Plugin\File\PluginFileController@show')->name('plugins.files.show');

            Route::delete('/', 'Plugin\File\PluginFileController@destroy')->name('plugins.files.destroy');
        });
    });

    Route::get('{slug}/{plugin}', 'Plugin\PluginController@show')->name('plugins.show');
});
