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

Route::group([
    'middleware' => 'api',
    'namespace' => 'Auth',
], function () {
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout');

    Route::post('register', 'RegisterController@register');
});

Route::group([
    'middleware' => ['auth:sanctum'],
], function () {
    Route::get('vue', 'HomeController@vue');
    Route::post('user', 'HomeController@user');
    Route::get('auth-user', 'Resources\UserController@authUser');
    Route::get('user-select', 'Resources\UserController@select');
    Route::post('cars-search', 'Resources\CarController@search');
});

Route::group([
    'middleware' => ['admin'],
], function () {
    Route::resource('users', 'Resources\UserController', [
        'except' => ['create', 'edit', 'show'],
    ]);
});

Route::group([
    'middleware' => ['auth:sanctum'],
], function () {
    Route::resource('cars', 'Resources\CarController', [
        'except' => ['create', 'edit', 'show'],
    ]);
});
