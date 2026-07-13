<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\TransactionController;

// User Area
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/{event}', [EventController::class, 'detail'])->name('event.detail');

// Checkout (versi terbaru dari main)
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])
    ->name('checkout.create');
Route::post('/checkout/{event}', [CheckoutController::class, 'store'])
    ->name('checkout.store');
Route::get('/my-ticket', [EventController::class, 'ticket'])
    ->name('ticket');
Route::get('/partners', [HomeController::class, 'partners'])
    ->name('partners.index');
Route::get('/payment/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');


// Login Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});

// Admin Area
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');
        Route::resource('events', EventAdminController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('partners', PartnerController::class);
        // Menggunakan controller terbaru dari main
        Route::get('/transactions', [TransactionController::class, 'index'])
            ->name('transactions.index');
    });