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

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

Route::get('signup', 'UsersController@create')->name('signup');

Route::resource('users', 'UsersController');
/*
|--------------------------------------------------------------------------
|resource routes,注意每个路由均设置了路由名称
|--------------------------------------------------------------------------
| Route::get('/users', 'UsersController@index')->name('users.index');
| Route::get('/users/{user}', 'UsersController@show')->name('users.show');
| Route::get('/users/create', 'UsersController@create')->name('users.create');
| Route::post('/users', 'UsersController@store')->name('users.store');
| Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
| Route::patch('/users/{user}', 'UsersController@update')->name('users.update');
| Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');
|
*/

/*
|--------------------------------------------------------------------------
|用户登录、登出路由
|
*/
Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');

Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');

/*
|--------------------------------------------------------------------------
|用户重置密码路由
|
*/
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
