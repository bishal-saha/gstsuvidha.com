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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('users', 'UserController');
Route::get('roles/list', 'RoleController@list')->name('roles.list');
Route::resource('roles', 'RoleController');
Route::get('permissions/list', 'PermissionController@list')->name('permissions.list');
Route::resource('permissions', 'PermissionController');
Route::resource('posts', 'PostController');

