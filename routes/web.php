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

Route::resource('category', 'CategoryController')->except([
    'create', 'store', 'update', 'destroy'
]);
Route::get('category/findByName/{category}',['uses' => 'CategoryController@findByName', 'as' => 'category.findByName']);