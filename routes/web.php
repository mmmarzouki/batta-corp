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

    Route::get('/profile','ProfileController@getProfile')->name('profile');    
});

Route::middleware(['no_auth'])->group(function() {
    
    Route::post('/login','ProfileController@login')->name('login');
});

Route::get('/unautherized','FailController@unautherized')->name('unautherized');
Route::get('/notfound','FailController@not_found')->name('not_found');
Route::get('/accessdenied','FailController@not_found')->name('access_denied');

Route::post('/addmessage','MessageController@create')->name('add_message');
Route::post('/deletemessage','MessageController@delete')->name('delete_message');
Route::post('/readmessage','MessageController@read')->name('read_message');
Route::post('/readByUserMessage','MessageController@readByUser')->name('read_by_user_message');
Route::post('/readByPeerMessage','MessageController@readByPeer')->name('read_by_peer_message');

Route::post('/addPeer','PeerController@create')->name('add_peer');
Route::post('/readPeer','PeerController@read')->name('read_peer');
Route::post('/readAllPeer','PeerController@readAll')->name('read_all_peer');
Route::post('/updatePeer','PeerController@update')->name('update_peer');

Route::post('/addUser','UserController@create')->name('add_user');
Route::post('/updateUser','UserController@update')->name('update_user');
Route::post('/readUser','UserController@read')->name('read_user');

Route::get('/profile','ProfileController@getProfile')->name('profile');
Route::get('/error',function() {

    return view('error');
});
