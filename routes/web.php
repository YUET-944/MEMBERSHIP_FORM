<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\Auth\MemberAuthController;
use App\Http\Controllers\Member\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MemberManagementController;
use App\Http\Controllers\Admin\SecurityDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Public routes for membership registration and member dashboard
|
*/

// Homepage
Route::get('/', function () {
    return view('welcome');
})->name('home');

// General Login Route (for compatibility)
Route::get('/login', function () {
    return redirect()->route('member.login');
})->name('login');

// Test route (remove in production)
Route::get('/test-member', function () {
    try {
        // Test database connection
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        $dbStatus = '✅ Connected';
        
        // Test Member model creation
        $member = new App\Models\Member();
        $member->first_name = 'Test';
        $member->last_name = 'User';
        $member->email = 'test' . time() . '@example.com';
        $member->password = bcrypt('password123');
        $member->save();
        
        $fullName = $member->full_name;
        $membershipId = $member->membership_id;
        
        // Clean up
        $member->delete();
        
        return response()->json([
            'success' => true,
            'database' => $dbStatus,
            'model_test' => '✅ Passed',
            'full_name_auto_generated' => $fullName,
            'membership_id_auto_generated' => $membershipId,
            'message' => 'All tests passed! Model is working correctly.'
        ], 200);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
})->name('test.member');

// Membership Registration
Route::prefix('membership')->name('membership.')->group(function () {
    Route::get('/register', [MembershipController::class, 'showRegistrationForm'])->name('register');
    Route::post('/submit', [MembershipController::class, 'submit'])->middleware('rate.limit:register')->name('submit');
    Route::get('/verify-otp', [MembershipController::class, 'showOtpVerification'])->name('verify-otp');
    Route::post('/verify-otp', [MembershipController::class, 'verifyOtp'])->name('verify-otp.post');
    Route::post('/resend-otp', [MembershipController::class, 'resendOtp'])->name('resend-otp');
});

// Member Authentication
Route::prefix('member')->name('member.')->group(function () {
    Route::get('/login', [MemberAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [MemberAuthController::class, 'login'])->middleware('rate.limit:login')->name('login.post');
    Route::post('/logout', [MemberAuthController::class, 'logout'])->name('logout');
    
    // 2FA Routes
    Route::get('/2fa/verify', [MemberAuthController::class, 'show2FAVerification'])->name('2fa.verify');
    Route::post('/2fa/verify', [MemberAuthController::class, 'verify2FA'])->name('2fa.verify.post');
    Route::get('/2fa/setup', [MemberAuthController::class, 'show2FASetup'])->name('2fa.setup');
    Route::post('/2fa/setup', [MemberAuthController::class, 'setup2FA'])->name('2fa.setup.post');
});

// Member Dashboard (Protected)
Route::prefix('member')->name('member.')->middleware(['auth:web', 'check.2fa'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/certificate', [DashboardController::class, 'downloadCertificate'])->name('certificate.download');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    
    // 2FA Routes
    Route::get('/2fa/verify', [AdminController::class, 'show2FAVerification'])->name('2fa.verify');
    Route::post('/2fa/verify', [AdminController::class, 'verify2FA'])->name('2fa.verify.post');
});

// Admin Panel (Protected)
Route::prefix('admin')->name('admin.')->middleware(['auth:web', 'admin.access'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Security Dashboard
    Route::prefix('security')->name('security.')->group(function () {
        Route::get('/dashboard', [SecurityDashboardController::class, 'index'])->name('dashboard');
        Route::post('/events/{id}/resolve', [SecurityDashboardController::class, 'resolveEvent'])->name('events.resolve');
        Route::get('/events', [SecurityDashboardController::class, 'getEvents'])->name('events');
    });
    
    // Member Management
    Route::prefix('members')->name('members.')->group(function () {
        Route::get('/', [MemberManagementController::class, 'index'])->name('index');
        Route::get('/{member}', [MemberManagementController::class, 'show'])->name('show');
        Route::post('/{member}/approve', [MemberManagementController::class, 'approve'])->name('approve');
        Route::post('/{member}/reject', [MemberManagementController::class, 'reject'])->name('reject');
        Route::get('/{member}/documents/{document}', [MemberManagementController::class, 'viewDocument'])->name('document.view');
    });
});

