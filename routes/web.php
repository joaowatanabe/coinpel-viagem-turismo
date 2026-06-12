<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ChangePasswordController;
use Illuminate\Support\Facades\Route;

// Redireciona a raiz para as viagens
Route::redirect('/', '/trips');

// Rotas de Guest (Não Autenticado)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Rotas de Auth (Autenticado)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Rotas de primeiro acesso (Troca de senha obrigatória)
    Route::get('/change-password', [ChangePasswordController::class, 'showChangePassword'])->name('change-password.show');
    Route::post('/change-password', [ChangePasswordController::class, 'changePassword'])->name('change-password.update');

    // Rotas protegidas (apenas usuários com senha já alterada e autenticados)
    Route::middleware('must.change.password')->group(function () {
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
});
