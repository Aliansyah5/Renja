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

Auth::routes([
    'register' => false,
    'reset' => false,
]);

Route::get('/', 'HomeController@index')->name('home');

Route::get('/userguide', 'SecurityController@userguide')->name('userguide');
Route::match(['get', 'post'], '/security', 'SecurityController@security')->name('security');

Route::prefix('/master')->name('master.')->group(function () {
    Route::prefix('/template')->name('template.')->group(function () {
        Route::get('/', 'TemplateController@index')->name('index');
        Route::post('/', 'TemplateController@store')->name('store');
        Route::get('/create', 'TemplateController@create')->name('create');
        Route::get('/datatables', 'TemplateController@datatables')->name('datatables');
        Route::get('/{id}', 'TemplateController@edit')->name('edit');
        Route::post('/{id}', 'TemplateController@update')->name('update');
        Route::get('/{id}/bg/{side}', 'TemplateController@show_bg')->name('show_bg');
    });

    Route::prefix('/karyawan')->name('karyawan.')->group(function () {
        Route::get('/', 'KaryawanController@index')->name('index');
        Route::get('/datatables', 'KaryawanController@datatables')->name('datatables');
    });
    
    Route::prefix('/kartu')->name('kartu.')->group(function () {
        Route::get('/', 'KaryawanController@kartu_index')->name('index');
        Route::get('/datatables', 'KaryawanController@kartu_datatables')->name('datatables');
    });
});

Route::prefix('/kartu')->name('kartu.')->group(function () {
    Route::get('/', 'KartuController@index')->name('index');
    Route::post('/', 'KartuController@store')->name('store');
    Route::get('/datatables', 'KartuController@datatables')->name('datatables');
    Route::post('/print', 'KartuController@print')->name('print');
    Route::get('/temp_foto', 'KartuController@temp_foto')->name('temp_foto');
});
