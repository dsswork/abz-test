<?php

use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::get('token', [TokenController::class, 'token']);
    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'store'])->middleware('auth:sanctum');
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::get('positions', [PositionController::class, 'index']);
});
