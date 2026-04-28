@extends('layouts_admin.app')

@section('content')
<div class="container-fluid px-4 pb-5">
    {{-- Header Section --}}
    <div class="d-flex align-items-center gap-3 mb-5">
        <a href="{{ route('skin-problems.index') }}" class="btn btn-white shadow-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; color: #68575E;">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h3 class="fw-bold mb-0" style="color: #2D3748;">Tambah Masalah Kulit</h3>
            <p class="text-muted mb-0">Kelola dan definisikan detail kondisi medis baru untuk sistem pakar</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-10 col-xl-8"> {{-- Membuat form tidak terlalu lebar di monitor besar --}}
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
                {{-- Decorative Header di dalam Card --}}
                <div class="p-4 bg-light border-bottom border-light">
                    <h5 class="mb-0 fw-bold" style="color: #68575E;">Formulir Data Penyakit</h5>
                </div>

                <div class="card-body p-5">
                    <form action="{{ route('skin-problems.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-4">
                            {{-- Baris 1: Nama --}}
                            <div class="col-12">
                                <label class="form-label fw-bold text-secondary mb-2">Nama Masalah Kulit</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-notes-medical text-muted"></i></span>
                                    <input type="text" name="name" class="form-control form-control-lg border-0 bg-light" 
                                           placeholder="Contoh: Jerawat Batu (Acne Vulgaris)" required style="border-radius: 0 12px 12px 0;">
                                </div>
                            </div>

                            {{-- Baris 2: Tingkat Keparahan --}}
                            <div class="col-12">
                                <label class="form-label fw-bold text-secondary mb-2">Tingkat Keparahan</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-exclamation-triangle text-muted"></i></span>
                                    <select name="severity_level" class="form-select form-control-lg border-0 bg-light" 
                                            required style="border-radius: 0 12px 12px 0;">
                                        <option value="" selected disabled>Pilih Prioritas Risiko...</option>
                                        <option value="ringan">Ringan (Blue Alert)</option>
                                        <option value="sedang">Sedang (Medium Risk)</option>
                                        <option value="berat">Berat (High Priority)</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Baris 3: Deskripsi (Box Besar & Sejajar) --}}
                            <div class="col-12 d-flex flex-column"> {{-- Menambahkan flex-column memastikan label di atas input --}}
                                <label class="form-label fw-bold text-secondary mb-2" style="display: block; width: 100%;">Deskripsi Singkat</label>
                                <textarea name="description" rows="6" class="form-control border-0 bg-light p-3" 
                                        placeholder="Tuliskan penjelasan medis singkat mengenai karakteristik dan penyebab masalah kulit ini..." 
                                        required style="border-radius: 12px; resize: none; width: 100%;"></textarea>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex gap-3 justify-content-end mt-5 pt-4 border-top">
                            <a href="{{ route('skin-problems.index') }}" class="btn btn-link text-decoration-none text-secondary fw-bold px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-5 py-3 shadow-sm" 
                                    style="background-color: #68575E; border: none; border-radius: 12px; font-weight: 600;">
                                <i class="fas fa-save me-2"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Menyamakan tinggi input group agar rapi */
    .custom-input-group .input-group-text {
        border-radius: 12px 0 0 12px;
        padding-left: 20px;
    }
    .form-control:focus, .form-select:focus {
        box-shadow: none;
        background-color: #f1f3f5 !important;
        border: 1px solid #68575E !important;
    }
    label {
        font-size: 0.9rem;
        letter-spacing: 0.5px;
    }
</style>
@endsection