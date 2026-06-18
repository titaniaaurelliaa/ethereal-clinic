@extends('layouts_pasien.app')
@section('title', 'Hasil Analisis Kulit')

@section('content')

{{-- NAVIGASI KONTEKSTUAL & PAGE HEADER --}}
@if(isset($history))
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 w-full">
            <a href="{{ route('pasien.history') }}"
            class="inline-flex items-center gap-3 py-2 pl-2 pr-5 rounded-full bg-white border border-[#E1E3DE]/60 text-sm font-bold text-[#5D605C] hover:text-[#7B5556] hover:bg-[#EBDBDD]/15 hover:border-[#7B5556]/20 shadow-sm hover:shadow transition-all duration-300 group">
                <div class="w-8 h-8 rounded-full bg-[#EBDBDD]/50 group-hover:bg-[#7B5556] flex items-center justify-center transition-colors duration-300">
                    <svg class="w-4 h-4 text-[#7B5556] group-hover:text-white transform group-hover:-translate-x-0.5 transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </div>
                <span class="tracking-tight">Kembali ke Semua Rekam Medis</span>
            </a>
        
        <div class="shrink-0">
            <span class="inline-block py-1.5 px-3.5 rounded-full bg-[#5D605C]/10 text-[#5D605C] text-xs font-bold tracking-wider uppercase">
                Dokumen Arsip Rekam Medis
            </span>
        </div>
    </div>
@else
    {{-- Konteks: Baru selesai melakukan scan analisis baru --}}
    <div class="mb-6">
        <a href="{{ route('pasien.dashboard') }}"
           class="inline-flex items-center gap-2 text-sm font-medium text-[#797B78] hover:text-[#7B5556] transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Beranda
        </a>
    </div>

    {{-- STEPPER --}}
    <div class="flex items-center justify-center gap-0 mb-10">
        <div class="flex items-center gap-2">
            <div class="flex items-center justify-center w-9 h-9 rounded-full bg-[#8B3A3A]/20 text-[#8B3A3A] text-sm font-bold">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <span class="text-sm font-medium text-[#8B3A3A]/50 uppercase tracking-wide">Unggah</span>
        </div>
        <div class="w-16 h-px bg-[#8B3A3A]/30 mx-3"></div>
        <div class="flex items-center gap-2">
            <div class="flex items-center justify-center w-9 h-9 rounded-full bg-[#8B3A3A]/20 text-[#8B3A3A] text-sm font-bold">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <span class="text-sm font-medium text-[#8B3A3A]/50 uppercase tracking-wide">Analisis</span>
        </div>
        <div class="w-16 h-px bg-[#8B3A3A]/30 mx-3"></div>
        <div class="flex items-center gap-2">
            <div class="flex items-center justify-center w-9 h-9 rounded-full bg-[#8B3A3A] text-white text-sm font-bold shadow-md shadow-[#8B3A3A]/30 ring-4 ring-[#8B3A3A]/10">3</div>
            <span class="text-sm font-semibold text-[#8B3A3A] uppercase tracking-wide">Hasil</span>
        </div>
    </div>
@endif

{{-- ═══ TINGKAT RISIKO CARD ════════════════════════════════════════════ --}}
@php
    $skor     = $hasil['skor_kesehatan'];
    $label    = $hasil['kondisi_label'];
    $cfFinal  = $hasil['cf_final'];
    $cfPct    = round($cfFinal * 100, 1);
    $histId   = $history_id ?? null;

    // Gradient warna berdasarkan tingkat risiko (cfPct) — semakin tinggi semakin parah
    $skorGradient = match(true) {
        $cfPct >= 80 => ['from-red-400','to-red-600','text-red-700','bg-red-50','border-red-200'],
        $cfPct >= 60 => ['from-orange-400','to-orange-600','text-orange-700','bg-orange-50','border-orange-200'],
        $cfPct >= 40 => ['from-amber-400','to-amber-600','text-amber-700','bg-amber-50','border-amber-200'],
        $cfPct >= 20 => ['from-lime-400','to-lime-600','text-lime-700','bg-lime-50','border-lime-200'],
        default      => ['from-green-400','to-green-600','text-green-700','bg-green-50','border-green-200'],
    };
@endphp

