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


Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'TodolistController@index');

    Route::get('todo_list', 'TodolistController@index');
    Route::post('todo_list', 'TodolistController@action');

    Route::get('todo_list/search', 'TodolistController@search');
    Route::post('todo_list/search', 'TodolistController@search');

    Route::get('todo_list/entry', 'TodolistController@entry');
    Route::post('todo_list/entry', 'TodolistController@create');

    Route::get('todo_list/edit', 'TodolistController@edit');
    Route::post('todo_list/edit', 'TodolistController@update');

    Route::get('todo_list/del', 'TodolistController@del');
    Route::post('todo_list/del', 'TodolistController@remove');

    Route::get('/logout', 'TodolistController@getLogout');
});


Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
