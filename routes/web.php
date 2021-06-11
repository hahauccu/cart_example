<?php

use Illuminate\Support\Facades\Route;

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

Route::group(["prefix"=>"product"],function(){
	Route::get('/list','App\Http\Controllers\ProductController@showList');
});

Route::group(["prefix"=>"cart"],function(){
	Route::post('/add','App\Http\Controllers\CartController@addToCart');
	Route::post('/minus','App\Http\Controllers\CartController@minusToCart');

	Route::post('/remove_product','App\Http\Controllers\CartController@removeProduct');

	Route::post('/add_discount_code','App\Http\Controllers\CartController@addDiscountCode');

	Route::post('/check_out','App\Http\Controllers\CartController@saveCheckOut');

	Route::get('/list','App\Http\Controllers\CartController@showList');
});

Route::group(["prefix"=>"order"],function(){
	Route::get('/list','App\Http\Controllers\OrderController@list');
	Route::get('/list/{random_id}','App\Http\Controllers\OrderController@listDetail');
});

