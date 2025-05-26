<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProduksiPanganController;
use Illuminate\Support\Facades\Route;

// Rute Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Dashboard Publik untuk User Umum
Route::get('/', [HomeController::class, 'index'])->name('welcome');

// Rute Dashboard dengan Autentikasi
Route::middleware(['auth', 'role:nasional'])->group(function () {
    Route::get('/nasional/dashboard', [DashboardController::class, 'nasional'])->name('nasional.dashboard');
    Route::patch('/nasional/produksi/validasi/{id}', [ProduksiPanganController::class, 'validasi'])->name('produksi.validasi');
});

Route::middleware(['auth', 'role:daerah'])->group(function () {
    Route::get('/daerah/dashboard', [DashboardController::class, 'daerah'])->name('daerah.dashboard');
    Route::post('/daerah/produksi/store', [ProduksiPanganController::class, 'store'])->name('produksi.store');
});
// Rute Dashboard User yang Dilindungi (opsional, jika user login)
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [HomeController::class, 'index'])->name('user.dashboard');
});
