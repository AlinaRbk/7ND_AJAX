<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('articles')->group(function() {
    Route::get('', 'App\Http\Controllers\ArticleController@index')->name('article.index');
    Route::post('storeAjax', 'App\Http\Controllers\ArticleController@storeAjax')->name('article.storeAjax');


});

Route::prefix('types')->group(function() {
    Route::get('', 'App\Http\Controllers\TypeController@index')->name('type.index');
    Route::post('storeAjax', 'App\Http\Controllers\TypeController@storeAjax')->name('type.storeAjax');
    Route::post('deleteAjax/{type}', 'App\Http\Controllers\TypeController@destroyAjax')->name('type.destroyAjax');
    Route::get('showAjax/{type}', 'App\Http\Controllers\TypeController@showAjax')->name('type.showAjax');
    Route::post('updateAjax/{type}', 'App\Http\Controllers\TypeController@updateAjax')->name('type.updateAjax');


});