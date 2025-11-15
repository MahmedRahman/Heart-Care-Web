<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PatientAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Patient Authentication Routes
Route::prefix('patient')->group(function () {
    Route::post('/register', [PatientAuthController::class, 'register']);
    Route::post('/login', [PatientAuthController::class, 'login']);
    Route::post('/forgot-password', [PatientAuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [PatientAuthController::class, 'resetPassword']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [PatientAuthController::class, 'profile']);
        Route::put('/profile', [PatientAuthController::class, 'updateProfile']);
        Route::post('/logout', [PatientAuthController::class, 'logout']);
    });
});

