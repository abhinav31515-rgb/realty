<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\ContentController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\PaymentController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    
    // Public routes
    Route::middleware('throttle:api')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/properties', [PropertyController::class, 'index']);
        Route::get('/properties/{property}', [PropertyController::class, 'show']);
        Route::get('/content', [ContentController::class, 'index']);
        Route::get('/content/{content:slug}', [ContentController::class, 'show']);
    });

    // Authenticated routes
    Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/properties', [PropertyController::class, 'store']);
        Route::put('/properties/{property}', [PropertyController::class, 'update']);
        Route::delete('/properties/{property}', [PropertyController::class, 'destroy']);
        Route::post('/properties/{property}/click', [PropertyController::class, 'incrementClick']);
        Route::get('/bookings', [BookingController::class, 'index']);
        Route::post('/bookings', [BookingController::class, 'store']);
        Route::patch('/bookings/{booking}', [BookingController::class, 'updateStatus']);
        Route::post('/bookings/{booking}/pay', [PaymentController::class, 'createCheckoutSession']);
        Route::get('/favorites', [FavoriteController::class, 'index']);
        Route::post('/favorites', [FavoriteController::class, 'store']);
        Route::delete('/favorites/{property}', [FavoriteController::class, 'destroy']);
        Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
    });
});
