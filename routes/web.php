<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DashboardController;
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

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('trips', TripController::class)->except(['show']);

    Route::resource('vehicles', VehicleController::class)->except(['show', 'create', 'edit']);

    Route::resource('drivers', DriverController::class)->except(['create', 'edit']);
    Route::delete('/drivers/{driver}/photo', [DriverController::class, 'destroyPhoto'])->name('drivers.photo.destroy');

    Route::resource('users', UserController::class)->except(['show', 'create', 'edit']);
    Route::patch('/users/{user}/toggle-block', [UserController::class, 'toggleBlock'])->name('users.toggle-block');
    Route::delete('/users/{user}/photo', [UserController::class, 'destroyPhoto'])->name('users.photo.destroy');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

    // Placeholders for sidebar modules
    Route::resource('customers', ClientController::class)->except(['create', 'edit']);
    Route::delete('/clients/{client}/photo', [ClientController::class, 'destroyPhoto'])->name('clients.photo.destroy');
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
    Route::resource('contracts', ContractController::class)->except(['create', 'edit']);
    Route::resource('packages', PackageController::class)->except(['create', 'edit']);
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');
