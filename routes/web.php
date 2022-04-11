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

Route::get('/', 'UlLocalizationController@index')->name('index');
Route::get('/buscar/{termo?}/', 'UlLocalizationController@buscar')->name('buscar');
Route::post('/salvar', 'UlLocalizationController@salvar')->name('salvar');
Route::post('/upload', 'UlLocalizationController@upload')->name('upload_localization');
Route::get('/exportcsv', 'UlLocalizationController@exportCsv')->name('exportCsv');
