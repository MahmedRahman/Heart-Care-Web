<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\HeartRateReadingController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Patients
    Route::resource('patients', PatientController::class);
    
    // Heart Rate Readings (nested under patients)
    Route::resource('patients.heart-rate-readings', HeartRateReadingController::class)->except(['show']);

    // Users (Employees)
    Route::resource('users', UserController::class);

    // Onboarding
    Route::resource('onboardings', OnboardingController::class);

    // Diagnoses
    Route::resource('diagnoses', DiagnosisController::class);

    // Settings
    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');
});
