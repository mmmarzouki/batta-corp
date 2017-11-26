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

Route::post('/addmessage','MessageController@create')->name('add_message');
Route::post('/deletemessage','MessageController@delete')->name('delete_message');
Route::post('/readmessage','MessageController@read')->name('read_message');
Route::post('/readByUsermessage','MessageController@readByUser')->name('read_by_user_message');
Route::post('/readByPeermessage','MessageController@readByPeer')->name('read_by_peer_message');

Route::post('/readPeer','PeerController@read')->name('read_peer');
Route::post('/readAllPeer','PeerController@readAll')->name('read_all_peer');
Route::post('/updatePeer','PeerController@update')->name('update_peer');

