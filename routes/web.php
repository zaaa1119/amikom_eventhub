<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\AuthController;


// Rute User Area
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event', [EventController::class, 'show'])->name('events.show');
Route::get('/event-detail', function () {return view('event-detail');})->name('event.detail');
Route::get('/checkout', [EventController::class, 'checkout'])->name('checkout');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');
Route::get('/partners', [\App\Http\Controllers\HomeController::class, 'partners'])->name('partners.index');

// LOGIN ADMIN
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.post');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});


// AREA ADMIN TERPROTEKSI
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('events', EventAdminController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('partners', PartnerController::class);

        Route::get('/transactions', function () {
            return view('admin.transaction');
        })->name('transactions.index');
    });