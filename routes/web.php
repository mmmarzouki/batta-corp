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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['author'])->group(function() {

    
});

Route::get('/unautherized','FailController@unautherized')->name('unautherized');
Route::get('/notfound','FailController@not_found')->name('not_found');