<div class="bg-white rounded-[28px] border border-[#E1E3DE]/70 shadow-sm p-8 mb-6">
    <div class="flex flex-col md:flex-row items-center gap-8">

        {{-- Circular Score --}}
        <div class="relative shrink-0">
            <svg class="w-36 h-36 -rotate-90" viewBox="0 0 120 120">
                <circle cx="60" cy="60" r="52" fill="none" stroke="#F0EDEA" stroke-width="10"/>
                <circle cx="60" cy="60" r="52" fill="none"
                    stroke="url(#scoreGrad)" stroke-width="10"
                    stroke-linecap="round"
                    stroke-dasharray="{{ round(2 * 3.14159 * 52) }}"
                    stroke-dashoffset="{{ round(2 * 3.14159 * 52 * (1 - $cfPct / 100)) }}"
                    class="transition-all duration-1000"/>
                <defs>
                    <linearGradient id="scoreGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#8B3A3A"/>
                        <stop offset="100%" stop-color="#EBDBDD"/>
                    </linearGradient>
                </defs>
            </svg>
            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="text-3xl font-black text-gray-800">{{ $cfPct }}%</span>
                <span class="text-[10px] font-bold text-[#A8ABA7] tracking-widest uppercase">Risiko</span>
            </div>
        </div>

        {{-- Score Detail --}}
        <div class="flex-1 text-center md:text-left">
            <span class="inline-block {{ $skorGradient[2] }} {{ $skorGradient[3] }} border {{ $skorGradient[4] }} text-xs font-bold px-3 py-1 rounded-full mb-3">
                {{ $label }}
            </span>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Tingkat Risiko Kulit Bermasalah</h1>
            <p class="text-[#797B78] text-sm mb-5 max-w-md">
                Berdasarkan analisis AI visual dan kuesioner gaya hidup Anda. Nilai CF akhir:
                <strong class="text-[#8B3A3A]">{{ round($cfFinal * 100, 1) }}%</strong> risiko kulit bermasalah.
            </p>

            {{-- Progress Bar --}}
            <div class="w-full bg-[#F0EDEA] rounded-full h-3 overflow-hidden">
                <div class="h-full bg-gradient-to-r {{ $skorGradient[0] }} {{ $skorGradient[1] }} rounded-full transition-all duration-1000 ease-out"
                     style="width: {{ $cfPct }}%"></div>
            </div>
            <div class="flex justify-between mt-1.5">
                <span class="text-[10px] text-[#A8ABA7]">Risiko Rendah</span>
                <span class="text-[10px] text-[#A8ABA7]">Risiko Tinggi</span>
            </div>
        </div>

        {{-- Quick Stats --}}
        <div class="grid grid-cols-2 gap-3 shrink-0">
            <div class="bg-[#FAF9F6] rounded-2xl p-4 text-center border border-[#E1E3DE]/50">
                <span class="text-2xl font-black text-[#8B3A3A]">{{ $hasil['total_objek_terdeteksi'] ?? 0 }}</span>
                <p class="text-[10px] text-[#A8ABA7] mt-1 font-medium uppercase tracking-wide">Objek<br>Terdeteksi</p>
            </div>
            <div class="bg-[#FAF9F6] rounded-2xl p-4 text-center border border-[#E1E3DE]/50">
                <span class="text-2xl font-black text-[#8B3A3A]">{{ $hasil['jenis_objek_unik'] ?? count($hasil['temuan_klinis'] ?? []) }}</span>
                <p class="text-[10px] text-[#A8ABA7] mt-1 font-medium uppercase tracking-wide">Jenis<br>Kondisi</p>
            </div>
        </div>
    </div>
</div>

