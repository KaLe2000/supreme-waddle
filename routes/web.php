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
    Route::resource('projects', 'ProjectController');

    Route::post('/projects/{project}/tasks', 'ProjectTasksController@store')->name('tasks.store');
    Route::patch('/projects/{project}/tasks/{task}', 'ProjectTasksController@update')->name('tasks.update');

    Route::post('/projects/{project}/invitations', 'ProjectInvitationsController@store')->name('projects.invite');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
