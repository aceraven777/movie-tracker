<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();

Route::get('/', 'MoviesController@index');
Route::get('movies/create', 'MoviesController@create');
Route::post('movies', 'MoviesController@store');
Route::get('movies/{name_slug}/edit', ['uses' => 'MoviesController@edit']);
