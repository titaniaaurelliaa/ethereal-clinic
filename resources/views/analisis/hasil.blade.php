@extends('layouts_pasien.app')
@section('title', 'Hasil Analisis Kulit')

@section('content')

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

{{-- ═══ SKOR KESEHATAN CARD ════════════════════════════════════════════ --}}
@php
    $skor     = $hasil['skor_kesehatan'];
    $label    = $hasil['kondisi_label'];
    $cfFinal  = $hasil['cf_final'];
    $histId   = $history_id ?? null;

    $skorGradient = match(true) {
        $skor >= 80 => ['from-green-400','to-green-600','text-green-700','bg-green-50','border-green-200'],
        $skor >= 60 => ['from-lime-400','to-lime-600','text-lime-700','bg-lime-50','border-lime-200'],
        $skor >= 40 => ['from-amber-400','to-amber-600','text-amber-700','bg-amber-50','border-amber-200'],
        $skor >= 20 => ['from-orange-400','to-orange-600','text-orange-700','bg-orange-50','border-orange-200'],
        default     => ['from-red-400','to-red-600','text-red-700','bg-red-50','border-red-200'],
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
                    stroke-dashoffset="{{ round(2 * 3.14159 * 52 * (1 - $skor / 100)) }}"
                    class="transition-all duration-1000"/>
                <defs>
                    <linearGradient id="scoreGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#8B3A3A"/>
                        <stop offset="100%" stop-color="#EBDBDD"/>
                    </linearGradient>
                </defs>
            </svg>
            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="text-3xl font-black text-gray-800">{{ $skor }}</span>
                <span class="text-[10px] font-bold text-[#A8ABA7] tracking-widest uppercase">/ 100</span>
            </div>
        </div>

        {{-- Score Detail --}}
        <div class="flex-1 text-center md:text-left">
            <span class="inline-block {{ $skorGradient[2] }} {{ $skorGradient[3] }} border {{ $skorGradient[4] }} text-xs font-bold px-3 py-1 rounded-full mb-3">
                {{ $label }}
            </span>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Skor Kesehatan Wajah</h1>
            <p class="text-[#797B78] text-sm mb-5 max-w-md">
                Berdasarkan analisis AI visual dan kuesioner gaya hidup Anda. Nilai CF akhir:
                <strong class="text-[#8B3A3A]">{{ round($cfFinal * 100, 1) }}%</strong> risiko kulit bermasalah.
            </p>

            {{-- Progress Bar --}}
            <div class="w-full bg-[#F0EDEA] rounded-full h-3 overflow-hidden">
                <div class="h-full bg-gradient-to-r {{ $skorGradient[0] }} {{ $skorGradient[1] }} rounded-full transition-all duration-1000 ease-out"
                     style="width: {{ $skor }}%"></div>
            </div>
            <div class="flex justify-between mt-1.5">
                <span class="text-[10px] text-[#A8ABA7]">Sangat Parah</span>
                <span class="text-[10px] text-[#A8ABA7]">Kulit Sehat</span>
            </div>
        </div>

        {{-- Quick Stats --}}
        <div class="grid grid-cols-2 gap-3 shrink-0">
            <div class="bg-[#FAF9F6] rounded-2xl p-4 text-center border border-[#E1E3DE]/50">
                <span class="text-2xl font-black text-[#8B3A3A]">{{ $hasil['total_objek_terdeteksi'] ?? 0 }}</span>
                <p class="text-[10px] text-[#A8ABA7] mt-1 font-medium uppercase tracking-wide">Objek<br>Terdeteksi</p>
            </div>
            <div class="bg-[#FAF9F6] rounded-2xl p-4 text-center border border-[#E1E3DE]/50">
                <span class="text-2xl font-black text-[#8B3A3A]">{{ count($hasil['lifestyle_berisiko'] ?? []) }}</span>
                <p class="text-[10px] text-[#A8ABA7] mt-1 font-medium uppercase tracking-wide">Faktor<br>Risiko</p>
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
                                <span>·</span>
                                <span>Keyakinan {{ round($item['avg_confidence'] * 100) }}%</span>
                                <span>·</span>
                                <span class="{{ $c['text'] }} font-semibold">CF {{ round($item['cf_final'] * 100) }}%</span>
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

    {{-- KANAN: Faktor Gaya Hidup --}}
    <div class="bg-white rounded-[24px] border border-[#E1E3DE]/70 shadow-sm">
        <div class="px-6 pt-6 pb-4 border-b border-[#E1E3DE]/50 flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-[#E1E3DE] flex items-center justify-center">
                <svg class="w-4 h-4 text-[#5D605C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h2 class="text-base font-bold text-gray-800">Faktor Gaya Hidup</h2>
        </div>
        <div class="p-6">
            @php
                $lifestyleDetail  = $hasil['lifestyle_detail']   ?? [];
                $lifestyleBerisiko = $hasil['lifestyle_berisiko'] ?? [];
                $lifestyleEmoji   = ['Tidur'=>'😴','Stres'=>'😰','Air'=>'💧','Diet'=>'🥗','Sinar Matahari'=>'☀️'];
            @endphp

            @if(count($lifestyleBerisiko) > 0)
                <p class="text-xs text-[#797B78] mb-4">Faktor berikut berkontribusi terhadap risiko kulit bermasalah:</p>
                <div class="space-y-3 mb-5">
                    @foreach($lifestyleBerisiko as $item)
                        @php $cf = round($item['cf_pakar'] * 100); @endphp
                        <div class="flex items-center gap-3 bg-[#FAF9F6] border border-[#E1E3DE]/70 rounded-2xl p-3.5">
                            <span class="text-xl shrink-0">{{ $lifestyleEmoji[$item['kategori']] ?? '📋' }}</span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800">{{ $item['kategori'] }}</p>
                                <p class="text-xs text-[#797B78] truncate">{{ $item['label'] }}</p>
                            </div>
                            <div class="shrink-0 text-right">
                                <span class="text-xs font-bold text-[#8B3A3A]">+{{ $cf }}%</span>
                                <p class="text-[10px] text-[#A8ABA7]">risiko</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Semua kategori --}}
            <p class="text-xs font-semibold text-[#797B78] mb-3 uppercase tracking-wide">Semua Kategori</p>
            <div class="space-y-2">
                @foreach($lifestyleDetail as $item)
                    @php
                        $cf = $item['cf_pakar'] * 100;
                        $isOk = $cf == 0;
                    @endphp
                    <div class="flex items-center gap-3">
                        <span class="text-base shrink-0">{{ $lifestyleEmoji[$item['kategori']] ?? '📋' }}</span>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs font-semibold text-gray-700">{{ $item['kategori'] }}</span>
                                <span class="text-[10px] font-bold {{ $isOk ? 'text-green-600' : 'text-[#8B3A3A]' }}">
                                    {{ $isOk ? '✓ Baik' : '+'.round($cf).'%' }}
                                </span>
                            </div>
                            <div class="h-1.5 bg-[#F0EDEA] rounded-full overflow-hidden">
                                <div class="h-full rounded-full {{ $isOk ? 'bg-green-400' : 'bg-[#8B3A3A]' }}"
                                     style="width: {{ min(100, $cf ?: 5) }}%"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

