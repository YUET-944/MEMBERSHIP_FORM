<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MembershipController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\OtpController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| API endpoints for membership system
|
*/

// Public API Routes
Route::prefix('v1')->group(function () {
    // Membership Registration API
    Route::post('/membership/register', [MembershipController::class, 'register'])->middleware('throttle:10,1');
    Route::post('/membership/verify-otp', [MembershipController::class, 'verifyOtp'])->middleware('throttle:5,1');
    Route::post('/membership/resend-otp', [MembershipController::class, 'resendOtp'])->middleware('throttle:3,1');
    
    // Address API (for cascading dropdowns)
    Route::get('/provinces', [MembershipController::class, 'getProvinces']);
    Route::get('/divisions/{province}', [MembershipController::class, 'getDivisions']);
    Route::get('/districts/{division}', [MembershipController::class, 'getDistricts']);
    Route::get('/tehsils/{district}', [MembershipController::class, 'getTehsils']);
});

// Protected API Routes (Member)
Route::prefix('v1')->middleware(['auth:sanctum', 'check.2fa'])->group(function () {
    Route::prefix('member')->name('api.member.')->group(function () {
        Route::get('/profile', [MemberController::class, 'profile']);
        Route::put('/profile', [MemberController::class, 'updateProfile']);
        Route::get('/certificate', [MemberController::class, 'downloadCertificate']);
    });
});

// Protected API Routes (Admin)
Route::prefix('v1/admin')->middleware(['auth:sanctum', 'admin.access'])->group(function () {
    Route::prefix('members')->name('api.admin.members.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\Admin\MemberController::class, 'index']);
        Route::get('/{member}', [\App\Http\Controllers\Api\Admin\MemberController::class, 'show']);
        Route::post('/{member}/approve', [\App\Http\Controllers\Api\Admin\MemberController::class, 'approve']);
        Route::post('/{member}/reject', [\App\Http\Controllers\Api\Admin\MemberController::class, 'reject']);
    });
});

