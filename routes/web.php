<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\Admin\PartnerController as AdminPartnerController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\AuthController as UserAuthController;
use App\Http\Controllers\ReviewController;



// User Area
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/{event}', [EventController::class, 'detail'])->name('event.detail');

Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [UserAuthController::class, 'login'])->name('login.post');

Route::get('/register', [UserAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [UserAuthController::class, 'register'])->name('register.post');

Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [UserAuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [UserAuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [UserAuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [UserAuthController::class, 'resetPassword'])->name('password.update');

Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

Route::get('/penyelenggara/{partner}', [PartnerController::class, 'show'])->name('partner.show');
Route::get('/penyelenggara/{partner}/ulasan', [PartnerController::class, 'reviews'])->name('partner.reviews');

Route::get('/event/{event}/ulasan', [EventController::class, 'reviews'])->name('event.reviews');


// Checkout (versi terbaru dari main)
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])
    ->name('checkout.create');
Route::post('/checkout/{event}', [CheckoutController::class, 'store'])
    ->name('checkout.store');
Route::get('/riwayat', [EventController::class, 'riwayat'])
    ->middleware('auth')
    ->name('riwayat');
Route::get('/partners', [HomeController::class, 'partners'])
    ->name('partners.index');
Route::get('/payment/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');

Route::middleware('auth')->group(function () {
    Route::get('/review/{transaction}/create', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review/{transaction}', [ReviewController::class, 'store'])->name('review.store');
});

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
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');
        Route::resource('events', EventAdminController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('partners', AdminPartnerController::class);
        // Menggunakan controller terbaru dari main
        Route::get('/transactions', [TransactionController::class, 'index'])
            ->name('transactions.index');
    });

// Midtrans Webhook
Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransWebhookController::class, 'handle']);


//pengurus dan jabatan
Route::resource('jabatan', JabatanController::class);
Route::resource('pengurus', PengurusController::class);