{{-- ═══ BODY: 2 KOLOM ═════════════════════════════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    {{-- KIRI: Temuan Klinis AI --}}
    <div class="bg-white rounded-[24px] border border-[#E1E3DE]/70 shadow-sm">
        <div class="px-6 pt-6 pb-4 border-b border-[#E1E3DE]/50 flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-[#EBDBDD] flex items-center justify-center">
                <svg class="w-4 h-4 text-[#8B3A3A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
            <h2 class="text-base font-bold text-gray-800">Temuan Klinis AI</h2>
            @if($hasil['roboflow_success'] ?? true)
                <span class="ml-auto flex items-center gap-1 text-[10px] font-bold text-green-600 bg-green-50 border border-green-200 px-2 py-0.5 rounded-full">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> AI Aktif
                </span>
            @endif
        </div>
        <div class="p-6">
            @php
                $temuanKlinis = $hasil['temuan_klinis'] ?? [];
                $keparahanColor = [
                    'Ringan' => ['bg'=>'bg-green-50','text'=>'text-green-700','border'=>'border-green-200','bar'=>'bg-green-500'],
                    'Sedang' => ['bg'=>'bg-amber-50','text'=>'text-amber-700','border'=>'border-amber-200','bar'=>'bg-amber-500'],
                    'Parah'  => ['bg'=>'bg-red-50','text'=>'text-red-700','border'=>'border-red-200','bar'=>'bg-red-500'],
                ];
            @endphp

            {{-- LANGKAH 2: Foto wajah dengan Bounding Box Overlay --}}
            @if(!empty($hasil['preview_base64']))
            <div class="mb-5">
                {{-- Container RELATIVE sebagai anchor untuk elemen absolut bbox --}}
                <div class="relative inline-block w-full rounded-2xl overflow-hidden border-2 border-dashed border-[#D5C5C5] bg-[#FAF9F6]"
                     id="bbox-container">
                    <img id="face-img"
                         src="{{ $hasil['preview_base64'] }}"
                         alt="Foto wajah"
                         class="w-full h-auto block"
                         {{-- Simpan dimensi asli sebagai data attribute untuk kalkulasi skala --}}
                         data-orig-width="{{ $hasil['img_width'] ?? 0 }}"
                         data-orig-height="{{ $hasil['img_height'] ?? 0 }}">

                    {{-- LANGKAH 2: Overlay absolut — kotak bbox akan di-inject JS ke sini --}}
                    <div id="bbox-overlay"
                         class="absolute top-0 left-0 w-full h-full pointer-events-none">
                    </div>

                    {{-- Corner scan marks --}}
                    <div class="absolute inset-0 pointer-events-none">
                        <div class="absolute top-0 left-0 w-5 h-5 border-t-2 border-l-2 border-[#8B3A3A] rounded-tl"></div>
                        <div class="absolute top-0 right-0 w-5 h-5 border-t-2 border-r-2 border-[#8B3A3A] rounded-tr"></div>
                        <div class="absolute bottom-0 left-0 w-5 h-5 border-b-2 border-l-2 border-[#8B3A3A] rounded-bl"></div>
                        <div class="absolute bottom-0 right-0 w-5 h-5 border-b-2 border-r-2 border-[#8B3A3A] rounded-br"></div>
                    </div>
                </div>
                <p class="text-[10px] text-[#A8ABA7] text-center mt-1.5">Kotak menunjukkan area deteksi AI</p>
            </div>
            @endif
            {{-- END LANGKAH 2 --}}

            @if(count($temuanKlinis) > 0)
                <div class="space-y-3">
                    @foreach($temuanKlinis as $item)
                        @php $c = $keparahanColor[$item['tingkat_keparahan']] ?? $keparahanColor['Ringan']; @endphp
                        <div class="{{ $c['bg'] }} border {{ $c['border'] }} rounded-2xl p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-bold text-gray-800">{{ $item['nama_objek'] }}</span>
                                <span class="text-xs font-semibold {{ $c['text'] }} bg-white/70 px-2 py-0.5 rounded-full border {{ $c['border'] }}">
                                    {{ $item['tingkat_keparahan'] }}
                                </span>
                            </div>
                            <div class="flex items-center gap-4 text-xs text-[#797B78]">
                                <span>{{ $item['jumlah'] }} terdeteksi</span>
                            </div>
                            <div class="mt-2 h-1.5 bg-white/60 rounded-full overflow-hidden">
                                <div class="{{ $c['bar'] }} h-full rounded-full opacity-70"
                                     style="width: {{ round($item['avg_confidence'] * 100) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-10 gap-3 text-center">
                    <div class="w-14 h-14 rounded-full bg-green-50 border-2 border-green-200 flex items-center justify-center">
                        <svg class="w-7 h-7 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800">Tidak Ada Masalah Terdeteksi</p>
                        <p class="text-xs text-[#A8ABA7] mt-1">AI tidak menemukan jerawat atau komedo pada foto Anda.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

{{-- KANAN: Panel Anamnesis / Gejala (hanya tampil jika ada data) --}}
    @php
        $jawaban = $history->analysis_data['jawaban_anamnesis'] ?? [];
    @endphp
    @if(!empty($jawaban))
    <div class="bg-white rounded-[24px] border border-[#E1E3DE] shadow-sm overflow-hidden">
        <div class="px-6 pt-6 pb-4 border-b border-[#E1E3DE] flex items-center gap-3 bg-gray-50/50">
            <div class="w-10 h-10 rounded-xl bg-white border border-[#E1E3DE] flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-[#5D605C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-base font-bold text-[#5D605C] tracking-tight">Data Anamnesis Klinis</h2>
        </div>
        <div class="p-6">
            <p class="text-xs text-[#797B78] mb-3 leading-relaxed">Jawaban pertanyaan kuesioner gejala klinis yang dikumpulkan saat analisis.</p>
            <div class="space-y-2">
                @foreach($jawaban as $ruleId => $nilai)
                @php
                    $nilaiFmt = number_format((float)$nilai * 100, 0);
                    $barW     = min(100, (float)$nilai * 100);
                    $barColor = $barW >= 75 ? 'bg-red-400' : ($barW >= 50 ? 'bg-amber-400' : 'bg-green-400');
                @endphp
                <div class="flex items-center gap-3">
                    <span class="text-[10px] text-gray-400 w-16 shrink-0">ID {{ $ruleId }}</span>
                    <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full {{ $barColor }}" style="width: {{ $barW }}%"></div>
                    </div>
                    <span class="text-xs font-bold text-[#5D605C] w-10 text-right">{{ $nilaiFmt }}%</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif


</div>

{{-- ═══ NEW CODE: FASE 4 — CF BREAKDOWN AUDIT TRAIL ═══════════════════ --}}
@php
    $breakdown = $hasil['cf_breakdown'] ?? [];
    $cfVisualPct  = round(($breakdown['cf_visual']  ?? $breakdown['visual']  ?? 0) * 100, 1);
    $cfGejalaPct  = round(($breakdown['cf_gejala']  ?? $breakdown['gejala']  ?? 0) * 100, 1);
    $cfFinalPct   = round(($hasil['cf_final'] ?? 0) * 100, 1);
    $hasBreakdown = ! empty($breakdown);
@endphp

@if($hasBreakdown)
<div class="bg-white rounded-[24px] border border-[#E1E3DE]/70 shadow-sm mb-6 overflow-hidden">

    {{-- Header --}}
    <div class="px-6 pt-6 pb-4 border-b border-[#E1E3DE]/50 flex items-center gap-3">
        <div class="w-8 h-8 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0">
            <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
        </div>
        <div>
            <h2 class="text-base font-bold text-gray-800">Transparansi Sistem — CF Breakdown</h2>
            <p class="text-xs text-[#797B78] mt-0.5">Kontribusi tiap tahap terhadap skor risiko akhir.</p>
        </div>
        <span class="ml-auto text-[10px] font-bold text-indigo-600 bg-indigo-50 border border-indigo-200 px-2 py-0.5 rounded-full">Audit Trail</span>
    </div>

    <div class="p-6">

        {{-- Diagram batang per komponen --}}
        @php
            $stages = [
                ['label' => 'Pilar 1 — Deteksi Visual (AI)', 'key' => 'cf_visual',  'pct' => $cfVisualPct,  'color' => 'bg-blue-400',   'textColor' => 'text-blue-700',   'desc' => 'Hasil analisis foto oleh Roboflow'],
                ['label' => 'Pilar 2 — Anamnesis Klinis',   'key' => 'cf_gejala',  'pct' => $cfGejalaPct,  'color' => 'bg-violet-400', 'textColor' => 'text-violet-700', 'desc' => 'Jawaban pertanyaan gejala spesifik Anda'],
            ];
        @endphp

        <div class="space-y-4">
            @foreach($stages as $stage)
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <div>
                        <span class="text-xs font-semibold text-gray-700">{{ $stage['label'] }}</span>
                        <p class="text-[10px] text-[#A8ABA7]">{{ $stage['desc'] }}</p>
                    </div>
                    <span class="text-sm font-black {{ $stage['textColor'] }} shrink-0 ml-4 tabular-nums">
                        {{ $stage['pct'] }}%
                    </span>
                </div>
                <div class="h-2.5 w-full bg-[#F0EDEA] rounded-full overflow-hidden">
                    <div class="{{ $stage['color'] }} h-full rounded-full transition-all duration-700"
                         style="width: {{ min(100, $stage['pct']) }}%"></div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Hasil Akhir (CF Final) --}}
        <div class="mt-5 pt-5 border-t border-[#E1E3DE]/60">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <span class="text-sm font-bold text-gray-800">CF Final (Kombinasi 2-Pilar)</span>
                    <p class="text-[10px] text-[#A8ABA7]">Visual + Anamnesis → CF Hybrid akhir sistem</p>
                </div>
                <span class="text-lg font-black text-[#8B3A3A]">{{ $cfFinalPct }}%</span>
            </div>
            <div class="h-3 w-full bg-[#F0EDEA] rounded-full overflow-hidden">
                <div class="h-full rounded-full bg-gradient-to-r from-[#8B3A3A] to-[#EBDBDD] transition-all duration-1000"
                     style="width: {{ min(100, $cfFinalPct) }}%"></div>
            </div>
        </div>
    </div>
