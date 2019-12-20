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

Route::post('users', 'UserController@createUser');
Route::get('users', 'UserController@getAllUser');
Route::get('users/{id}', 'UserController@getUserbyId');
Route::delete('users/{id}','UserController@deleteUser');
Route::post('users/{id}','UserController@editUser');

Route::post('posts', 'PostController@createPost');
Route::get('posts', 'PostController@getAllPost');
Route::get('posts/{id}','PostController@getPostById');
Route::delete('posts/{id}','PostController@deletePost');
Route::post('posts/{id}','PostController@editPost');

