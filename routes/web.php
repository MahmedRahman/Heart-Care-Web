<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\HeartRateReadingController;
use App\Http\Controllers\BloodPressureReadingController;
use App\Http\Controllers\OxygenSaturationReadingController;
use App\Http\Controllers\WeightReadingController;
use App\Http\Controllers\RandomBloodSugarReadingController;
use App\Http\Controllers\FluidBalanceReadingController;
use App\Http\Controllers\RadiologyReportController;
use App\Http\Controllers\LabReportController;
use App\Http\Controllers\PrescriptionController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
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
    
    // Vitals Signs - General routes
    Route::get('/vitals/heart-rate', [HeartRateReadingController::class, 'all'])->name('vitals.heart-rate');
    Route::get('/vitals/blood-pressure', [BloodPressureReadingController::class, 'all'])->name('vitals.blood-pressure');
    Route::get('/vitals/oxygen-saturation', [OxygenSaturationReadingController::class, 'all'])->name('vitals.oxygen-saturation');
    Route::get('/vitals/weight', [WeightReadingController::class, 'all'])->name('vitals.weight');
    Route::get('/vitals/random-blood-sugar', [RandomBloodSugarReadingController::class, 'all'])->name('vitals.random-blood-sugar');
    Route::get('/vitals/fluid-balance', [FluidBalanceReadingController::class, 'all'])->name('vitals.fluid-balance');
    
    // Heart Rate Readings (nested under patients)
    Route::resource('patients.heart-rate-readings', HeartRateReadingController::class)->except(['show']);
    
    // Blood Pressure Readings (nested under patients)
    Route::resource('patients.blood-pressure-readings', BloodPressureReadingController::class)->except(['show']);
    
    // Oxygen Saturation Readings (nested under patients)
    Route::resource('patients.oxygen-saturation-readings', OxygenSaturationReadingController::class)->except(['show']);
    
    // Weight Readings (nested under patients)
    Route::resource('patients.weight-readings', WeightReadingController::class)->except(['show']);
    
    // Random Blood Sugar Readings (nested under patients)
    Route::resource('patients.random-blood-sugar-readings', RandomBloodSugarReadingController::class)->except(['show']);
    
    // Fluid Balance Readings (nested under patients)
    Route::resource('patients.fluid-balance-readings', FluidBalanceReadingController::class)->except(['show']);
    
    // Prescriptions (nested under patients)
    Route::resource('patients.prescriptions', PrescriptionController::class);

    // Users (Employees)
    Route::resource('users', UserController::class);

    // Onboarding
    Route::resource('onboardings', OnboardingController::class);

    // Diagnoses
    Route::resource('diagnoses', DiagnosisController::class);

    // Radiology Reports
    Route::resource('radiology-reports', RadiologyReportController::class);
    Route::delete('radiology-reports/{radiologyReport}/files/{fileIndex}', [RadiologyReportController::class, 'deleteFile'])
        ->name('radiology-reports.files.delete');

    // Lab Reports
    Route::resource('lab-reports', LabReportController::class);
    Route::delete('lab-reports/{labReport}/files/{fileIndex}', [LabReportController::class, 'deleteFile'])
        ->name('lab-reports.files.delete');

    // Settings
    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');
});
