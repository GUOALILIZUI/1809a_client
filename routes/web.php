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
Route::resource('Goods',GoodsController::class);



//5.9
Route::get('oneIndex','One\OneController@oneIndex');
Route::post('oneInfo','One\OneController@oneInfo');
Route::get('actii','One\OneController@actii');
Route::get('rsaTest','One\OneController@rsaTest');
Route::get('sign','One\OneController@sign');


//5.13周考
//Route::get('regindex','Register\RegController@regindex');
//Route::post('regInfo','Register\RegController@regInfo');
//Route::get('token','Register\RegController@token');
//Route::get('a','Register\RegController@a');


//5.15
Route::post('regInfo','Register\RegController@regInfo');
Route::post('logInfo','Register\RegController@logInfo');
Route::get('center','Center\CenterController@center')->Middleware('token');



//商品 5.16
Route::get('goodslist','Goods\GoodsController@goodsList');
Route::post('centent','Goods\GoodsController@cenTent');
Route::post('cart','Cart\CartController@cart');
Route::post('cartlist','Cart\CartController@cartList');
Route::post('account','Account\AccountController@account');
Route::post('orderlist','Order\OrderController@orderList');
Route::get('pay','Pay\PayController@pay');