</div>
@endif
{{-- ═══ END NEW CODE: FASE 4 ═══════════════════════════════════════════ --}}

{{-- ═══ REKOMENDASI SKINCARE & TINDAKAN KLINIK ═════════════════════════ --}}
@php
    // Decode recommended_products & recommended_treatments dari kolom JSON $history
    // Model cast 'array' sudah aktif, tapi controller menyimpan via json_encode()
    // sehingga data bisa berupa string JSON (double-encoded) atau sudah array.
    $rawProducts   = ($history->recommended_products ?? null);
    $rawTreatments = ($history->recommended_treatments ?? null);

    // Graceful decode: jika sudah array, pakai langsung. Jika string, decode sekali lagi.
    $recProducts   = is_array($rawProducts)   ? $rawProducts   : json_decode($rawProducts ?? '[]', true);
    $recTreatments = is_array($rawTreatments) ? $rawTreatments : json_decode($rawTreatments ?? '[]', true);

    // Pastikan selalu array
    $recProducts   = is_array($recProducts)   ? $recProducts   : [];
    $recTreatments = is_array($recTreatments) ? $recTreatments : [];
@endphp

@if(count($recProducts) > 0 || count($recTreatments) > 0)
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    {{-- KIRI: Rekomendasi Skincare & Obat --}}
    @if(count($recProducts) > 0)
    <div class="bg-white rounded-[24px] border border-[#E1E3DE]/70 shadow-sm overflow-hidden">
        <div class="px-6 pt-6 pb-4 border-b border-[#E1E3DE]/50 flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-base font-bold text-gray-800">Rekomendasi Skincare & Obat</h2>
                <p class="text-xs text-[#797B78] mt-0.5">Produk yang disarankan berdasarkan diagnosa AI.</p>
            </div>
            <span class="ml-auto text-[10px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full">
                {{ count($recProducts) }} Produk
            </span>
        </div>
        <div class="p-6">
            <div class="space-y-3">
                        @foreach($recProducts as $idx => $product)
            <div class="group relative bg-[#FAF9F6] hover:bg-emerald-50/50 border border-[#E1E3DE]/70 hover:border-emerald-200 rounded-2xl p-4 transition-all duration-200">
                <div class="flex items-center gap-4">
                    
                    {{-- 1. Nomor Urut --}}
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold shrink-0 group-hover:bg-emerald-200 transition-colors">
                        {{ $idx + 1 }}
                    </div>

                    {{-- 2. Miniatur Gambar Produk (Dinamis + Fallback) --}}
                    <div class="w-12 h-12 shrink-0 overflow-hidden rounded-xl border border-gray-100 bg-white flex items-center justify-center shadow-sm">
                        @if(!empty($product['image_path']) && file_exists(public_path($product['image_path'])))
                            <img src="{{ asset($product['image_path']) }}" alt="{{ $product['nama_produk'] ?? 'Produk' }}" class="w-full h-full object-cover">
                        @else
                            {{-- Placeholder SVG jika gambar kosong, warna diselaraskan ke tema Emerald --}}
                            <div class="w-full h-full bg-emerald-50/60 flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- 3. Detail Teks Produk --}}
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-bold text-gray-800 mb-1 tracking-tight">{{ $product['nama_produk'] ?? '-' }}</h3>
                        
                        @if(!empty($product['kandungan']))
                        <div class="flex items-start gap-1.5">
                            <svg class="w-3.5 h-3.5 text-[#A8ABA7] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p class="text-xs text-[#797B78] leading-relaxed text-justify line-clamp-1 group-hover:line-clamp-none transition-all duration-300">
                                {{ $product['kandungan'] }}
                            </p>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
            @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- KANAN: Rekomendasi Basic Treatment --}}
    @if(count($recTreatments) > 0)
    <div class="bg-white rounded-[24px] border border-[#E1E3DE]/70 shadow-sm overflow-hidden">
        {{-- HEADER: Mengikuti Pola Produk (Menggunakan Warna Pink) --}}
        <div class="px-6 pt-6 pb-4 border-b border-[#E1E3DE]/50 flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-pink-50 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-base font-bold text-gray-800">Rekomendasi Basic Treatment</h2>
                <p class="text-xs text-[#797B78] mt-0.5">Prosedur klinis yang disarankan berdasarkan diagnosa AI.</p>
            </div>
            <span class="ml-auto text-[10px] font-bold text-pink-600 bg-pink-50 border border-pink-200 px-2 py-0.5 rounded-full">
                {{ count($recTreatments) }} Tindakan
            </span>
        </div>

        {{-- BODY CONTAINER --}}
        <div class="p-6">
            <div class="space-y-3">
                @foreach($recTreatments as $idx => $treatment)
                <div class="group relative bg-[#FAF9F6] hover:bg-pink-50/50 border border-[#E1E3DE]/70 hover:border-pink-200 rounded-2xl p-4 transition-all duration-200">
                    <div class="flex items-start gap-3.5">
                        
                        {{-- Nomor Urut (Pink Palette) --}}
                        <div class="w-8 h-8 rounded-xl bg-pink-100 text-pink-700 flex items-center justify-center text-xs font-bold shrink-0 group-hover:bg-pink-200 transition-colors">
                            {{ $idx + 1 }}
                        </div>

                        {{-- Konten Teks --}}
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-bold text-gray-800 mb-1">{{ $treatment['nama_treatment'] ?? '-' }}</h3>
                            
                            @if(!empty($treatment['deskripsi']))
                            <div class="flex items-start gap-1.5">
                                {{-- Ikon Clipboard Dokumen Medis --}}
                                <svg class="w-3.5 h-3.5 text-[#A8ABA7] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p class="text-xs text-[#797B78] leading-relaxed text-justify">{{ $treatment['deskripsi'] }}</p>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

</div>
@endif
{{-- ═══ END REKOMENDASI ════════════════════════════════════════════════ --}}

{{-- ═══ ACTION CARD ════════════════════════════════════════════════════ --}}
<div class="bg-white rounded-[24px] border border-[#E1E3DE]/70 shadow-sm p-6">

    <h2 class="text-base font-bold text-gray-800 mb-5">Langkah Selanjutnya</h2>

    <div class="flex flex-col sm:flex-row gap-3">

        {{-- PDF Download --}}
        @if($histId)
        <a href="{{ route('analisis.pdf', $histId) }}"
           class="flex items-center justify-center gap-2.5
                  border-2 border-[#8B3A3A] text-[#8B3A3A]
                  px-6 py-3 rounded-full text-sm font-semibold
                  hover:bg-[#8B3A3A] hover:text-white
                  transition-all duration-200 hover:-translate-y-0.5
                  active:scale-95 group">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Unduh Resume Medis (PDF)
        </a>
        @endif

        {{-- Analisis Ulang --}}
        <a href="{{ route('analisis.index') }}"
           class="flex items-center justify-center gap-2
                  text-[#797B78] text-sm font-medium
                  hover:text-gray-800 transition-colors px-4 py-3">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Analisis Ulang
        </a>
    </div>

    {{-- Medical Disclaimer --}}
    <div class="mt-6 pt-5 border-t border-[#E1E3DE]/50 flex items-start gap-2">
        <svg class="w-4 h-4 text-[#A8ABA7] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-xs text-gray-500 leading-relaxed">
            <strong>Medical Disclaimer:</strong>
            Sistem ini adalah alat bantu skrining kecerdasan buatan. Diagnosis akhir dan tindakan medis
            tetap memerlukan pemeriksaan langsung oleh dokter.
        </p>
    </div>
</div>

@endsection

@push('scripts')
{{-- LANGKAH 3: Script JavaScript untuk menggambar Bounding Boxes --}}
<script>
(function () {
    // ── Data dari PHP via json() ──────────────────────────────────────────
    // raw_predictions: array koordinat mentah Roboflow (center-point x,y,w,h)
    const rawPredictions = @json($hasil['raw_predictions'] ?? []);
    const origW          = {{ $hasil['img_width']  ?? 0 }};
    const origH          = {{ $hasil['img_height'] ?? 0 }};

    // ── Peta warna per kelas objek ─────────────────────────────────────────
    // Format: border CSS color + background rgba untuk label
    const CLASS_COLORS = {
        'jerawat'       : { border: '#f97316', bg: 'rgba(249,115,22,0.85)',  text: '#fff' },  // orange
        'pustules'      : { border: '#f97316', bg: 'rgba(249,115,22,0.85)',  text: '#fff' },
        'pustule'       : { border: '#f97316', bg: 'rgba(249,115,22,0.85)',  text: '#fff' },
        'papules'       : { border: '#f97316', bg: 'rgba(249,115,22,0.85)',  text: '#fff' },
        'papule'        : { border: '#f97316', bg: 'rgba(249,115,22,0.85)',  text: '#fff' },
        'pimple'        : { border: '#f97316', bg: 'rgba(249,115,22,0.85)',  text: '#fff' },
        'pimples'       : { border: '#f97316', bg: 'rgba(249,115,22,0.85)',  text: '#fff' },
        'acne'          : { border: '#f97316', bg: 'rgba(249,115,22,0.85)',  text: '#fff' },
        'kista'         : { border: '#ef4444', bg: 'rgba(239,68,68,0.85)',   text: '#fff' },  // merah
        'nodules'       : { border: '#ef4444', bg: 'rgba(239,68,68,0.85)',   text: '#fff' },
        'nodule'        : { border: '#ef4444', bg: 'rgba(239,68,68,0.85)',   text: '#fff' },
        'cysts'         : { border: '#ef4444', bg: 'rgba(239,68,68,0.85)',   text: '#fff' },
        'cyst'          : { border: '#ef4444', bg: 'rgba(239,68,68,0.85)',   text: '#fff' },
        'komedo hitam'  : { border: '#1d4ed8', bg: 'rgba(29,78,216,0.85)',   text: '#fff' },  // biru
        'blackhead'     : { border: '#1d4ed8', bg: 'rgba(29,78,216,0.85)',   text: '#fff' },
        'blackheads'    : { border: '#1d4ed8', bg: 'rgba(29,78,216,0.85)',   text: '#fff' },
        'komedo putih'  : { border: '#7c3aed', bg: 'rgba(124,58,237,0.85)',  text: '#fff' },  // ungu
        'whitehead'     : { border: '#7c3aed', bg: 'rgba(124,58,237,0.85)',  text: '#fff' },
        'whiteheads'    : { border: '#7c3aed', bg: 'rgba(124,58,237,0.85)',  text: '#fff' },
        'comedone'      : { border: '#7c3aed', bg: 'rgba(124,58,237,0.85)',  text: '#fff' },
        'comedones'     : { border: '#7c3aed', bg: 'rgba(124,58,237,0.85)',  text: '#fff' },
        'bekas jerawat' : { border: '#64748b', bg: 'rgba(100,116,139,0.85)', text: '#fff' },  // slate
        'dark_spot'     : { border: '#64748b', bg: 'rgba(100,116,139,0.85)', text: '#fff' },
        'dark_spots'    : { border: '#64748b', bg: 'rgba(100,116,139,0.85)', text: '#fff' },
        'scar'          : { border: '#64748b', bg: 'rgba(100,116,139,0.85)', text: '#fff' },
        'scars'         : { border: '#64748b', bg: 'rgba(100,116,139,0.85)', text: '#fff' },
    };
    const DEFAULT_COLOR = { border: '#8B3A3A', bg: 'rgba(139,58,58,0.85)', text: '#fff' };

    const img     = document.getElementById('face-img');
    const overlay = document.getElementById('bbox-overlay');

    // ── Guard: elemen tidak ada (riwayat lama tanpa foto) ────────────────
    if (!img || !overlay || !rawPredictions.length) return;

    /**
     * Menggambar ulang semua bounding box.
     * Dipanggil saat gambar selesai load DAN saat window resize.
     */
    function drawBoxes() {
        // Kosongkan overlay sebelum menggambar ulang
        overlay.innerHTML = '';

        // Ukuran gambar yang sebenarnya tampil di layar
        const dispW = img.clientWidth;
        const dispH = img.clientHeight;

        // Hitung skala rasio: layar / asli
        // Jika origW/origH tidak tersedia, gunakan skala 1 (koordinat = piksel absolut)
        const scaleX = origW > 0 ? dispW / origW : 1;
        const scaleY = origH > 0 ? dispH / origH : scaleX; // fallback ke scaleX jika aspek tidak diketahui

        // ── Mapping terjemahan label kelas ke Bahasa Indonesia ─────
        const classTranslation = {
            'pustules'    : 'Jerawat Pustula',
            'pustule'     : 'Jerawat Pustula',
            'papules'     : 'Jerawat Papula',
            'papule'      : 'Jerawat Papula',
            'pimple'      : 'Jerawat',
            'pimples'     : 'Jerawat',
            'acne'        : 'Jerawat',
            'nodules'     : 'Kista/Nodul',
            'nodule'      : 'Kista/Nodul',
            'cysts'       : 'Kista',
            'cyst'        : 'Kista',
            'blackheads'  : 'Komedo Hitam',
            'blackhead'   : 'Komedo Hitam',
            'whiteheads'  : 'Komedo Putih',
            'whitehead'   : 'Komedo Putih',
            'comedone'    : 'Komedo',
            'comedones'   : 'Komedo',
            'dark_spot'   : 'Bekas Jerawat',
            'dark_spots'  : 'Bekas Jerawat',
            'scar'        : 'Bekas Luka',
            'scars'       : 'Bekas Luka',
        };

        rawPredictions.forEach(pred => {
            const classKey = (pred.class || '').toLowerCase();
            const color    = CLASS_COLORS[classKey] || DEFAULT_COLOR;
            const conf     = Math.round((pred.confidence ?? 0) * 100);

            // Terjemahkan label kelas ke Bahasa Indonesia
            const labelName = classTranslation[classKey] || pred.class || 'Unknown';

            // PENTING (Karakteristik Roboflow):
            // x, y adalah CENTER POINT — konversi ke top-left corner
            const left   = ((pred.x - pred.width  / 2) * scaleX);
            const top    = ((pred.y - pred.height / 2) * scaleY);
            const width  = (pred.width  * scaleX);
            const height = (pred.height * scaleY);

            // ── Buat elemen kotak bbox ───────────────────────────────
            const box = document.createElement('div');
            box.style.cssText = [
                `position: absolute`,
                `left: ${left}px`,
                `top: ${top}px`,
                `width: ${width}px`,
                `height: ${height}px`,
                `border: 2px solid ${color.border}`,
                `border-radius: 4px`,
                `box-sizing: border-box`,
            ].join(';');

            // ── Label nama kelas (Bahasa Indonesia) + confidence ─────
            const label = document.createElement('div');
            const labelText = labelName + ' ' + conf + '%';
            label.textContent = labelText;
            label.style.cssText = [
                `position: absolute`,
                `top: -20px`,
                `left: -2px`,
                `background: ${color.bg}`,
                `color: ${color.text}`,
                `font-size: 10px`,
                `font-weight: 700`,
                `padding: 1px 5px`,
                `border-radius: 3px 3px 3px 0`,
                `white-space: nowrap`,
                `line-height: 16px`,
                `letter-spacing: 0.02em`,
                `pointer-events: none`,
            ].join(';');

            box.appendChild(label);
            overlay.appendChild(box);
        });
    }

    // ── Jalankan setelah gambar benar-benar ter-render ──────────────────
    if (img.complete && img.naturalWidth > 0) {
        drawBoxes();
    } else {
        img.addEventListener('load', drawBoxes);
    }

    // ── Handler Window Resize: gambar ulang agar bbox tetap akurat ──────
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(drawBoxes, 120); // debounce 120ms
    });
})();
</script>
@endpush
