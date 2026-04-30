<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Profile_ADMController;
use App\Http\Controllers\Dashboard_ADMController;
use App\Http\Controllers\SkinProblemController;
use App\Http\Controllers\dataGejalaController;
use App\Http\Controllers\DataTreatment_ADMController;
use App\Http\Controllers\DataProduct_ADMController;

// ==========================================
// 1. ROUTE LANDING PAGE
// ==========================================
Route::get('/', function () { 
    return view('welcome'); 
});

Route::get('/tentang-kami', function () {
    return view('tentang-kami');
})->name('tentang-kami');

Route::get('/kebijakan-privasi', function () {
    return view('kebijakan-privasi');
})->name('kebijakan.privasi');

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

Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post')->middleware('throttle:5,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================
// 3. ROUTE PASIEN
// ==========================================
Route::get('/pasien/dashboard', function () {
    return view('pasien.dashboard');
})->name('pasien.dashboard')->middleware(['auth', 'role:pasien']);

Route::get('/pasien/profil', function () {
    return view('pasien.profil');
})->name('profil.index')->middleware(['auth', 'role:pasien']);

Route::put('/pasien/profil/update', [ProfilController::class, 'update'])->name('profil.update')->middleware(['auth', 'role:pasien']);

Route::delete('/pasien/profil/hapus', [ProfilController::class, 'destroy'])->name('profil.destroy')->middleware(['auth', 'role:pasien']);


// ==========================================
// 4. ROUTE ADMIN (GROUPING DENGAN MIDDLEWARE)
// ==========================================

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [Dashboard_ADMController::class, 'index'])->name('dashboard');
    
    // Profile Admin
    Route::get('/profile', [Profile_ADMController::class, 'index'])->name('profile');
    
    // CRUD Skin Problems (Masalah Kulit)
    Route::resource('skin-problems', SkinProblemController::class)->names([
        'index'   => 'skin-problems.index',
        'create'  => 'skin-problems.create',
        'store'   => 'skin-problems.store',
        'edit'    => 'skin-problems.edit',
        'update'  => 'skin-problems.update',
        'destroy' => 'skin-problems.destroy',
    ]);
    
    // CRUD Gejala / Symptoms
    Route::resource('symptoms', dataGejalaController::class)->names([
        'index'   => 'symptoms.index',
        'create'  => 'symptoms.create',
        'store'   => 'symptoms.store',
        'edit'    => 'symptoms.edit',
        'update'  => 'symptoms.update',
        'destroy' => 'symptoms.destroy',
    ]);
    
    // CRUD Treatment
    Route::resource('treatment', DataTreatment_ADMController::class)->names([
        'index'   => 'treatment.index',
        'create'  => 'treatment.create',
        'store'   => 'treatment.store',
        'edit'    => 'treatment.edit',
        'update'  => 'treatment.update',
        'destroy' => 'treatment.destroy',
    ]);

    // CRUD Products
    Route::resource('dataproduk', DataProduct_ADMController::class)->names([
        'index'   => 'dataproduk.index',
        'create'  => 'dataproduk.create',
        'store'   => 'dataproduk.store',
        'edit'    => 'dataproduk.edit',
        'update'  => 'dataproduk.update',
        'destroy' => 'dataproduk.destroy',
    ]);
    
});