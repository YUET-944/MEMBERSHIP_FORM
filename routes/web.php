<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileSettingController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\ContactMessageController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/projects', [ProjectsController::class, 'index'])->name('projects.index');
Route::get('/project/{slug}', [ProjectsController::class, 'show'])->name('projects.show');
Route::get('/services', [ServicesController::class, 'index'])->name('services.index');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact-submit', [ContactController::class, 'store'])->name('contact.store');

// Simple login route for demonstration
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

use Illuminate\Support\Facades\Auth;

Route::post('/login', function () {
    // Proper authentication logic
    $credentials = request()->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);
    
    if (Auth::attempt($credentials)) {
        // Check if the authenticated user is an admin
        if (Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        } else {
            Auth::logout(); // Logout if not admin
            return back()->withErrors([
                'email' => 'Access denied. Admin privileges required.'
            ]);
        }
    }
    
    return back()->withErrors([
        'email' => 'Invalid credentials.'
    ]);
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('home');
})->name('logout');



// Admin routes
Route::middleware(['auth', 'App\Http\Middleware\AuthMiddleware'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    Route::get('/admin/profile', [ProfileSettingController::class, 'index'])->name('admin.profile.index');
    Route::post('/admin/profile', [ProfileSettingController::class, 'update'])->name('admin.profile.update');
    
    // Manually define project routes for debugging
    Route::get('/admin/projects', [ProjectController::class, 'index'])->name('admin.projects.index');
    Route::get('/admin/projects/create', [ProjectController::class, 'create'])->name('admin.projects.create');
    Route::post('/admin/projects', [ProjectController::class, 'store'])->name('admin.projects.store');
    Route::get('/admin/projects/{project}', [ProjectController::class, 'show'])->name('admin.projects.show');
    Route::get('/admin/projects/{project}/edit', [ProjectController::class, 'edit'])->name('admin.projects.edit');
    Route::put('/admin/projects/{project}', [ProjectController::class, 'update'])->name('admin.projects.update');
    Route::delete('/admin/projects/{project}', [ProjectController::class, 'destroy'])->name('admin.projects.destroy');
    
    // Manually define skills routes
    Route::get('/admin/skills', [SkillController::class, 'index'])->name('admin.skills.index');
    Route::get('/admin/skills/create', [SkillController::class, 'create'])->name('admin.skills.create');
    Route::post('/admin/skills', [SkillController::class, 'store'])->name('admin.skills.store');
    Route::get('/admin/skills/{skill}', [SkillController::class, 'show'])->name('admin.skills.show');
    Route::get('/admin/skills/{skill}/edit', [SkillController::class, 'edit'])->name('admin.skills.edit');
    Route::put('/admin/skills/{skill}', [SkillController::class, 'update'])->name('admin.skills.update');
    Route::delete('/admin/skills/{skill}', [SkillController::class, 'destroy'])->name('admin.skills.destroy');
    
    // Manually define services routes
    Route::get('/admin/services', [ServiceController::class, 'index'])->name('admin.services.index');
    Route::get('/admin/services/create', [ServiceController::class, 'create'])->name('admin.services.create');
    Route::post('/admin/services', [ServiceController::class, 'store'])->name('admin.services.store');
    Route::get('/admin/services/{service}', [ServiceController::class, 'show'])->name('admin.services.show');
    Route::get('/admin/services/{service}/edit', [ServiceController::class, 'edit'])->name('admin.services.edit');
    Route::put('/admin/services/{service}', [ServiceController::class, 'update'])->name('admin.services.update');
    Route::delete('/admin/services/{service}', [ServiceController::class, 'destroy'])->name('admin.services.destroy');
    
    // Manually define testimonials routes
    Route::get('/admin/testimonials', [TestimonialController::class, 'index'])->name('admin.testimonials.index');
    Route::get('/admin/testimonials/create', [TestimonialController::class, 'create'])->name('admin.testimonials.create');
    Route::post('/admin/testimonials', [TestimonialController::class, 'store'])->name('admin.testimonials.store');
    Route::get('/admin/testimonials/{testimonial}', [TestimonialController::class, 'show'])->name('admin.testimonials.show');
    Route::get('/admin/testimonials/{testimonial}/edit', [TestimonialController::class, 'edit'])->name('admin.testimonials.edit');
    Route::put('/admin/testimonials/{testimonial}', [TestimonialController::class, 'update'])->name('admin.testimonials.update');
    Route::delete('/admin/testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('admin.testimonials.destroy');
    
    // Manually define messages routes
    Route::get('/admin/messages', [ContactMessageController::class, 'index'])->name('admin.messages.index');
    Route::get('/admin/messages/{message}', [ContactMessageController::class, 'show'])->name('admin.messages.show');
    Route::delete('/admin/messages/{message}', [ContactMessageController::class, 'destroy'])->name('admin.messages.destroy');
});

