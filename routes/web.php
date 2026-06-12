<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\UserController;
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
        return view('dashboard', [
            'tripsCount'    => \App\Models\Trip::count(),
            'vehiclesCount' => \App\Models\Vehicle::count(),
            'driversCount'  => \App\Models\Driver::count(),
            'usersCount'    => \App\Models\User::count(),
        ]);
    })->name('dashboard');

    Route::resource('trips', TripController::class)->except(['show']);

    Route::resource('vehicles', VehicleController::class)->except(['show', 'create', 'edit']);

    Route::resource('drivers', DriverController::class)->except(['show', 'create', 'edit']);

    Route::resource('users', UserController::class)->except(['show', 'create', 'edit']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');
