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


Route::group(['namespace' => 'Api\V1', 'prefix' => 'v1'], function () {

    Route::group(['prefix' => 'site', 'namespace' => 'Site'], function () {
        include_route_files(__DIR__.'/client/');
    });

    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');

        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('logout', 'AuthController@logout');
        });
    });

    Route::group(['middleware' => 'auth:api'], function () {
        /** Categories */
        Route::group(['prefix' => 'categories'], function (){
            Route::delete('', 'CategorieController@deleteItems');
        });
        Route::apiResource('categories', 'CategorieController');

        /** Post */
        Route::group(['prefix' => 'posts'], function (){
            Route::delete('', 'PostController@deleteItems');
        });
        Route::apiResource('posts', 'PostController');

        /** Question */
        Route::group(['prefix' => 'questions'], function (){
            Route::delete('', 'QuestionController@deleteItems');
        });
        Route::apiResource('questions', 'QuestionController');

        /** Media */
        Route::apiResource('medias', 'MediaController');
    });
});