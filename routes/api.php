<?php

use App\Http\Controllers\Api\SquidAllowedIpController;
use App\Http\Controllers\Api\SquidUserController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('user')->group(function () {
        Route::post('create', [UserController::class, 'create']);
        Route::post('modify/{id}', [UserController::class, 'modify']);
        Route::post('destroy/{id}', [UserController::class, 'destroy']);
        Route::get('search', [UserController::class, 'search']);
    });

    Route::prefix('squiduser')->group(function () {
        Route::post('create/to_specified_user/{user_id}', [SquidUserController::class, 'create']);
        Route::post('modify/{id}', [SquidUserController::class, 'modify']);
        Route::post('destroy/{id}', [SquidUserController::class, 'destroy']);
        Route::get('search/to_specified_user/{user_id}', [SquidUserController::class, 'search']);
    });

    Route::prefix('squidallowedip')->group(function () {
        Route::post('create/to_specified_user/{user_id}', [SquidAllowedIpController::class, 'create']);
        Route::post('modify/{id}', [SquidAllowedIpController::class, 'modify']);
        Route::post('destroy/{id}', [SquidAllowedIpController::class, 'destroy']);
        Route::get('search/to_specified_user/{user_id}', [SquidAllowedIpController::class, 'search']);
    });
});
