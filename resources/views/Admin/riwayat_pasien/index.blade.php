{{-- ══════════════════════════════════════════════════════════════════
     Manajemen Riwayat Pasien — INDEX (Master View)
     Daftar semua pasien dengan statistik scan & filter
     ══════════════════════════════════════════════════════════════════ --}}

@extends('layouts_admin.app')

@section('title', 'Manajemen Riwayat Pasien — The Ethereal Clinic')

@section('content')
<div class="container">

    {{-- ── Page Header ─────────────────────────────────────────────── --}}
    <div class="flex flex-wrap justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Riwayat Pasien</h1>
            <p class="text-sm text-gray-400 mt-0.5">Pantau dan kelola seluruh riwayat medis pasien klinik</p>
        </div>
        <div class="flex items-center gap-2 text-xs text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>Total: <strong class="text-gray-800">{{ $patients->total() }}</strong> pasien</span>
        </div>
    </div>

    {{-- ── FILTER BAR ──────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-4 mb-5 shadow-sm">
        <form action="{{ route('admin.riwayat-pasien.index') }}" method="GET" class="flex flex-wrap gap-3">
            {{-- Search Input --}}
            <input type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama atau email pasien..."
                class="flex-1 min-w-[180px] px-3 py-2 border border-gray-500 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400">

            {{-- Scan Count Filter --}}
            <select name="scan_filter"
                    class="px-3 py-2 border border-gray-500 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400">
                <option value="">Semua Jumlah Scan</option>
                <option value="0" {{ request('scan_filter') === '0' ? 'selected' : '' }}>Belum pernah scan</option>
                <option value="1-5" {{ request('scan_filter') === '1-5' ? 'selected' : '' }}>1 – 5 scan</option>
                <option value="6-10" {{ request('scan_filter') === '6-10' ? 'selected' : '' }}>6 – 10 scan</option>
                <option value="10+" {{ request('scan_filter') === '10+' ? 'selected' : '' }}>Lebih dari 10 scan</option>
            </select>

            {{-- Submit --}}
            <button type="submit"
                    class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition flex items-center gap-2">
                <i class="fas fa-search"></i> Cari
            </button>

            {{-- Reset --}}
            @if(request('search') || request('scan_filter'))
            <a href="{{ route('admin.riwayat-pasien.index') }}"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition flex items-center gap-2">
                <i class="fas fa-times"></i> Reset
            </a>
            @endif
        </form>
    </div>

    {{-- ── TABLE ───────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
            <h3 class="font-semibold text-gray-700">Daftar Pasien</h3>
            <span class="text-xs text-gray-400">Total: {{ $patients->total() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-pink-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="p-4 text-left">No</th>
                        <th class="p-4 text-left">Nama Pasien</th>
                        <th class="p-4 text-left">Email</th>
                        <th class="p-4 text-center">Total Scan</th>
                        <th class="p-4 text-left">Scan Terakhir</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($patients as $index => $patient)
                    <tr class="hover:bg-pink-50 transition-colors duration-150">
                        <td class="p-4 text-gray-400 text-xs">
                            {{ $patients->firstItem() + $index }}
                        </td>

                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-pink-100 flex items-center justify-center text-pink-600 text-sm font-bold">
                                    {{ strtoupper(substr($patient->name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-800">{{ $patient->name }}</span>
                            </div>
                        </td>

                        <td class="p-4 text-gray-500">
                            {{ $patient->email }}
                        </td>

                        <td class="p-4 text-center">
                            @if ($patient->total_scan > 0)
                                <span class="inline-flex items-center justify-center px-2.5 py-1 bg-pink-100 text-pink-600 text-xs font-bold rounded-full">
                                    {{ $patient->total_scan }}
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center px-2.5 py-1 bg-gray-100 text-gray-400 text-xs font-medium rounded-full">
                                    0
                                </span>
                            @endif
                        </td>

                        <td class="p-4 text-gray-500 text-xs">
                            @if ($patient->latestAnalysisHistory)
                                <div class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $patient->latestAnalysisHistory->created_at->locale('id')->isoFormat('D MMM YYYY') }}</span>
                                </div>
                            @else
                                <span class="text-xs text-gray-400 italic">Belum pernah scan</span>
                            @endif
                        </td>

                        <td class="p-4 text-center">
                            <a href="{{ route('admin.riwayat-pasien.show', $patient->id) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs bg-pink-100 text-pink-600 rounded-lg hover:bg-pink-500 hover:text-white transition-colors font-medium">
                                <i class="fas fa-eye"></i> Lihat Riwayat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-10 text-center text-gray-400">
                            <i class="fas fa-inbox text-2xl mb-2 block"></i>
                            Tidak ada data pasien ditemukan
                            @if(request('search') || request('scan_filter'))
                            <a href="{{ route('admin.riwayat-pasien.index') }}" class="block text-pink-500 text-sm mt-2 hover:underline">
                                Hapus filter
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── PAGINATION ──────────────────────────────────────────── --}}
        @if ($patients->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $patients->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>
@endsection