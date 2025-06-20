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
use App\Http\Controllers\Nasional\NasionalCadanganPanganController;
use App\Http\Controllers\Nasional\NasionalDistribusiPanganController;
use App\Http\Controllers\Nasional\NasionalHargaPanganController;
use App\Http\Controllers\Nasional\NasionalProduksiPanganController;
use Illuminate\Support\Facades\Route;

// Rute Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Dashboard Publik untuk User Umum
Route::get('/', [HomeController::class, 'index'])->name('landingpage');
Route::get('/cadangan', [HomeController::class, 'cadanganIndex'])->name('cadangan.index');
Route::post('/cadangan/export', [HomeController::class, 'cadanganExport'])->name('cadangan.export');
Route::get('/harga', [HomeController::class, 'hargaIndex'])->name('harga.index');
Route::get('/harga-pangan', [HomeController::class, 'hargaIndex'])->name('harga-pangan.index');
Route::get('/distribusi', [HomeController::class, 'distribusiIndex'])->name('distribusi.index');
Route::get('/prediksi', [HomeController::class, 'prediksiIndex'])->name('prediksi.index');
Route::get('/edukasi', [HomeController::class, 'edukasiIndex'])->name('edukasi.index');
Route::get('/edukasi/{id}', [HomeController::class, 'edukasiShow'])->name('edukasi.show');

// Rute Dashboard Nasional dengan Autentikasi
Route::middleware(['auth', 'role:nasional'])->group(function () {
    Route::get('/nasional/dashboard', [App\Http\Controllers\DashboardController::class, 'nasional'])->name('nasional.dashboard');

    // Produksi Pangan
    Route::get('/nasional/produksi', [NasionalProduksiPanganController::class, 'index'])->name('nasional.produksi.index');
    Route::get('/nasional/produksi/pending', [NasionalProduksiPanganController::class, 'pending'])->name('nasional.produksi.pending');
    Route::get('/nasional/produksi/{produksiPangan}', [NasionalProduksiPanganController::class, 'show'])->name('nasional.produksi.show');
    Route::patch('/nasional/produksi/validasi/{produksiPangan}', [NasionalProduksiPanganController::class, 'validasi'])->name('nasional.produksi.validasi');
    Route::post('/nasional/produksi/export', [NasionalProduksiPanganController::class, 'export'])->name('nasional.produksi.export');

    // // Cadangan Pangan
    Route::get('/nasional/cadangan', [NasionalCadanganPanganController::class, 'index'])->name('nasional.cadangan.index');
    Route::get('/nasional/cadangan/pending', [NasionalCadanganPanganController::class, 'pending'])->name('nasional.cadangan.pending');
    Route::get('/nasional/cadangan/{cadanganPangan}', [NasionalCadanganPanganController::class, 'show'])->name('nasional.cadangan.show');
    Route::patch('/nasional/cadangan/{cadanganPangan}/validasi', [NasionalCadanganPanganController::class, 'validasi'])->name('nasional.cadangan.validasi');
    Route::post('/nasional/cadangan/export', [NasionalCadanganPanganController::class, 'export'])->name('nasional.cadangan.export');

    // Harga Pangan
    Route::get('harga', [NasionalHargaPanganController::class, 'index'])->name('nasional.harga.index');
    Route::post('harga/kirim-pesan', [NasionalHargaPanganController::class, 'kirimPesan'])->name('nasional.harga.kirim-pesan');
    Route::post('harga/export', [NasionalHargaPanganController::class, 'export'])->name('nasional.harga.export');

    // // Distribusi Pangan
    Route::get('/nasional/distribusi', [NasionalDistribusiPanganController::class, 'index'])->name('nasional.distribusi.index');
    // Route::get('/nasional/distribusi/{id}', [NasionalDistribusiPanganController::class, 'show'])->name('nasional.distribusi.show');

    // Prediksi Pangan
    Route::get('/nasional/prediksi', [App\Http\Controllers\Nasional\NasionalPrediksiPanganController::class, 'index'])->name('nasional.prediksi.index');
    Route::post('/nasional/prediksi/message', [App\Http\Controllers\Nasional\NasionalPrediksiPanganController::class, 'storeMessage'])->name('nasional.prediksi.message');
    Route::post('/nasional/prediksi/export', [App\Http\Controllers\Nasional\NasionalPrediksiPanganController::class, 'export'])->name('nasional.prediksi.export');

    // Distribusi Pangan
    Route::get('/nasional/distribusi', [App\Http\Controllers\Nasional\NasionalDistribusiPanganController::class, 'index'])->name('nasional.distribusi.index');
    Route::get('/nasional/distribusi/{id}', [App\Http\Controllers\Nasional\NasionalDistribusiPanganController::class, 'show'])->name('nasional.distribusi.show');
    Route::post('/nasional/distribusi/export', [App\Http\Controllers\Nasional\NasionalDistribusiPanganController::class, 'export'])->name('nasional.distribusi.export');
});

