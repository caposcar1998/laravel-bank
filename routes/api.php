<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@saveUser');
    Route::get('logout', 'AuthController@logout');
    
});

Route::group([
    'middleware' => 'auth:api'
], function() {
    Route::get('user', 'AuthController@user');
    Route::get('accounts/{account}', 'AuthController@accounts');
    Route::post('accounts', 'AuthController@createAccount');
    Route::post('accounts/{account}/movements', 'AuthController@createMovement');
});
