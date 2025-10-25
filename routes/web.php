<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeteksiController;
use App\Http\Controllers\RiwayatController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('user.landingpage');
})->name('landingpage');

Route::get('/dashboard', function () {
    return view('user.dashboard');
})->name('dashboard');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot.password');

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