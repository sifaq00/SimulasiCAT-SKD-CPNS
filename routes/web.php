<?php

use App\Livewire\Dashboard;
use App\Livewire\PackageList;
use App\Livewire\Test\Simulation;

use App\Livewire\Test\Result;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    $packages = \App\Models\Package::active()->orderBy('year', 'desc')->get();
    $bundles = \App\Models\Bundle::active()->get();
    return view('welcome', compact('packages', 'bundles'));
})->name('home');

// Temporary Teammate Preview
Route::get('/teammate-landing', function () {
    $packages = \App\Models\Package::active()->orderBy('year', 'desc')->get();
    $bundles = \App\Models\Bundle::active()->get();
    return view('welcome_teammate', compact('packages', 'bundles'));
});


// Free Tryout Flow
Route::get('free-tryout', \App\Livewire\Test\FreeSimulation::class)->name('test.free-simulation');
Route::get('free-result', \App\Livewire\Test\FreeResult::class)->name('test.free-result');



Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    // Packages
    Route::get('packages', PackageList::class)->name('packages');

    // Profile
    Route::view('profile', 'profile')->name('profile');

    // Payment
    Route::get('payment/checkout/{slug}', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::post('payment/process/{slug}', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('payment/finish', [PaymentController::class, 'finish'])->name('payment.finish');

    // Test
    Route::get('test/history', \App\Livewire\Test\History::class)->name('test.history');
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

require __DIR__ . '/auth.php';
