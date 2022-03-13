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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function()
{
    Route::group(['prefix'=>'user'],function(){
        Route::post('create',[\App\Http\Controllers\Api\UserController::class,'create']);
        Route::post('modify/{id}',[\App\Http\Controllers\Api\UserController::class,'modify']);
        Route::post('destroy/{id}',[\App\Http\Controllers\Api\UserController::class,'destroy']);
        Route::get('search',[\App\Http\Controllers\Api\UserController::class,'search']);
    });

    Route::group(['prefix'=>'squiduser'],function(){
        Route::post('create/to_specified_user/{user_id}',[\App\Http\Controllers\Api\SquidUserController::class,'create']);
        Route::post('modify/{id}',[\App\Http\Controllers\Api\SquidUserController::class,'modify']);
        Route::post('destroy/{id}',[\App\Http\Controllers\Api\SquidUserController::class,'destroy']);
        Route::get('search/to_specified_user/{user_id}',[\App\Http\Controllers\Api\SquidUserController::class,'search']);
    });

});
