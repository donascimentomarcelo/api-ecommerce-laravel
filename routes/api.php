<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'jwt.auth'], function() {
    Route::resource('category', 'CategoryController')->except([
        'create', 'edit', 'destroy'
    ]);
    Route::get('category/findByName/{category}',['uses' => 'CategoryController@findByName', 'as' => 'category.findByName']);
    
    Route::resource('product', 'ProductController')->except([
        'create', 'edit', 'destroy'
    ]);
    Route::get('product/findByName/{product}',['uses' => 'ProductController@findByName', 'as' => 'product.findByName']);
    Route::get('product/findByCategory/{product}',['uses' => 'ProductController@findByCategory', 'as' => 'product.findByCategory']);
    
    Route::resource('client', 'ClientController')->except([
        'create', 'edit', 'destroy'
    ]);
    Route::get('client/findByName/{client}',['uses' => 'ClientController@findByName', 'as' => 'client.findByName']);  

    Route::resource('order', 'OrderController')->except([
        'create', 'edit', 'destroy'
    ]);

    Route::resource('cupom', 'CupomController')->except([
        'create', 'edit', 'destroy'
    ]);

    Route::resource('checkout', 'CheckoutController')->except([
        'create', 'edit', 'destroy', 'index', 'show', 'update'
    ]);

    Route::resource('type', 'TypeController')->except([
        'create', 'edit', 'destroy', 'update', 'store'
    ]);
    
    Route::get('types/getActives' ,['uses' => 'TypeController@listActives', 'as' => 'getActives.type']);
    

    Route::post('auth/getUser', ['uses' => 'AuthController@getAuthenticatedUser', 'as' => 'getUser.jwt']);
});

    Route::post('auth/login', ['uses' => 'AuthController@authenticate', 'as' => 'authentication.jwt']);
    Route::post('auth/refresh', ['uses' => 'AuthController@refreshToken', 'as' => 'refresh.jwt']);
    Route::post('auth/logout', ['uses' => 'AuthController@logout', 'as' => 'logout.jwt']);