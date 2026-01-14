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

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', function () {
    return view('user.landingpage');
})->name('landingpage');

// Auth Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

// Forgot password
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])
    ->name('forgot.password');


/*
|--------------------------------------------------------------------------
| USER ROUTES (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth', 'role.redirect')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'showDashboard'])
        ->name('dashboard');

    // Pemeriksaan
    Route::get('/pemeriksaan', [PemeriksaanController::class, 'index'])
        ->name('pemeriksaan');

    // Data Kesehatan (Pengaturan)
    Route::prefix('kesehatan')->name('kesehatan.')->group(function () {
        Route::get('/', [DataKesehatanController::class, 'index'])->name('index');
        Route::get('/tambah', [DataKesehatanController::class, 'create'])->name('create');
        Route::post('/store', [DataKesehatanController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [DataKesehatanController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [DataKesehatanController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [DataKesehatanController::class, 'destroy'])->name('delete');
    });

    // Deteksi Diabetes
    Route::prefix('deteksi')->name('deteksi.')->group(function () {
        Route::get('/', [DeteksiController::class, 'index'])->name('index');
        Route::get('/create', [DeteksiController::class, 'create'])->name('create');
        Route::post('/cek', [DeteksiController::class, 'cekDiabetes'])->name('cek');
    });

    // Riwayat Kesehatan
    Route::prefix('riwayat_kesehatan')->name('riwayat_kesehatan.')->group(function () {
        Route::get('/', [RiwayatController::class, 'index'])->name('index');
    });

    // ✅ Route untuk fetch data riwayat (PINDAHKAN KE LUAR PREFIX)
    Route::get('/riwayat-data', [RiwayatController::class, 'getRiwayatData'])->name('riwayat.data');
});

// Dataset (tetap PUBLIC)
Route::get('/dataset', function () {
    $path = storage_path('app/datasets/dataset_diabetes_dini.csv');
    $content = file_get_contents($path);

    return response($content)
        ->header('Content-Type', 'text/plain');
});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (AUTH + ROLE ADMIN)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin', 'role.redirect'])
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])
            ->name('dashboard');

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserManagementController::class, 'index'])->name('index');
            Route::get('/create', [UserManagementController::class, 'create'])->name('create');
            Route::post('/store', [UserManagementController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [UserManagementController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [UserManagementController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [UserManagementController::class, 'destroy'])->name('destroy');
        });
});