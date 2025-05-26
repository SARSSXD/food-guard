<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

// Rute Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Dashboard berdasarkan role
Route::middleware(['auth', 'role:nasional'])->group(function () {
    Route::get('/nasional/dashboard', function () {
        return view('nasional.dashboard');
    })->name('nasional.dashboard');
});

Route::middleware(['auth', 'role:daerah'])->group(function () {
    Route::get('/daerah/dashboard', function () {
        return view('daerah.dashboard');
    })->name('daerah.dashboard');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});

// Redirect root ke login
Route::get('/', function () {
    return view('welcome');
});
