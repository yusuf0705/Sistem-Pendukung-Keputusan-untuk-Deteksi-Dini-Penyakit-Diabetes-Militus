<?php

use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeteksiController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PemeriksaanController;
use App\Http\Controllers\UserManagementController;

// Landing page
Route::get('/', function () {
    return view('user.landingpage');
})->name('landingpage');

// Dashboard user biasa
Route::get('/dashboard', function () {
    return view('user.dashboard');
})->name('dashboard');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot.password');

Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard'); 
Route::get('/pemeriksaan', [PemeriksaanController::class, 'index'])->name('pemeriksaan');
// Deteksi Routes
Route::prefix('deteksi')->name('deteksi.')->group(function () {
    Route::get('/', [DeteksiController::class, 'index'])->name('index');
    Route::get('/create', [DeteksiController::class, 'create'])->name('create');
    Route::post('/store', [DeteksiController::class, 'store'])->name('store');
});

// Riwayat Kesehatan Routes
Route::prefix('riwayat_kesehatan')->name('riwayat_kesehatan.')->group(function () {
    Route::get('/', [RiwayatController::class, 'index'])->name('index');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');

    // User Management Routes
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('/create', [UserManagementController::class, 'create'])->name('create');
        Route::post('/store', [UserManagementController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UserManagementController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [UserManagementController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [UserManagementController::class, 'destroy'])->name('destroy');
    });
});

