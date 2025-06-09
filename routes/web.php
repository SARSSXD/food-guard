<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Daerah\ArtikelGiziController;
use App\Http\Controllers\Daerah\CadanganPanganController;
use App\Http\Controllers\Daerah\DistribusiPanganController;
use App\Http\Controllers\Daerah\HargaPanganController;
use App\Http\Controllers\Daerah\PrediksiPanganController;
use App\Http\Controllers\Daerah\ProduksiPanganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Rute Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
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

    // Produksi Pangan
    Route::get('/daerah/produksi', [ProduksiPanganController::class, 'index'])->name('daerah.produksi.index');
    Route::post('/daerah/produksi', [ProduksiPanganController::class, 'store'])->name('daerah.produksi.store');
    Route::put('/daerah/produksi/{id}', [ProduksiPanganController::class, 'update'])->name('daerah.produksi.update');
    Route::delete('/daerah/produksi/{id}', [ProduksiPanganController::class, 'destroy'])->name('daerah.produksi.destroy');

    // Cadangan Pangan
    Route::get('/daerah/cadangan', [CadanganPanganController::class, 'index'])->name('daerah.cadangan.index');
    Route::post('/daerah/cadangan', [CadanganPanganController::class, 'store'])->name('daerah.cadangan.store');
    Route::put('/daerah/cadangan/{id}', [CadanganPanganController::class, 'update'])->name('daerah.cadangan.update');
    Route::delete('/daerah/cadangan/{id}', [CadanganPanganController::class, 'destroy'])->name('daerah.cadangan.destroy');

    // Harga Pangan
    Route::get('/daerah/harga', [HargaPanganController::class, 'index'])->name('daerah.harga.index');
    Route::post('/daerah/harga', [HargaPanganController::class, 'store'])->name('daerah.harga.store');
    Route::put('/daerah/harga/{id}', [HargaPanganController::class, 'update'])->name('daerah.harga.update');
    Route::delete('/daerah/harga/{id}', [HargaPanganController::class, 'destroy'])->name('daerah.harga.destroy');

    // Distribusi Pangan
    Route::get('/daerah/distribusi', [DistribusiPanganController::class, 'index'])->name('daerah.distribusi.index');
    Route::post('/daerah/distribusi', [DistribusiPanganController::class, 'store'])->name('daerah.distribusi.store');
    Route::put('/daerah/distribusi/{id}', [DistribusiPanganController::class, 'update'])->name('daerah.distribusi.update');
    Route::delete('/daerah/distribusi/{id}', [DistribusiPanganController::class, 'destroy'])->name('daerah.distribusi.destroy');

    // Prediksi Pangan
    Route::get('/daerah/prediksi', [PrediksiPanganController::class, 'index'])->name('daerah.prediksi.index');
    Route::put('/daerah/prediksi/{id}', [PrediksiPanganController::class, 'update'])->name('daerah.prediksi.update');

    // Artikel Gizi
    Route::get('/daerah/artikel', [ArtikelGiziController::class, 'index'])->name('daerah.artikel.index');
    Route::post('/daerah/artikel', [ArtikelGiziController::class, 'store'])->name('daerah.artikel.store');
    Route::put('/daerah/artikel/{id}', [ArtikelGiziController::class, 'update'])->name('daerah.artikel.update');
    Route::delete('/daerah/artikel/{id}', [ArtikelGiziController::class, 'destroy'])->name('daerah.artikel.destroy');
});

// Rute Dashboard User yang Dilindungi
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [HomeController::class, 'index'])->name('user.dashboard');
});
