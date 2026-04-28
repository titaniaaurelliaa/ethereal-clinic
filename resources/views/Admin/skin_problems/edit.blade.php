@extends('layouts_admin.app')

@section('content')
<div class="container-fluid px-4 pb-5">
    {{-- Header Section --}}
    <div class="d-flex align-items-center gap-3 mb-5">
        <a href="{{ route('skin-problems.index') }}" class="btn btn-white shadow-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; color: #68575E;">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h3 class="fw-bold mb-0" style="color: #2D3748;">Edit Masalah Kulit</h3>
            <p class="text-muted mb-0">Memperbarui data: <span class="fw-bold" style="color: #68575E;">{{ $problem->name }}</span></p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-10 col-xl-8">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
                {{-- Decorative Header --}}
                <div class="p-4 bg-light border-bottom border-light">
                    <h5 class="mb-0 fw-bold" style="color: #68575E;">Formulir Pembaruan Data</h5>
                </div>

                <div class="card-body p-5">
                    <form action="{{ route('skin-problems.update', $problem->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4">
                            {{-- Nama Masalah Kulit --}}
                            <div class="col-12 d-flex flex-column">
                                <label class="form-label fw-bold text-secondary mb-2">Nama Masalah Kulit</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-notes-medical text-muted"></i></span>
                                    <input type="text" name="name" value="{{ $problem->name }}" 
                                           class="form-control form-control-lg border-0 bg-light" 
                                           required style="border-radius: 0 12px 12px 0;">
                                </div>
                            </div>

                            {{-- Tingkat Keparahan --}}
                            <div class="col-12 d-flex flex-column">
                                <label class="form-label fw-bold text-secondary mb-2">Tingkat Keparahan</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-exclamation-triangle text-muted"></i></span>
                                    <select name="severity_level" class="form-select form-control-lg border-0 bg-light" 
                                            required style="border-radius: 0 12px 12px 0;">
                                        <option value="ringan" {{ $problem->severity_level == 'ringan' ? 'selected' : '' }}>Ringan (Blue Alert)</option>
                                        <option value="sedang" {{ $problem->severity_level == 'sedang' ? 'selected' : '' }}>Sedang (Medium Risk)</option>
                                        <option value="berat" {{ $problem->severity_level == 'berat' ? 'selected' : '' }}>Berat (High Priority)</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Deskripsi Singkat --}}
                            <div class="col-12 d-flex flex-column">
                                <label class="form-label fw-bold text-secondary mb-2" style="display: block; width: 100%;">Deskripsi Singkat</label>
                                <textarea name="description" rows="6" class="form-control border-0 bg-light p-3" 
                                          required style="border-radius: 12px; resize: none; width: 100%;">{{ $problem->description }}</textarea>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex gap-3 justify-content-end mt-5 pt-4 border-top">
                            <a href="{{ route('skin-problems.index') }}" class="btn btn-link text-decoration-none text-secondary fw-bold px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-5 py-3 shadow-sm" 
                                    style="background-color: #68575E; border: none; border-radius: 12px; font-weight: 600;">
                                <i class="fas fa-sync me-2"></i> Perbarui Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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