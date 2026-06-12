<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/change-password', [ChangePasswordController::class, 'show'])->name('password.change');
    Route::post('/change-password', [ChangePasswordController::class, 'update']);
});

Route::middleware(['auth', 'must.change.password'])->group(function () {
    Route::get('/', fn() => redirect()->route('dashboard'));

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('trips', TripController::class)->except(['show']);

    Route::get('/vehicles', function () {
        return view('vehicles.index');
    })->name('vehicles.index');

    Route::get('/drivers', function () {
        return view('drivers.index');
    })->name('drivers.index');

    Route::get('/users', function () {
        return view('users.index');
    })->name('users.index');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');
