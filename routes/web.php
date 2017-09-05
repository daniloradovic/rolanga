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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();



// Route::get('/groups', 'GroupController@index');

Route::get('/', 'TournamentsController@index');

Route::get('/create', 'TournamentsController@create');

Route::post('/tournaments', 'TournamentsController@store');

Route::get('/tournaments/{tournament}', 'TournamentsController@show')->name('showTournament');

Route::post('/generate', 'TournamentsController@generateGroups');

Route::get('/tournaments/{tournament}/groups', 'TournamentsController@showGroups')->name('showGroups');

Route::get('/tournaments/{tournament}/matches/{match}/edit', 'SetsController@edit');

Route::patch('/tournaments/{tournament}/matches/{match}', 'SetsController@update')->name('setScore');