{{-- ═══ NEW CODE: FASE 4 — CF BREAKDOWN AUDIT TRAIL ═══════════════════ --}}
@php
    $breakdown = $hasil['cf_breakdown'] ?? [];
    $cfVisualPct    = round(($breakdown['cf_visual']    ?? 0) * 100, 1);
    $cfGejalaPct    = round(($breakdown['cf_gejala']    ?? 0) * 100, 1);
    $cfInterimPct   = round(($breakdown['cf_interim']   ?? 0) * 100, 1);
    $cfLifestylePct = round(($breakdown['cf_lifestyle'] ?? 0) * 100, 1);
    $cfFinalPct     = round(($hasil['cf_final'] ?? 0) * 100, 1);
    $hasBreakdown   = ! empty($breakdown);
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
                ['label' => 'Tahap 1 — Deteksi Visual (AI)', 'key' => 'cf_visual',    'pct' => $cfVisualPct,    'color' => 'bg-blue-400',   'textColor' => 'text-blue-700',   'desc' => 'Hasil analisis foto oleh Roboflow'],
                ['label' => 'Tahap 2 — Anamnesis Kontekstual','key' => 'cf_gejala',   'pct' => $cfGejalaPct,   'color' => 'bg-violet-400', 'textColor' => 'text-violet-700', 'desc' => 'Jawaban pertanyaan gejala spesifik Anda'],
                ['label' => 'Interim (Tahap 1 + 2)',          'key' => 'cf_interim',  'pct' => $cfInterimPct,  'color' => 'bg-purple-400', 'textColor' => 'text-purple-700', 'desc' => 'Kombinasi paralel visual + anamnesis'],
                ['label' => 'Tahap 3 — Faktor Gaya Hidup',   'key' => 'cf_lifestyle','pct' => $cfLifestylePct,'color' => 'bg-amber-400',  'textColor' => 'text-amber-700',  'desc' => 'Kontribusi kebiasaan harian Anda'],
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
                    <span class="text-sm font-bold text-gray-800">CF Final (Kombinasi Semua Tahap)</span>
                    <p class="text-[10px] text-[#A8ABA7]">Interim + Lifestyle → CF gabungan akhir sistem</p>
                </div>
                <span class="text-lg font-black text-[#8B3A3A]">{{ $cfFinalPct }}%</span>
            </div>
            <div class="h-3 w-full bg-[#F0EDEA] rounded-full overflow-hidden">
                <div class="h-full rounded-full bg-gradient-to-r from-[#8B3A3A] to-[#EBDBDD] transition-all duration-1000"
                     style="width: {{ min(100, $cfFinalPct) }}%"></div>
            </div>
            <p class="text-[10px] text-[#A8ABA7] mt-2 text-right">
                Rumus: CF<sub>combine</sub> = CF<sub>lama</sub> + CF<sub>baru</sub> × (1 − CF<sub>lama</sub>)
            </p>
        </div>
    </div>
