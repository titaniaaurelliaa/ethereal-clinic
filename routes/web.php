<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// ==========================================
// 1. ROUTE LANDING PAGE
// ==========================================
Route::get('/', function () { 
    return view('welcome'); 
});
// Rute Halaman Tentang Kami
Route::get('/tentang-kami', function () {
    return view('tentang-kami');
})->name('tentang-kami');
// Rute Kebijakan Privasi
Route::get('/kebijakan-privasi', function () {
    return view('kebijakan-privasi');
})->name('kebijakan.privasi');
// Rute Syarat & Ketentuan
Route::get('/syarat-ketentuan', function () {
    return view('syarat-ketentuan');
})->name('syarat.ketentuan');


// ==========================================
// 2. ROUTE OTENTIKASI (LOGIN & REGISTER)
// ==========================================
Route::get('/login', function () { 
    return view('auth.login'); 
})->name('login');

Route::get('/register', function () { 
    return view('auth.register'); 
})->name('register');

// Proses Backend Auth
Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post')->middleware('throttle:5,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================
// 3. ROUTE DASHBOARD PASIEN
// ==========================================
// Memanggil file resources/views/pasien/dashboard.blade.php
Route::get('/pasien/dashboard', function () {
    return view('pasien.dashboard');
})->name('pasien.dashboard')->middleware(['auth', 'role:pasien']);


// ==========================================
// 4. ROUTE DASHBOARD ADMIN
// ==========================================
// Sementara masih return teks, nanti kita buatkan view-nya juga
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard')->middleware(['auth', 'role:admin']);