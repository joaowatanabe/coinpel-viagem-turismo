<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ChangePasswordController;
use Illuminate\Support\Facades\Route;

// Rotas públicas (somente para não autenticados)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Primeiro acesso (autenticado mas sem senha definitiva)
Route::middleware('auth')->group(function () {
    Route::get('/change-password', [ChangePasswordController::class, 'show'])->name('password.change');
    Route::post('/change-password', [ChangePasswordController::class, 'update']);
});

// Rotas protegidas (autenticado + senha já definida)
Route::middleware(['auth', 'must.change.password'])->group(function () {
    Route::get('/', fn() => redirect()->route('trips.index'));

    Route::get('/trips', function () {
        return view('trips.index');
    })->name('trips.index');

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
