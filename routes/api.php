<?php

use App\Http\Controllers\API\V1\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\AvailabilityController;
use App\Http\Controllers\API\V1\AppointmentController;
use App\Http\Controllers\API\V1\BookingLinkController;

Route::prefix('v1')->group(function () {
    // Public routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Protected routes
    Route::middleware(['jwt.auth'])->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);

        // Host-only routes
        // Route::middleware(['role:host'])->group(function () {
            Route::post('/availability', [AvailabilityController::class, 'store']);
            Route::post('/booking-links', [BookingLinkController::class, 'store']);
        // });

        // public availability by host
        Route::get('/availability/{host_id}', [AvailabilityController::class, 'show']);
        Route::get('/booking-links/{slug}', [BookingLinkController::class, 'show']);

        // appointments (host and guest)
        Route::post('/appointments', [AppointmentController::class, 'store']);
        Route::get('/appointments', [AppointmentController::class, 'index']);
        Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
        // notifications
        Route::get('/notifications', [NotificationController::class, 'index']);
    });
});
