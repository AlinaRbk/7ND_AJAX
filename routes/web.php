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
    Route::get('indexAjax', 'App\Http\Controllers\ArticleController@indexAjax')->name('article.indexAjax');
    Route::post('storeAjax', 'App\Http\Controllers\ArticleController@storeAjax')->name('article.storeAjax');
    Route::post('deleteAjax/{article}', 'App\Http\Controllers\ArticleController@destroyAjax')->name('article.destroyAjax');
    Route::get('showAjax/{article}', 'App\Http\Controllers\ArticleController@showAjax')->name('article.showAjax');
    Route::post('updateAjax/{article}', 'App\Http\Controllers\ArticleController@updateAjax')->name('article.updateAjax');
    Route::get('searchAjax', 'App\Http\Controllers\ArticleController@searchAjax')->name('article.searchAjax');

});

Route::prefix('types')->group(function() {
    Route::get('', 'App\Http\Controllers\TypeController@index')->name('type.index');
    Route::get('indexAjax', 'App\Http\Controllers\TypeController@indexAjax')->name('type.indexAjax');
    Route::post('storeAjax', 'App\Http\Controllers\TypeController@storeAjax')->name('type.storeAjax');
    Route::post('deleteAjax/{type}', 'App\Http\Controllers\TypeController@destroyAjax')->name('type.destroyAjax');
    Route::get('showAjax/{type}', 'App\Http\Controllers\TypeController@showAjax')->name('type.showAjax');
    Route::post('updateAjax/{type}', 'App\Http\Controllers\TypeController@updateAjax')->name('type.updateAjax');
    Route::get('searchAjax', 'App\Http\Controllers\TypeController@searchAjax')->name('type.searchAjax');


});