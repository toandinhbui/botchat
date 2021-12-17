<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
Route::get('/webhook', 'DemoConversation@webhook');
Route::get('/postchat', 'DemoConversation@postchat');
Route::post('/webhook', 'DemoConversation@addWebhook');
Route::post('/hours', function (Request $request) {
    Log::debug("message:", $request->all());
});
Route::get('/hours', function (Request $request) {
    Log::debug("message:", $request->all());
});
//Title
Route::get('getTitle', 'TitleController@index');
Route::post('postTitle', 'TitleController@postTitle');
Route::get('geteditTitle/{id}', 'TitleController@geteditTitle');
Route::post('posteditTitle/{id}', 'TitleController@posteditTitle');
Route::get('deleteTitle/{id}', 'TitleController@deleteTitle')->name('ajax_deleteTitle');
//Funtap
Route::get('getFuntap', 'FuntapController@index');
Route::post('postFuntap', 'FuntapController@postFuntap');
Route::get('geteditFuntap/{id}', 'FuntapController@geteditFuntap');
Route::post('posteditFuntap/{id}', 'FuntapController@posteditFuntap');
Route::get('deleteFuntap/{id}', 'FuntapController@deleteFuntap')->name('ajax_deleteFuntap');
//Access_token
Route::get('getAccess_token', 'Access_tokenController@index');
Route::post('postAccess_token', 'Access_tokenController@postAccess_token');
Route::get('geteditAccess_token/{id}', 'Access_tokenController@geteditAccess_token');
Route::post('posteditAccess_token/{id}', 'Access_tokenController@posteditAccess_token');
Route::get('deleteAccess_token/{id}', 'Access_tokenController@deleteAccess_token')->name('ajax_deleteAccess_token');
