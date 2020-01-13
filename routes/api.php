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



Route::group(['middleware' => ['jwt.verify']], function() {
    Route::delete('users/{id}','UserController@deleteUser');
    Route::post('users/{id}','UserController@editUser');

    Route::post('posts', 'PostController@createPost');
    Route::delete('posts/{id}','PostController@deletePost');
    Route::post('posts/{id}','PostController@editPost');

    Route::post('formats', 'FormatController@createFormat');
    Route::delete('formats/{id}','FormatController@deleteFormat');
    Route::post('formats/{id}','FormatController@editFormat');

    Route::post('topics', 'TopicController@createTopic');
    Route::delete('topics/{id}','TopicController@deleteTopic');
    Route::post('topics/{id}','TopicController@editTopic');

    Route::post('tags', 'TagController@createTag');
    Route::delete('tags/{id}','TagController@deleteTag');
    Route::post('tags/{id}','TagController@editTag');
});

Route::post('login','UserController@login');
Route::post('users', 'UserController@createUser');
Route::get('users', 'UserController@getAllUser');
Route::get('users/{id}', 'UserController@getUserbyId');
Route::get('posts', 'PostController@getAllPost');
Route::get('posts/{id}','PostController@getPostById');
Route::get('formats', 'FormatController@getAllFormat');
Route::get('formats/{id}','FormatController@getFormatById');
Route::get('topics', 'TopicController@getAllTopic');
Route::get('topics/{id}','TopicController@getTopicById');
Route::get('tags', 'TagController@getAllTag');
Route::get('tags/{id}','TagController@getTagById');
Route::get('userposts/{id}','PostController@getPostsFromUser');

Route::get('webhook', 'WebhookController@handle');
Route::get('webhookDebug', 'WebhookController@webhookAction');

