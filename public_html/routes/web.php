<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Auth
Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');
Route::get('logout', 'AuthController@logout');

// CRUD user
Route::get('user', 'UserController@index');
Route::get('user/{id}', 'UserController@get');
Route::put('user/{id}', 'UserController@update');
Route::delete('user/{id}', 'UserController@destroy');

// CRUD salary
Route::group(['middleware' => 'auth'], function () {
    Route::get('salary', 'SalaryController@index');
    Route::get('salary/{id}', 'SalaryController@get');
    Route::get('salary-user/{id}', 'SalaryController@get_by_user');
    Route::post('salary', 'SalaryController@store');
    Route::put('salary/{id}', 'SalaryController@update');
    Route::delete('salary/{id}', 'SalaryController@destroy');
});

// Filter
Route::get('filter', 'FilterController@index');

// Firebase
Route::get('rank-firebase', 'RankFirebaseController@index');
Route::get('rank-firebase/{id}', 'RankFirebaseController@get');
Route::post('rank-firebase', 'RankFirebaseController@store');
Route::put('rank-firebase/{id}', 'RankFirebaseController@update');
Route::delete('rank-firebase/{id}', 'RankFirebaseController@destroy');