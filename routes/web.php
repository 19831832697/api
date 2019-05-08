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

Route::resource('goods',ResourceController::class);


Route::any('curl','user\UserController@curl');
//路由中间件
Route::any('show','user\UserController@show')->middleware('token');
Route::any('register','user\UserController@register');
Route::any('login','user\UserController@login');
Route::any('loginindex','user\LoginController@login');//登录视图
Route::any('loginDo','user\LoginController@loginDo');//登录执行
Route::any('token','user\UserController@token');
Route::any('my','user\UserController@my')->middleware(['token','login']);
