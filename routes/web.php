<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route Tampilan
Route::get('/', function () { return view('welcome'); });
Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::get('/register', function () { return view('auth.register'); })->name('register');

// Route Proses Backend
Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');
// throttle:5,1 artinya: maksimal 5 kali percobaan dalam 1 menit
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post')->middleware('throttle:5,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Dashboard Admin (Hanya bisa diakses oleh role:admin)
Route::get('/admin/dashboard', function () {
    return 'Selamat datang, Tuan Admin!';
})->name('admin.dashboard')->middleware(['auth', 'role:admin']);

// Route Dashboard Pasien (Hanya bisa diakses oleh role:pasien)
Route::get('/pasien/dashboard', function () {
    return 'Selamat datang, Pasien! Silakan mulai konsultasi.';
})->name('pasien.dashboard')->middleware(['auth', 'role:pasien']);