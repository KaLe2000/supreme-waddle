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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/projects', 'ProjectController@index')->name('projects.index');
    Route::get('/projects/create', 'ProjectController@create')->name('projects.create');
    Route::post('/projects', 'ProjectController@store')->name('projects.store');
    Route::get('/projects/{project}', 'ProjectController@show')->name('projects.show');

    Route::post('/projects/{project}/tasks', 'ProjectTasksController@store')->name('tasks.store');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
