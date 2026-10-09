<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StaffTicketController;
use App\Http\Controllers\AdminTicketController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {

    Route::get(
        '/login',
        [AuthController::class, 'showLogin']
    )->name('login');

    Route::post(
        '/login',
        [AuthController::class, 'login']
    )->name('login.store');

    Route::get(
        '/register',
        [AuthController::class, 'showRegister']
    )->name('register');

    Route::post(
        '/register',
        [AuthController::class, 'register']
    )->name('register.store');

    // Lupa password
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])
        ->middleware('guest')
        ->name('password.request');

    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
        ->middleware('guest')
        ->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])
        ->middleware('guest')
        ->name('password.reset');

    Route::post('/reset-password', [AuthController::class, 'resetPassword'])
        ->middleware('guest')
        ->name('password.update');
});


Route::middleware('auth')->group(function () {

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');

    Route::post(
        '/logout',
        [AuthController::class, 'logout']
    )->name('logout');

    // STAFF
    Route::middleware('role:staf')
        ->prefix('staff')
        ->name('staff.')
        ->group(function () {

            Route::get(
                '/profile',
                [ProfileController::class, 'edit']
            )->name('profile.edit');

            Route::put(
                '/profile',
                [ProfileController::class, 'updateProfile']
            )->name('profile.update');

            Route::put(
                '/profile/password',
                [ProfileController::class, 'updatePassword']
            )->name('profile.password');

            Route::get('/tickets', [StaffTicketController::class, 'index'])
                ->name('tickets.index');

            Route::get('/tickets/create', [StaffTicketController::class, 'create'])
                ->name('tickets.create');

            Route::post('/tickets', [StaffTicketController::class, 'store'])
                ->name('tickets.store');

            Route::get('/tickets/{ticket}', [StaffTicketController::class, 'show'])
                ->name('tickets.show');

            Route::delete('/tickets/{ticket}', [StaffTicketController::class, 'destroy'])
                ->name('tickets.destroy');
        });

    // ADMIN
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get(
                '/dashboard',
                [DashboardController::class, 'admin']
            )->name('dashboard');

            Route::get(
                '/tickets',
                [AdminTicketController::class, 'index']
            )->name('tickets.index');

            Route::get(
                '/tickets/export',
                [AdminTicketController::class, 'export']
            )->name('tickets.export');

            Route::get(
                '/tickets/{ticket}',
                [AdminTicketController::class, 'show']
            )->name('tickets.show');

            Route::put(
                '/tickets/{ticket}',
                [AdminTicketController::class, 'update']
            )->name('tickets.update');
        });
});
