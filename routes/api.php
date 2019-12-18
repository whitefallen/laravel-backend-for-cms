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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('users', 'UserController@insertUser');
Route::get('users', 'UserController@getAllUser');
Route::get('getUser/{id}', 'UserController@getUserbyId');
Route::get('deleteUser/{id}','UserController@deleteUser');
Route::post('editUser','UserController@editUser');

Route::get('posts', 'PostController@getAllPost');
