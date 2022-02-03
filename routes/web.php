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

Route::prefix('/form')->name('form.')->group(function(){
    Route::get('renja/getnoform', 'FormRenjaController@getNoForm')->name('renja.getNoForm');
    Route::get('renja/datatable', 'FormRenjaController@getDatatable')->name('renja.datatable');
    Route::resource('renja', 'FormRenjaController')->middleware(['auth']);
});

Route::prefix('/master')->name('master.')->group(function(){
    Route::get('wilayah/getwilayah', 'MasterWilayahController@getWilayah')->name('wilayah.getWilayah');
    Route::get('wilayah/datatable', 'MasterWilayahController@getDatatable')->name('wilayah.datatable');
    Route::resource('wilayah', 'MasterWilayahController')->middleware(['auth']);

    Route::get('provinsi/getprovinsi', 'MasterProvinsiController@getProvinsi')->name('provinsi.getProvinsi');
    Route::get('provinsi/datatable', 'MasterProvinsiController@getDatatable')->name('provinsi.datatable');
    Route::resource('provinsi', 'MasterProvinsiController')->middleware(['auth']);

    Route::get('kabupaten/getkabupaten', 'MasterKabupatenController@getKabupaten')->name('kabupaten.getKabupaten');
    Route::get('kabupaten/datatable', 'MasterKabupatenController@getDatatable')->name('kabupaten.datatable');
    Route::resource('kabupaten', 'MasterKabupatenController')->middleware(['auth']);

    Route::get('client/getclient', 'MasterClientController@getClient')->name('client.getClient');
    Route::get('client/datatable', 'MasterClientController@getDatatable')->name('client.datatable');
    Route::resource('client', 'MasterClientController')->middleware(['auth']);
});

Route::get('/userguide', 'SecurityController@userguide')->name('userguide');
Route::match(['get', 'post'], '/security', 'SecurityController@security')->name('security');
