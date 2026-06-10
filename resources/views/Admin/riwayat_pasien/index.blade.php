{{-- ══════════════════════════════════════════════════════════════════
     Manajemen Riwayat Pasien — INDEX (Master View)
     Daftar semua pasien dengan statistik scan & filter
     ══════════════════════════════════════════════════════════════════ --}}

@extends('layouts_admin.app')

@section('title', 'Manajemen Riwayat Pasien — The Ethereal Clinic')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- ── Page Header ─────────────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-[#5D605C] tracking-tight">Manajemen Riwayat Pasien</h1>
            <p class="text-sm text-[#797B78] mt-1">Pantau dan kelola seluruh riwayat medis pasien klinik.</p>
        </div>
        <div class="flex items-center gap-2 text-xs text-[#797B78]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>Total: <strong class="text-[#5D605C]">{{ $patients->total() }}</strong> pasien</span>
        </div>
    </div>

    {{-- ── Filter Bar ──────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-4 mb-5 shadow-sm">
        <form action="{{ route('admin.riwayat-pasien.index') }}" method="GET" class="flex gap-2">
            {{-- Search Input --}}
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#B0B3AE]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari nama atau email pasien..."
                       class="w-full pl-10 pr-4 py-2.5 text-sm border border-[#E1E3DE] rounded-xl bg-[#FAFAF9] text-[#5D605C] placeholder-[#B0B3AE] focus:outline-none focus:ring-2 focus:ring-pink-400/40 focus:border-pink-400 transition-all" />
            </div>

            {{-- Scan Count Filter --}}
            <div class="relative">
                <select name="scan_filter"
                        class="appearance-none w-full sm:w-48 pl-4 pr-10 py-2.5 text-sm border border-[#E1E3DE] rounded-xl bg-[#FAFAF9] text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-pink-400/40 focus:border-pink-400 transition-all cursor-pointer">
                    <option value="">Semua Jumlah Scan</option>
                    <option value="0" {{ request('scan_filter') === '0' ? 'selected' : '' }}>Belum pernah scan</option>
                    <option value="1-5" {{ request('scan_filter') === '1-5' ? 'selected' : '' }}>1 – 5 scan</option>
                    <option value="6-10" {{ request('scan_filter') === '6-10' ? 'selected' : '' }}>6 – 10 scan</option>
                    <option value="10+" {{ request('scan_filter') === '10+' ? 'selected' : '' }}>Lebih dari 10 scan</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#B0B3AE]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-pink-500 hover:bg-pink-600 text-white text-sm font-semibold rounded-xl shadow-sm hover:shadow transition-all focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filter
            </button>

            {{-- Reset --}}
            @if(request()->hasAny(['search', 'scan_filter']))
            <a href="{{ route('admin.riwayat-pasien.index') }}"
               class="inline-flex items-center justify-center px-4 py-2.5 border border-[#E1E3DE] text-sm font-medium text-[#797B78] rounded-xl hover:bg-[#F5F5F5] transition-all">
                Reset
            </a>
            @endif
        </form>
    </div>

    {{-- ── Table Card ──────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-[#E1E3DE] overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-pink-50/80 to-pink-50/30 border-b border-[#E1E3DE]">
                        <th class="px-5 py-4 text-left font-semibold text-[#5D605C] text-xs uppercase tracking-wider w-12">No</th>
                        <th class="px-5 py-4 text-left font-semibold text-[#5D605C] text-xs uppercase tracking-wider">Nama Pasien</th>
                        <th class="px-5 py-4 text-left font-semibold text-[#5D605C] text-xs uppercase tracking-wider">Email</th>
                        <th class="px-5 py-4 text-center font-semibold text-[#5D605C] text-xs uppercase tracking-wider">Total Scan</th>
                        <th class="px-5 py-4 text-left font-semibold text-[#5D605C] text-xs uppercase tracking-wider">Scan Terakhir</th>
                        <th class="px-5 py-4 text-center font-semibold text-[#5D605C] text-xs uppercase tracking-wider w-52">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E1E3DE]/60">
                    @forelse ($patients as $index => $patient)
                    <tr class="hover:bg-pink-50/30 transition-colors duration-150">
                        {{-- No --}}
                        <td class="px-5 py-4 text-[#797B78] font-medium">
                            {{ $patients->firstItem() + $index }}
                        </td>

                        {{-- Nama Pasien + Avatar Inisial --}}
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-pink-400 to-pink-600 flex items-center justify-center text-white text-sm font-bold shadow-sm shrink-0">
                                    {{ strtoupper(substr($patient->name, 0, 1)) }}
                                </div>
                                <span class="font-semibold text-[#5D605C]">{{ $patient->name }}</span>
                            </div>
                        </td>

                        {{-- Email --}}
                        <td class="px-5 py-4 text-[#797B78]">
                            {{ $patient->email }}
                        </td>

                        {{-- Total Scan --}}
                        <td class="px-5 py-4 text-center">
                            @if ($patient->total_scan > 0)
                                <span class="inline-flex items-center justify-center min-w-[2rem] px-2.5 py-1 bg-pink-100 text-pink-700 text-xs font-bold rounded-full">
                                    {{ $patient->total_scan }}
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center min-w-[2rem] px-2.5 py-1 bg-gray-100 text-gray-400 text-xs font-medium rounded-full">
                                    0
                                </span>
                            @endif
                        </td>

                        {{-- Tanggal Scan Terakhir --}}
                        <td class="px-5 py-4 text-[#797B78]">
                            @if ($patient->latestAnalysisHistory)
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-xs">{{ $patient->latestAnalysisHistory->created_at->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}</span>
                                </div>
                            @else
                                <span class="text-xs text-[#B0B3AE] italic">Belum pernah scan</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="px-5 py-4 text-center">
                            <a href="{{ route('admin.riwayat-pasien.show', $patient->id) }}"
                               class="inline-flex items-center gap-1.5 px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white text-xs font-semibold rounded-lg shadow-sm hover:shadow transition-all focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-offset-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Lihat Riwayat Medis
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-pink-50 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-pink-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <p class="text-[#797B78] font-medium">Tidak ada data pasien ditemukan.</p>
                                @if(request()->hasAny(['search', 'scan_filter']))
                                <a href="{{ route('admin.riwayat-pasien.index') }}"
                                   class="text-pink-500 hover:text-pink-600 text-sm font-medium underline underline-offset-2">
                                    Hapus semua filter
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── Pagination ──────────────────────────────────────────── --}}
        @if ($patients->hasPages())
        <div class="px-5 py-4 border-t border-[#E1E3DE]/60 bg-[#FAFAF9]/50">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-xs text-[#797B78]">
                    Menampilkan <strong>{{ $patients->firstItem() }}</strong>–<strong>{{ $patients->lastItem() }}</strong>
                    dari <strong>{{ $patients->total() }}</strong> pasien
                </p>
                <div>
                    {{ $patients->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>

</div>
@endsection
