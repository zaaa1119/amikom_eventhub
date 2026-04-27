<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;


// Rute User Area
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event', [EventController::class, 'show'])->name('events.show');
Route::get('/checkout', [EventController::class, 'checkout'])->name('checkout');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');

// Rute Admin Area
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/events', [EventController::class, 'indexAdmin'])->name('events.index');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/transactions', function () {return "Halaman Transactions";})->name('transactions.index');
});