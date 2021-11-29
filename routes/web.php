<?php

use Illuminate\Support\Facades\Auth;
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
Route::get('/read-all', 'HomeController@read_all')->name('read_all');
Route::get('/{id}/show', 'HomeController@show')->name('show');
Route::get('/{id}/read', 'HomeController@read')->name('read');
Route::get('/{id}/delete', 'HomeController@delete')->name('delete');

Route::get('/userguide', 'SecurityController@userguide')->name('userguide');
Route::match(['get', 'post'], '/security', 'SecurityController@security')->name('security');
