<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/how-it-works', [HomeController::class, 'howItWorks'])->name('how-it-works');
Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Projects - public viewing
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');

// Protected routes (requires authentication)
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Project management - IMPORTANT: specific routes must come before {project} wildcard
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    
    // Messaging
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{project}/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');

    // Offers
    Route::get('/offers', [App\Http\Controllers\OfferController::class, 'index'])->name('offers.index');
    Route::post('/offers', [App\Http\Controllers\OfferController::class, 'store'])->name('offers.store');
    Route::get('/offers/{offer}/checkout', [App\Http\Controllers\OfferController::class, 'checkout'])->name('offers.checkout');
    Route::get('/offers/{offer}/tracking', [App\Http\Controllers\OfferController::class, 'tracking'])->name('offers.tracking');
    Route::post('/offers/{offer}/accept', [App\Http\Controllers\OfferController::class, 'accept'])->name('offers.accept');
    Route::post('/offers/{offer}/reject', [App\Http\Controllers\OfferController::class, 'reject'])->name('offers.reject');
    Route::post('/offers/{offer}/mark-transferred', [App\Http\Controllers\OfferController::class, 'markTransferred'])->name('offers.mark-transferred');
    Route::post('/offers/{offer}/mark-received', [App\Http\Controllers\OfferController::class, 'markReceived'])->name('offers.mark-received');
    
    // Profile Settings
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    
    // Payments
    Route::get('/payments/create-checkout', [PaymentController::class, 'createCheckout'])->name('payments.checkout');
    Route::get('/payments/success', [PaymentController::class, 'success'])->name('payments.success');
    Route::get('/payments/cancel', [PaymentController::class, 'cancel'])->name('payments.cancel');
    Route::post('/payments/upgrade-featured/{project}', [PaymentController::class, 'upgradeFeatured'])->name('payments.upgrade-featured');
});

// Project show route - MUST come after /projects/create to avoid conflicts
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

// Stripe webhook (exclude from CSRF)
Route::post('/webhook/stripe', [PaymentController::class, 'webhook'])->name('webhook.stripe');

// Include Breeze routes
require __DIR__.'/auth.php';
