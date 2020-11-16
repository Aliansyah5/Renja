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

Route::get('/test', function () {
    return response('Hello world.', 200);
})->name('test')->middleware('permitted:7,delete');
