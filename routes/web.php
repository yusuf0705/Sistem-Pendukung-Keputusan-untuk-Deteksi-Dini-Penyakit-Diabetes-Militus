<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeteksiController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PemeriksaanController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\DataKesehatanController;


// Landing page
Route::get('/', function () {
    return view('user.landingpage');
})->name('landingpage');


// Dashboard user biasa
Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');


// Auth Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

// LOGIN
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

// FORGOT PASSWORD
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot.password');

// LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Pemeriksaan
Route::get('/pemeriksaan', [PemeriksaanController::class, 'index'])->name('pemeriksaan');


// Protected Routes
Route::middleware('auth')->group(function () {

    Route::get('/kesehatan', [DataKesehatanController::class, 'index'])->name('kesehatan.index');
    Route::get('/kesehatan/tambah', [DataKesehatanController::class, 'create'])->name('kesehatan.create');
    Route::post('/kesehatan/store', [DataKesehatanController::class, 'store'])->name('kesehatan.store');
    Route::get('/kesehatan/edit/{id}', [DataKesehatanController::class, 'edit'])->name('kesehatan.edit');
    Route::post('/kesehatan/update/{id}', [DataKesehatanController::class, 'update'])->name('kesehatan.update');
    Route::delete('/kesehatan/delete/{id}', [DataKesehatanController::class, 'destroy'])->name('kesehatan.delete');

});


// ========================
// Deteksi Routes (fixed)
// ========================
Route::prefix('deteksi')->name('deteksi.')->group(function () {
    Route::get('/', [DeteksiController::class, 'index'])->name('index');
    Route::get('/create', [DeteksiController::class, 'create'])->name('create');
    Route::post('/cek', [DeteksiController::class, 'cekDiabetes'])->name('cek');
});


// Dataset
Route::get('/dataset', function () {
    $path = storage_path('app/datasets/dataset_diabetes_dini.csv');
    $content = file_get_contents($path);
    return response($content)
        ->header('Content-Type', 'text/plain');
});


// Riwayat Kesehatan
Route::prefix('riwayat_kesehatan')->name('riwayat_kesehatan.')->group(function () {
    Route::get('/', [RiwayatController::class, 'index'])->name('index');
});


// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('/create', [UserManagementController::class, 'create'])->name('create');
        Route::post('/store', [UserManagementController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UserManagementController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [UserManagementController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [UserManagementController::class, 'destroy'])->name('destroy');
    });

});
