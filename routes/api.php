<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes

// Protected routes
Route::prefix('/v1')->group(function () {
    Route::prefix('/auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    });

    Route::prefix('/profile')->middleware('auth:sanctum')->group(function () {
        // Profile routes
        Route::get('/', [ProfileController::class, 'show']);
        Route::post('/', [ProfileController::class, 'update']);
        Route::put('/password', [ProfileController::class, 'updatePassword']);
    });

    // News routes
    route::prefix('/news')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\NewsController::class, 'index']);
        Route::get('/{slug}', [App\Http\Controllers\Api\NewsController::class, 'show']);
        Route::post('/{slug}/comments', [App\Http\Controllers\Api\NewsController::class, 'comment'])->middleware('auth:sanctum');
    });

    
});
