<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Profile_ADMController;
use App\Http\Controllers\Dashboard_ADMController;
use App\Http\Controllers\SkinProblemController;
use App\Http\Controllers\dataGejalaController as KnowledgeBaseController;
use App\Http\Controllers\DataTreatment_ADMController;
use App\Http\Controllers\DataProduct_ADMController;
use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\SymptomRuleController;
use App\Http\Controllers\Dashboard_PSNController;

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
Route::get('/pasien/dashboard', [Dashboard_PSNController::class, 'index'])->name('pasien.dashboard')->middleware(['auth', 'role:pasien']);
Route::get('/pasien/history', [Dashboard_PSNController::class, 'history'])->name('pasien.history')->middleware(['auth', 'role:pasien']);

Route::get('/pasien/profil', [ProfilController::class, 'index'])->name('profil.index')->middleware(['auth', 'role:pasien']);

Route::put('/pasien/profil/update', [ProfilController::class, 'update'])->name('profil.update')->middleware(['auth', 'role:pasien']);

Route::delete('/pasien/profil/hapus', [ProfilController::class, 'destroy'])->name('profil.destroy')->middleware(['auth', 'role:pasien']);

// ══════════════════════════════════════════════════════════════════
// Analisis Kulit Hybrid — 3-Step Flow
// ══════════════════════════════════════════════════════════════════
Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->name('analisis.')->group(function () {
    Route::get( '/analisis',              [AnalisisController::class, 'index']       )->name('index');
    Route::post('/analisis/scan',         [AnalisisController::class, 'scan']        )->name('scan');
    Route::post('/analisis/final',        [AnalisisController::class, 'processFinal'])->name('final');
    Route::get( '/analisis/{id}',         [AnalisisController::class, 'show']        )->name('show');
    Route::get( '/analisis/{id}/pdf',     [AnalisisController::class, 'exportPdf']   )->name('pdf');
});


// ==========================================
// 4. ROUTE ADMIN (GROUPING DENGAN MIDDLEWARE)
// ==========================================

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [Dashboard_ADMController::class, 'index'])->name('dashboard');
    
    // Profile Admin (gunakan Profile_ADMController langsung)
    Route::get('/profile', [Profile_ADMController::class, 'index'])->name('profile');
    Route::put('/profile/update', [Profile_ADMController::class, 'update'])->name('profile.update');
    Route::put('/profile/update-password', [Profile_ADMController::class, 'updatePassword'])->name('profile.update-password');
    Route::put('/profile/update-avatar', [Profile_ADMController::class, 'updateAvatar'])->name('profile.update-avatar');
    
    // CRUD Skin Problems (Masalah Kulit)
    Route::resource('skin-problems', SkinProblemController::class)->names([
        'index'   => 'skin-problems.index',
        'create'  => 'skin-problems.create',
        'store'   => 'skin-problems.store',
        'edit'    => 'skin-problems.edit',
        'update'  => 'skin-problems.update',
        'destroy' => 'skin-problems.destroy',
    ]);
    
    // CRUD Basis Pengetahuan Pakar (knowledge_bases)
    Route::resource('knowledge-base', KnowledgeBaseController::class)->names([
        'index'   => 'knowledge-base.index',
        'create'  => 'knowledge-base.create',
        'store'   => 'knowledge-base.store',
        'edit'    => 'knowledge-base.edit',
        'update'  => 'knowledge-base.update',
        'destroy' => 'knowledge-base.destroy',
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

    // Contextual Anamnesis — Pertanyaan Gejala Dinamis (Fase 2)
    Route::resource('symptom-rules', SymptomRuleController::class)->names([
        'index'   => 'symptom-rules.index',
        'create'  => 'symptom-rules.create',
        'store'   => 'symptom-rules.store',
        'edit'    => 'symptom-rules.edit',
        'update'  => 'symptom-rules.update',
        'destroy' => 'symptom-rules.destroy',
    ]);
    
});