</div>
@endif
{{-- ═══ END NEW CODE: FASE 4 ═══════════════════════════════════════════ --}}

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
            Unduh Rekam Medis (PDF)
        </a>
        @endif

        {{-- WhatsApp Konsultasi --}}
        @php
            $waText = urlencode(
                "Halo, saya baru saja melakukan skrining kulit AI di The Ethereal Clinic.\n\n" .
                "Hasil saya:\n" .
                "• Skor Kesehatan Wajah: {$skor}/100 ({$label})\n" .
                "• Total objek terdeteksi: " . ($hasil['total_objek_terdeteksi'] ?? 0) . "\n\n" .
                "Saya ingin berkonsultasi lebih lanjut dengan dokter. Terima kasih."
            );
        @endphp
        <a href="https://wa.me/6281234567890?text={{ $waText }}"
           target="_blank" rel="noopener"
           class="flex items-center justify-center gap-2.5
                  bg-[#25D366] text-white
                  px-6 py-3 rounded-full text-sm font-semibold
                  shadow-lg shadow-green-500/25
                  hover:bg-[#20ba59] hover:shadow-xl hover:-translate-y-0.5
                  transition-all duration-200 active:scale-95">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                <path d="M12 0C5.373 0 0 5.373 0 12c0 2.124.558 4.121 1.533 5.855L.057 23.43a.5.5 0 00.513.57l5.736-1.505A11.95 11.95 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75a9.726 9.726 0 01-4.952-1.35l-.355-.21-3.673.964.983-3.594-.232-.37A9.726 9.726 0 012.25 12C2.25 6.615 6.615 2.25 12 2.25S21.75 6.615 21.75 12 17.385 21.75 12 21.75z"/>
            </svg>
            Konsultasi dengan Dokter
        </a>

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

        rawPredictions.forEach(pred => {
            const classKey = (pred.class || '').toLowerCase();
            const color    = CLASS_COLORS[classKey] || DEFAULT_COLOR;
            const conf     = Math.round((pred.confidence ?? 0) * 100);

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

            // ── Label nama kelas + confidence ────────────────────────
            const label = document.createElement('div');
            const labelText = (pred.class || 'Unknown') + ' ' + conf + '%';
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
