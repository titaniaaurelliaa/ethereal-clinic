{{-- ══════════════════════════════════════════════════════════════════
     Manajemen Riwayat Pasien — SHOW (Detail View)
     Profil Ringkas + Timeline Riwayat Scan
     ══════════════════════════════════════════════════════════════════ --}}

@extends('layouts_admin.app')

@section('title', 'Riwayat Medis — ' . $patient->name)

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- ── Page Header + Back Button ───────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.riwayat-pasien.index') }}"
               class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-[#E1E3DE] bg-white text-[#797B78] hover:bg-pink-50 hover:text-pink-500 hover:border-pink-300 transition-all shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-[#5D605C] tracking-tight">Riwayat Medis Pasien</h1>
                <p class="text-sm text-[#797B78] mt-0.5">Detail seluruh scan dan diagnosis <strong class="text-pink-600">{{ $patient->name }}</strong></p>
            </div>
        </div>
    </div>

    {{-- ── 2-Column Layout ─────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- ════════════════════════════════════════════════════════════
             KOLOM KIRI — Profil Ringkas Pasien (1/3 lebar)
             ════════════════════════════════════════════════════════════ --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-[#E1E3DE] overflow-hidden shadow-sm lg:sticky lg:top-6">
                {{-- Avatar Banner --}}
                <div class="h-24 bg-gradient-to-br from-pink-400 via-pink-500 to-pink-600 relative">
                    <div class="absolute -bottom-8 left-1/2 -translate-x-1/2">
                        <div class="w-16 h-16 rounded-full bg-white border-4 border-white shadow-lg flex items-center justify-center">
                            <div class="w-full h-full rounded-full bg-gradient-to-br from-pink-400 to-pink-600 flex items-center justify-center text-white text-xl font-bold">
                                {{ strtoupper(substr($patient->name, 0, 1)) }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Info Pasien --}}
                <div class="pt-12 pb-6 px-5 text-center">
                    <h2 class="text-lg font-bold text-[#5D605C]">{{ $patient->name }}</h2>
                    <p class="text-xs text-[#797B78] mt-0.5">{{ $patient->email }}</p>
                </div>

                {{-- Detail Stats --}}
                <div class="border-t border-[#E1E3DE]/60 divide-y divide-[#E1E3DE]/60">
                    {{-- Tanggal Bergabung --}}
                    <div class="flex items-center gap-3 px-5 py-3.5">
                        <div class="w-8 h-8 rounded-lg bg-pink-50 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] text-[#B0B3AE] uppercase tracking-wider font-semibold">Bergabung Sejak</p>
                            <p class="text-sm font-semibold text-[#5D605C]">{{ $patient->created_at->locale('id')->isoFormat('D MMMM YYYY') }}</p>
                        </div>
                    </div>

                    {{-- Tipe Kulit --}}
                    <div class="flex items-center gap-3 px-5 py-3.5">
                        <div class="w-8 h-8 rounded-lg bg-pink-50 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] text-[#B0B3AE] uppercase tracking-wider font-semibold">Tipe Kulit</p>
                            <p class="text-sm font-semibold text-[#5D605C] capitalize">{{ $patient->skin_type ?? '—' }}</p>
                        </div>
                    </div>

                    {{-- Total Scan --}}
                    <div class="flex items-center gap-3 px-5 py-3.5">
                        <div class="w-8 h-8 rounded-lg bg-pink-50 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] text-[#B0B3AE] uppercase tracking-wider font-semibold">Total Diagnosis</p>
                            <p class="text-sm font-semibold text-[#5D605C]">{{ $patient->total_scan }} kali scan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════════════════════════
             KOLOM KANAN — Timeline Track Riwayat Scan (2/3 lebar)
             ════════════════════════════════════════════════════════════ --}}
        <div class="lg:col-span-2">

            @if ($histories->isEmpty())
                {{-- Empty State --}}
                <div class="bg-white rounded-2xl border border-[#E1E3DE] p-12 text-center shadow-sm">
                    <div class="w-16 h-16 rounded-full bg-pink-50 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-pink-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-[#797B78] font-medium">Pasien ini belum memiliki riwayat scan.</p>
                    <p class="text-xs text-[#B0B3AE] mt-1">Riwayat akan muncul setelah pasien melakukan analisis kulit.</p>
                </div>
            @else
                {{-- Timeline Container --}}
                <div class="relative">
                    {{-- Vertical Timeline Line --}}
                    <div class="absolute left-[17px] top-4 bottom-4 w-0.5 bg-gradient-to-b from-pink-300 via-pink-200 to-pink-100 rounded-full"></div>

                    <div class="space-y-5">
                        @foreach ($histories as $history)
                        @php
                            // Hitung severity badge
                            $cs = $history->confidence_score;
                            $skorKesehatan = max(0, round(100 - $cs));

                            if ($skorKesehatan >= 80) {
                                $badgeLabel = 'Kulit Sehat';
                                $badgeClass = 'bg-emerald-100 text-emerald-700 ring-emerald-200';
                            } elseif ($skorKesehatan >= 60) {
                                $badgeLabel = 'Ringan';
                                $badgeClass = 'bg-green-100 text-green-700 ring-green-200';
                            } elseif ($skorKesehatan >= 40) {
                                $badgeLabel = 'Sedang';
                                $badgeClass = 'bg-yellow-100 text-yellow-700 ring-yellow-200';
                            } elseif ($skorKesehatan >= 20) {
                                $badgeLabel = 'Parah';
                                $badgeClass = 'bg-red-100 text-red-700 ring-red-200';
                            } else {
                                $badgeLabel = 'Sangat Parah';
                                $badgeClass = 'bg-red-200 text-red-800 ring-red-300';
                            }

                            $analysisData      = $history->analysis_data ?? [];
                            $temuanKlinis      = $analysisData['temuan_klinis'] ?? [];
                            $breakdownCf       = $analysisData['breakdown_cf'] ?? [];
                            $jawabanAnamnesis  = $analysisData['jawaban_anamnesis'] ?? [];
                            $cfFinalDecimal    = round($cs / 100, 4);
                        @endphp

                        <div class="relative pl-12">
                            {{-- Timeline Dot --}}
                            <div class="absolute left-[11px] top-5 w-3 h-3 bg-pink-500 rounded-full ring-4 ring-pink-100 shadow-sm z-10"></div>

                            {{-- Scan Card --}}
                            <div class="bg-white rounded-2xl border border-[#E1E3DE] overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">

                                {{-- ── Card Header (Clickable Toggle) ──── --}}
                                <button onclick="toggleScanCard({{ $history->id }})"
                                        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-pink-50/30 transition-colors duration-150 group">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="shrink-0">
                                            <p class="text-sm font-bold text-[#5D605C]">
                                                {{ $history->created_at->locale('id')->isoFormat('D MMMM YYYY') }}
                                            </p>
                                            <p class="text-xs text-[#797B78] mt-0.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline -mt-0.5 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $history->created_at->format('H:i') }} WIB
                                                @if($history->skinProblem)
                                                    <span class="text-[#B0B3AE] mx-1">·</span>
                                                    <span class="text-pink-600 font-medium">{{ $history->skinProblem->name }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 shrink-0">
                                        {{-- Severity Badge --}}
                                        <span class="inline-flex items-center px-2.5 py-1 text-[11px] font-bold rounded-full ring-1 {{ $badgeClass }}">
                                            {{ $badgeLabel }}
                                        </span>
                                        {{-- Chevron --}}
                                        <svg id="chevron-{{ $history->id }}"
                                             xmlns="http://www.w3.org/2000/svg"
                                             class="h-4 w-4 text-[#B0B3AE] transition-transform duration-300 {{ $loop->first ? 'rotate-180' : '' }}"
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </button>

                                {{-- ── Card Content (Collapsible) ──────── --}}
                                <div id="content-{{ $history->id }}"
                                     class="overflow-hidden transition-all duration-300 ease-in-out"
                                     style="max-height: {{ $loop->first ? '2000px' : '0px' }};">
                                    <div class="border-t border-[#E1E3DE]/60 px-5 py-5">

                                        {{-- 3-Column Micro Grid --}}
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                                            {{-- ── Kolom 1: Hasil Visual AI ──── --}}
                                            <div class="bg-[#FAFAF9] rounded-xl p-4 border border-[#E1E3DE]/60">
                                                <div class="flex items-center gap-2 mb-3">
                                                    <div class="w-6 h-6 rounded-md bg-blue-100 flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </div>
                                                    <h4 class="text-xs font-bold text-[#5D605C] uppercase tracking-wider">Hasil Visual AI</h4>
                                                </div>

                                                @if (!empty($temuanKlinis))
                                                    <div class="space-y-2">
                                                        @foreach ($temuanKlinis as $temuan)
                                                        <div class="flex items-start justify-between gap-2 text-xs">
                                                            <div class="min-w-0">
                                                                <p class="font-semibold text-[#5D605C] truncate">{{ $temuan['nama_objek'] ?? '-' }}</p>
                                                                <p class="text-[#B0B3AE]">{{ $temuan['jumlah'] ?? 0 }} objek terdeteksi</p>
                                                            </div>
                                                            <span class="shrink-0 inline-flex items-center px-1.5 py-0.5 bg-blue-50 text-blue-600 text-[10px] font-bold rounded-md">
                                                                {{ number_format(($temuan['cf_final'] ?? 0) * 100, 0) }}%
                                                            </span>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="text-xs text-[#B0B3AE] italic">Tidak ada objek terdeteksi</p>
                                                @endif
                                            </div>

                                            {{-- ── Kolom 2: Hasil Anamnesis ──── --}}
                                            <div class="bg-[#FAFAF9] rounded-xl p-4 border border-[#E1E3DE]/60">
                                                <div class="flex items-center gap-2 mb-3">
                                                    <div class="w-6 h-6 rounded-md bg-purple-100 flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                                        </svg>
                                                    </div>
                                                    <h4 class="text-xs font-bold text-[#5D605C] uppercase tracking-wider">Hasil Anamnesis</h4>
                                                </div>

                                                @if (!empty($jawabanAnamnesis))
                                                    <div class="space-y-2">
                                                        @foreach ($jawabanAnamnesis as $ruleId => $value)
                                                        <div class="text-xs">
                                                            <p class="text-[#5D605C] leading-snug">{{ $symptomRules[$ruleId] ?? 'Gejala #'.$ruleId }}</p>
                                                            <div class="flex items-center gap-2 mt-1">
                                                                <div class="flex-1 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                                                    <div class="h-full bg-gradient-to-r from-purple-400 to-purple-600 rounded-full" style="width: {{ floatval($value) * 100 }}%"></div>
                                                                </div>
                                                                <span class="text-[10px] font-bold text-purple-600 shrink-0">{{ number_format(floatval($value) * 100, 0) }}%</span>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="text-xs text-[#B0B3AE] italic">Tidak ada data anamnesis</p>
                                                @endif

                                                {{-- CF Breakdown --}}
                                                @if (!empty($breakdownCf))
                                                <div class="mt-3 pt-3 border-t border-[#E1E3DE]/60">
                                                    <p class="text-[10px] text-[#B0B3AE] font-semibold uppercase tracking-wider mb-1.5">Breakdown CF</p>
                                                    <div class="flex items-center justify-between text-xs">
                                                        <span class="text-[#797B78]">CF Visual</span>
                                                        <span class="font-bold text-blue-600">{{ number_format(($breakdownCf['cf_visual'] ?? 0) * 100, 1) }}%</span>
                                                    </div>
                                                    <div class="flex items-center justify-between text-xs mt-0.5">
                                                        <span class="text-[#797B78]">CF Anamnesis</span>
                                                        <span class="font-bold text-purple-600">{{ number_format(($breakdownCf['cf_gejala'] ?? 0) * 100, 1) }}%</span>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>

                                            {{-- ── Kolom 3: Hasil Akhir & Rekomendasi ── --}}
                                            <div class="bg-[#FAFAF9] rounded-xl p-4 border border-[#E1E3DE]/60">
                                                <div class="flex items-center gap-2 mb-3">
                                                    <div class="w-6 h-6 rounded-md bg-pink-100 flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                        </svg>
                                                    </div>
                                                    <h4 class="text-xs font-bold text-[#5D605C] uppercase tracking-wider">Hasil Akhir</h4>
                                                </div>

                                                {{-- CF Final Score --}}
                                                <div class="text-center mb-3 py-2 bg-white rounded-lg border border-[#E1E3DE]/60">
                                                    <p class="text-2xl font-extrabold text-pink-600">{{ $cfFinalDecimal }}</p>
                                                    <p class="text-xs text-[#797B78] font-medium">{{ number_format($cs, 1) }}% Confidence</p>
                                                    <span class="inline-flex items-center mt-1 px-2 py-0.5 text-[10px] font-bold rounded-full ring-1 {{ $badgeClass }}">{{ $badgeLabel }}</span>
                                                </div>

                                                {{-- Rekomendasi Produk --}}
                                                @if (!empty($history->recommended_products))
                                                <div class="mb-2.5">
                                                    <p class="text-[10px] text-[#B0B3AE] font-semibold uppercase tracking-wider mb-1.5">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline -mt-0.5 mr-0.5 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                        </svg>
                                                        Bahan Aktif / Produk
                                                    </p>
                                                    <div class="space-y-1">
                                                        @foreach ($history->recommended_products as $prod)
                                                        <div class="flex items-center gap-1.5 text-xs">
                                                            <span class="w-1 h-1 bg-pink-400 rounded-full shrink-0"></span>
                                                            <span class="text-[#5D605C]">{{ $prod['nama_produk'] ?? '-' }}</span>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @endif

                                                {{-- Rekomendasi Treatment --}}
                                                @if (!empty($history->recommended_treatments))
                                                <div>
                                                    <p class="text-[10px] text-[#B0B3AE] font-semibold uppercase tracking-wider mb-1.5">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline -mt-0.5 mr-0.5 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                                        </svg>
                                                        Treatment Klinik
                                                    </p>
                                                    <div class="space-y-1">
                                                        @foreach ($history->recommended_treatments as $treat)
                                                        <div class="flex items-center gap-1.5 text-xs">
                                                            <span class="w-1 h-1 bg-pink-400 rounded-full shrink-0"></span>
                                                            <span class="text-[#5D605C]">{{ $treat['nama_treatment'] ?? '-' }}</span>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @endif

                                                @if (empty($history->recommended_products) && empty($history->recommended_treatments))
                                                    <p class="text-xs text-[#B0B3AE] italic">Tidak ada rekomendasi</p>
                                                @endif
                                            </div>

                                        </div>{{-- end 3-col grid --}}

                                    </div>
                                </div>{{-- end collapsible --}}

                            </div>{{-- end card --}}
                        </div>{{-- end timeline item --}}
                        @endforeach
                    </div>{{-- end space-y --}}
                </div>{{-- end timeline container --}}

                {{-- ── Pagination ──────────────────────────────────── --}}
                @if ($histories->hasPages())
                <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <p class="text-xs text-[#797B78]">
                        Menampilkan <strong>{{ $histories->firstItem() }}</strong>–<strong>{{ $histories->lastItem() }}</strong>
                        dari <strong>{{ $histories->total() }}</strong> riwayat scan
                    </p>
                    <div>
                        {{ $histories->links() }}
                    </div>
                </div>
                @endif
            @endif

        </div>{{-- end right column --}}
    </div>{{-- end grid --}}

</div>

{{-- ── JavaScript: Toggle Collapsible Cards ────────────────────────── --}}
<script>
    function toggleScanCard(id) {
        const content = document.getElementById('content-' + id);
        const chevron = document.getElementById('chevron-' + id);

        if (!content) return;

        if (content.style.maxHeight && content.style.maxHeight !== '0px') {
            content.style.maxHeight = '0px';
            if (chevron) chevron.classList.remove('rotate-180');
        } else {
            content.style.maxHeight = content.scrollHeight + 'px';
            if (chevron) chevron.classList.add('rotate-180');
        }
    }
</script>
@endsection
