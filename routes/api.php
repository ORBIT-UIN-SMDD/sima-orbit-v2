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
    Route::prefix('/news')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\NewsController::class, 'index']);
        Route::get('/{slug}', [App\Http\Controllers\Api\NewsController::class, 'show']);
        Route::post('/{slug}/comments', [App\Http\Controllers\Api\NewsController::class, 'comment'])->middleware('auth:sanctum');
    });

    // Division routes
    Route::prefix('/divisions')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\DivisionController::class, 'index']);
    });

    Route::prefix('/users')->middleware('auth:sanctum')->group(function () {
        Route::get('/committee/{slug?}', [App\Http\Controllers\Api\UserController::class, 'committee']);
        Route::get('/member/{slug?}', [App\Http\Controllers\Api\UserController::class, 'member']);
        Route::get('/alumni', [App\Http\Controllers\Api\UserController::class, 'alumni']);
        Route::get('/all', [App\Http\Controllers\Api\UserController::class, 'all']);
        Route::get('/periods', [App\Http\Controllers\Api\UserController::class, 'periods']);
    });

    Route::prefix('/chat')->middleware('auth:sanctum')->group(function () {
        Route::get('/conversations', [App\Http\Controllers\Api\ChatController::class, 'conversations']);
        Route::post('/conversation', [App\Http\Controllers\Api\ChatController::class, 'storeConversation']);
        Route::get('/conversations/{conversationId}/messages', [App\Http\Controllers\Api\ChatController::class, 'messages']);
    });


});
