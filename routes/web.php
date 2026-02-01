<?php

use App\Livewire\Dashboard;
use App\Livewire\PackageList;
use App\Livewire\Test\Simulation;
use App\Livewire\Test\Result;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::view('/', 'welcome')->name('home');

Route::get('packages', PackageList::class)->name('packages');

// Authenticated routes (removed 'verified' for dev - re-enable for production)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('dashboard', Dashboard::class)->name('dashboard');
    
    // Profile
    Route::view('profile', 'profile')->name('profile');
    
    // Payment
    Route::get('payment/checkout/{slug}', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::post('payment/process/{slug}', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('payment/finish', [PaymentController::class, 'finish'])->name('payment.finish');
    
    // Test
    Route::get('test/result/{attemptId}', Result::class)->name('test.result');
    Route::get('test/{packageSlug}/{transactionId}', Simulation::class)->name('test.simulation');
});

// Payment webhook (no auth required)
Route::post('payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::get('/questions', \App\Livewire\Admin\QuestionManage::class)->name('questions');
    Route::get('/packages', \App\Livewire\Admin\PackageManage::class)->name('packages');
    Route::get('/users', \App\Livewire\Admin\UserManage::class)->name('users');
    Route::get('/transactions', \App\Livewire\Admin\TransactionList::class)->name('transactions');
});

require __DIR__.'/auth.php';
