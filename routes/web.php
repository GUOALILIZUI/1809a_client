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

Route::get('getUser','Api\UserController@getUser');
Route::get('curlUser','Api\UserController@curlUser');

Route::get('curlRaw','Api\UserController@curlRaw');
Route::get('curlData','Api\UserController@curlData');
Route::get('curlenCoded','Api\UserController@curlenCoded');

//中间件
Route::get('WareTime','Api\UserController@WareTime')->Middleware('request');


//用户注册
Route::post('reg','User\UserRegController@reg');
Route::post('login','User\UserRegController@login');
Route::get('cenTer','User\UserRegController@cenTer')->Middleware(['centent','request']);


//资源路由
Route::resource('goods',GoodsController::class);