// Rute Dashboard Daerah dengan Autentikasi
Route::middleware(['auth', 'role:daerah'])->group(function () {
    Route::get('/daerah/dashboard', [DashboardController::class, 'daerah'])->name('daerah.dashboard');

    // Produksi Pangan
    Route::get('/daerah/produksi', [ProduksiPanganController::class, 'index'])->name('daerah.produksi.index');
    Route::get('/daerah/produksi/create', [ProduksiPanganController::class, 'create'])->name('daerah.produksi.create');
    Route::post('/daerah/produksi', [ProduksiPanganController::class, 'store'])->name('daerah.produksi.store');
    Route::get('/daerah/produksi/{produksiPangan}/edit', [ProduksiPanganController::class, 'edit'])->name('daerah.produksi.edit');
    Route::put('/daerah/produksi/{produksiPangan}', [ProduksiPanganController::class, 'update'])->name('daerah.produksi.update');
    Route::delete('/daerah/produksi/{produksiPangan}', [ProduksiPanganController::class, 'destroy'])->name('daerah.produksi.destroy');

    // Cadangan Pangan
    Route::get('/daerah/cadangan', [CadanganPanganController::class, 'index'])->name('daerah.cadangan.index');
    Route::get('/daerah/cadangan/create', [CadanganPanganController::class, 'create'])->name('daerah.cadangan.create');
    Route::post('/daerah/cadangan', [CadanganPanganController::class, 'store'])->name('daerah.cadangan.store');
    Route::get('/daerah/cadangan/{id}/edit', [CadanganPanganController::class, 'edit'])->name('daerah.cadangan.edit');
    Route::put('/daerah/cadangan/{id}', [CadanganPanganController::class, 'update'])->name('daerah.cadangan.update');
    Route::delete('/daerah/cadangan/{id}', [CadanganPanganController::class, 'destroy'])->name('daerah.cadangan.destroy');

    // Harga Pangan
    Route::get('/daerah/harga', [HargaPanganController::class, 'index'])->name('daerah.harga.index');
    Route::get('/daerah/harga/create', [HargaPanganController::class, 'create'])->name('daerah.harga.create');
    Route::post('/daerah/harga', [HargaPanganController::class, 'store'])->name('daerah.harga.store');
    Route::get('/daerah/harga/{id}/edit', [HargaPanganController::class, 'edit'])->name('daerah.harga.edit');
    Route::put('/daerah/harga/{id}', [HargaPanganController::class, 'update'])->name('daerah.harga.update');
    Route::delete('/daerah/harga/{id}', [HargaPanganController::class, 'destroy'])->name('daerah.harga.destroy');

    // Distribusi Pangan
    Route::get('/daerah/distribusi', [DistribusiPanganController::class, 'index'])->name('daerah.distribusi.index');
    Route::get('/daerah/distribusi/create', [DistribusiPanganController::class, 'create'])->name('daerah.distribusi.create');
    Route::post('/daerah/distribusi', [DistribusiPanganController::class, 'store'])->name('daerah.distribusi.store');
    Route::get('/daerah/distribusi/{id}/edit', [DistribusiPanganController::class, 'edit'])->name('daerah.distribusi.edit');
    Route::put('/daerah/distribusi/{id}', [DistribusiPanganController::class, 'update'])->name('daerah.distribusi.update');
    Route::delete('/daerah/distribusi/{id}', [DistribusiPanganController::class, 'destroy'])->name('daerah.distribusi.destroy');

    // Prediksi Pangan
    Route::get('/daerah/prediksi', [PrediksiPanganController::class, 'index'])->name('daerah.prediksi.index');
    Route::get('/daerah/prediksi/create', [PrediksiPanganController::class, 'create'])->name('daerah.prediksi.create');
    Route::post('/daerah/prediksi', [PrediksiPanganController::class, 'store'])->name('daerah.prediksi.store');
    Route::get('/daerah/prediksi/{id}/edit', [PrediksiPanganController::class, 'edit'])->name('daerah.prediksi.edit');
    Route::put('/daerah/prediksi/{id}', [PrediksiPanganController::class, 'update'])->name('daerah.prediksi.update');
    Route::delete('/daerah/prediksi/{id}', [PrediksiPanganController::class, 'destroy'])->name('daerah.prediksi.destroy');

    // Artikel Gizi
    Route::get('/daerah/artikel', [ArtikelGiziController::class, 'index'])->name('daerah.artikel.index');
    Route::get('/daerah/artikel/create', [ArtikelGiziController::class, 'create'])->name('daerah.artikel.create');
    Route::post('/daerah/artikel', [ArtikelGiziController::class, 'store'])->name('daerah.artikel.store');
    Route::get('/daerah/artikel/{id}/edit', [ArtikelGiziController::class, 'edit'])->name('daerah.artikel.edit');
    Route::put('/daerah/artikel/{id}', [ArtikelGiziController::class, 'update'])->name('daerah.artikel.update');
    Route::delete('/daerah/artikel/{id}', [ArtikelGiziController::class, 'destroy'])->name('daerah.artikel.destroy');
});

// Rute Dashboard User yang Dilindungi
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [HomeController::class, 'index'])->name('user.dashboard');
});
