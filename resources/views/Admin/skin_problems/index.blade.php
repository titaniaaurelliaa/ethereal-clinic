@extends('layouts_admin.app')

@section('title', 'Data Masalah Kulit')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Data Masalah Kulit</h1>
    </div>
        <!-- Card Tambah Masalah Kulit -->
        <div class="flex flex-col justify-end pb-1"> {{-- justify-end mendorong tombol ke bawah --}}
            <a href="{{ route('admin.skin-problems.create') }}"
                class="btn d-inline-flex align-items-center justify-content-center gap-2"
                style="background-color: #9B6B6C;
                        color: white;
                        border: none;
                        border-radius: 12px; {{-- Sudut membulat sesuai gambar --}}
                        padding: 12px 24px; {{-- Ukuran tombol tetap proporsional --}}
                        box-shadow: 0 4px 12px rgba(104, 87, 94, 0.3);
                        transition: all 0.3s ease;
                        width: fit-content; {{-- Agar tombol tidak melebar penuh jika tidak diinginkan --}}
                        align-self: flex-end; {{-- Opsional: geser ke kanan kolom --}}">
                <i class="fas fa-plus-circle"></i>
                <span class="fw-bold">Tambah Masalah Kulit</span>
            </a>
        </div>
    </div>

    {{-- 2. Tabel Data --}}
    <div class="card shadow-sm border-0 mt-4" style="border-radius: 20px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="width: 100%; table-layout: fixed;">
                    <thead style="background-color: #fcf9f9;">
                        <tr>
                            <th class="ps-4 py-3 text-secondary small fw-bold" style="width: 10%;">KODE</th>
                            <th class="py-3 text-secondary small fw-bold" style="width: 25%;">NAMA MASALAH KULIT</th>
                            <th class="py-3 text-secondary small fw-bold" style="width: 35%;">DESKRIPSI SINGKAT</th>
                            <th class="py-3 text-secondary small fw-bold" style="width: 18%;">TINGKAT KEPARAHAN</th>
                            <th class="text-center py-3 text-secondary small fw-bold" style="width: 12%;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($problems as $item)
                        <tr class="border-bottom border-light">
                            {{-- Kolom KODE --}}
                            <td class="text-center">
                                <span class="badge bg-light text-secondary border-0 px-2 py-2"
                                    style="border-radius: 8px; font-size: 0.8rem; display: inline-block; min-width: 50px;">
                                    P{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            {{-- Kolom Nama --}}
                            <td class="align-middle">
                                {{-- Container utama: Memaksa ikon dan teks sejajar horizontal (row) --}}
                                <div style="display: flex; align-items: center; justify-content: flex-start; width: 100%;">
                                    {{-- Kotak Ikon: d-flex di sini memastikan ikon CSS FontAwesome tepat di tengah kotak --}}
                                    <div style="
                                        width: 32px;
                                        height: 32px;
                                        background-color: #fdf2f2;
                                        color: #68575E;
                                        border-radius: 50%;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        flex-shrink: 0;
                                        margin-right: 12px;
                                    ">
                                        <i class="fas fa-virus" style="font-size: 14px; line-height: 0;"></i>
                                    </div>
                                    {{-- Container Teks: Memastikan teks nama penyakit berada di kanan ikon --}}
                                    <div style="display: block;">
                                        <span style="
                                            font-weight: 700;
                                            color: #2d3436;
                                            font-size: 0.9rem;
                                            display: block;
                                            line-height: 1.2;
                                        ">
                                            {{ $item->name }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-muted small">
                                <div style="word-wrap: break-word; white-space: normal;">
                                    {{ Str::limit($item->description, 90) }}
                                </div>
                            </td>
                            {{-- Kolom Tingkat Keparahan --}}
                            <td class="text-center">
                                @php
                                    $badgeStyle = [
                                        'ringan' => 'background-color: #f0f7ff; color: #007bff;',
                                        'sedang' => 'background-color: #fff9f0; color: #ff9800;',
                                        'berat'  => 'background-color: #fff0f0; color: #dc3545;'
                                    ][$item->severity_level] ?? 'background-color: #f8f9fa; color: #6c757d;';
                                @endphp
                                <span class="badge rounded-pill px-3 py-2 fw-medium" style="{{ $badgeStyle }}; font-size: 0.75rem; display: inline-block;">
                                    ● {{ ucfirst($item->severity_level) }}
                                </span>
                            </td>
                            {{-- Kolom Aksi --}}
                            <td class="text-center py-3">
                                {{-- Container utama menggunakan inline-flex agar tidak melebar ke seluruh kolom --}}
                                <div class="d-inline-flex align-items-center justify-content-center gap-2">

                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.skin-problems.edit', $item->id) }}"
                                    class="btn btn-sm btn-white shadow-sm border-0 d-flex align-items-center justify-content-center"
                                    style="width: 35px; height: 35px; border-radius: 8px; background-color: #ffffff;"
                                    title="Edit">
                                        <i class="fas fa-edit text-primary"></i>
                                    </a>

                                    {{-- Form Hapus --}}
                                    <form action="{{ route('admin.skin-problems.destroy', $item->id) }}"
                                        method="POST"
                                        class="d-contents"> {{-- d-contents menghilangkan pengaruh box form --}}
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-white shadow-sm border-0 d-flex align-items-center justify-content-center"
                                                style="width: 35px; height: 35px; border-radius: 8px; background-color: #ffffff;"
                                                onclick="return confirm('Yakin ingin menghapus data?')">
                                            <i class="fas fa-trash-alt text-danger"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        /* Paksa tabel menggunakan seluruh lebar */
        .table {
            width: 100% !important;
            margin-bottom: 0;
        }

        /* Tombol aksi agar berbentuk kotak rapi */
        .action-btn {
            background-color: #ffffff;
            border-radius: 8px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .action-btn:hover {
            background-color: #f8f9fa;
            transform: translateY(-1px);
        }

        /* Hilangkan garis bawah pada baris terakhir */
        tr:last-child {
            border-bottom: none !important;
        }
    </style>
</div>

@endsection
