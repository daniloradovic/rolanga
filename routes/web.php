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

Route::get('/', 'TournamentsController@index')->name('index');

Route::get('/create', 'TournamentsController@create')->middleware('tournamentAdmin');

Route::post('/tournaments', 'TournamentsController@store')->middleware('tournamentAdmin');

Route::get('/tournaments/{tournament}', 'TournamentsController@show')->name('showTournament')->middleware('tournamentAdmin');

Route::post('/generate', 'TournamentsController@generateGroups');

Route::get('/tournaments/{tournament}/groups', 'TournamentsController@showGroups')->name('showGroups');

Route::delete('/tournaments/{tournament}/groups', 'TournamentsController@destroy')->middleware('tournamentAdmin');

Route::get('/tournaments/{tournament}/matches/{match}/edit', 'SetsController@edit');

Route::patch('/tournaments/{tournament}/matches/{match}', 'SetsController@update')->name('setScore');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('register/verify/{token}', 'Auth\RegisterController@verify'); 

Route::resource('users','UsersController');

Route::post('users/{user}', 'UsersController@update_avatar');