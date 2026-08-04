<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Frontend Routes
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/services', [FrontendController::class, 'services'])->name('services.index');
Route::get('/services/{slug}', [FrontendController::class, 'serviceDetail'])->name('services.detail');
Route::get('/platform-detail/{slug}', [FrontendController::class, 'platformDetail'])->name('platform.detail');
Route::get('/blog', [FrontendController::class, 'blog'])->name('blog.index');
Route::get('/blog/{slug}', [FrontendController::class, 'blogDetail'])->name('blog.detail');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::get('/faqs', [FrontendController::class, 'faqs'])->name('faqs');

// Inquiry Submission Route
Route::post('/enquiry/submit', [EnquiryController::class, 'submit'])->name('enquiry.submit');

// Admin Panel Auth & Portal Routes
Route::prefix('admin')->group(function () {
    // Guest Admin Routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [AdminController::class, 'login']);
    });

    // Authenticated Admin Routes
    Route::middleware('auth')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
        
        // Content & Settings Management
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
        Route::post('/settings/update', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
        Route::get('/homepage', [AdminController::class, 'homepage'])->name('admin.homepage');
        Route::post('/homepage/update', [AdminController::class, 'updateHomepage'])->name('admin.homepage.update');

        // Enquiries Management
        Route::get('/enquiries', [AdminController::class, 'enquiries'])->name('admin.enquiries');
        Route::post('/enquiries/{id}/status', [AdminController::class, 'updateEnquiryStatus'])->name('admin.enquiries.status');
        Route::get('/enquiries/export', [AdminController::class, 'exportEnquiries'])->name('admin.enquiries.export');
        Route::get('/notifications/pending', [AdminController::class, 'getPendingNotifications'])->name('admin.notifications.pending');
        Route::post('/notifications/clear', [AdminController::class, 'clearNotifications'])->name('admin.notifications.clear');

        // Resource Managers (CRUD)
        Route::resource('services', AdminServiceController::class)->names('admin.services');
        Route::resource('blogs', AdminBlogController::class)->names('admin.blogs');
    });
});
