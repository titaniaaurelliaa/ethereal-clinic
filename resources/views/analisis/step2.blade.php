@extends('layouts_pasien.app')
@section('title', 'Analisis Kulit — Kuesioner Gaya Hidup')

@php
$lifestyleOptions = [
    'Tidur' => [
        'icon' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/></svg>',
        'label' => 'Durasi Tidur Malam',
        'hint'  => 'Berapa lama Anda tidur rata-rata setiap malam?',
        'choices' => [
            'Low'      => 'Kurang dari 6 jam',
            'Moderate' => '6 – 8 jam (cukup)',
            'High'     => 'Lebih dari 8 jam',
        ],
    ],
    'Stres' => [
        'icon' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>',
        'label' => 'Tingkat Stres Harian',
        'hint'  => 'Seberapa sering Anda merasa tertekan atau cemas?',
        'choices' => [
            'Low'      => 'Jarang stres',
            'Moderate' => 'Kadang-kadang stres',
            'High'     => 'Sering merasa tertekan',
        ],
    ],
    'Air' => [
        'icon' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2.25c0 0-6.75 8.25-6.75 12.75a6.75 6.75 0 0013.5 0C18.75 10.5 12 2.25 12 2.25z"/></svg>',
        'label' => 'Konsumsi Air Putih',
        'hint'  => 'Berapa gelas air putih yang Anda minum per hari?',
        'choices' => [
            'Low'      => 'Kurang dari 4 gelas',
            'Moderate' => '4 – 7 gelas',
            'High'     => '8 gelas atau lebih',
        ],
    ],
    'Diet' => [
        'icon' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 9.75l-3-3m0 0l-3 3m3-3v11.25m0 0H6m6 0h6"/></svg>',
        'label' => 'Pola Makan',
        'hint'  => 'Seberapa sering Anda mengonsumsi makanan pemicu (gorengan, susu, gula)?',
        'choices' => [
            'Low'      => 'Jarang (makanan sehat)',
            'Moderate' => 'Kadang-kadang',
            'High'     => 'Sering (gorengan/manis/susu)',
        ],
    ],
    'Sinar Matahari' => [
        'icon' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></svg>',
        'label' => 'Paparan Sinar UV',
        'hint'  => 'Seberapa sering Anda terpapar matahari tanpa perlindungan tabir surya?',
        'choices' => [
            'Low'      => 'Selalu pakai sunscreen',
            'Moderate' => 'Sesekali tanpa pelindung',
            'High'     => 'Sering terpapar langsung',
        ],
    ],
];

$keparahanColor = [
    'Ringan' => ['bg' => 'bg-green-50',  'text' => 'text-green-700',  'border' => 'border-green-200',  'dot' => 'bg-green-500'],
    'Sedang' => ['bg' => 'bg-amber-50',  'text' => 'text-amber-700',  'border' => 'border-amber-200',  'dot' => 'bg-amber-500'],
    'Parah'  => ['bg' => 'bg-red-50',    'text' => 'text-red-700',    'border' => 'border-red-200',    'dot' => 'bg-red-500'],
];
@endphp

@section('content')

{{-- ═══ STEPPER ═══════════════════════════════════════════════════════ --}}
<div class="flex items-center justify-center gap-0 mb-10">
    {{-- Step 1: Done --}}
    <div class="flex items-center gap-2">
        <div class="flex items-center justify-center w-9 h-9 rounded-full bg-[#7B5556]/15 text-[#7B5556] text-sm font-bold">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        </div>
        <span class="text-sm font-medium text-[#7B5556]/60 tracking-wide uppercase">Unggah</span>
    </div>
    <div class="w-16 h-px bg-[#7B5556]/30 mx-3"></div>
    {{-- Step 2: Active --}}
    <div class="flex items-center gap-2">
        <div class="flex items-center justify-center w-9 h-9 rounded-full bg-[#7B5556] text-white text-sm font-bold shadow-sm ring-4 ring-[#7B5556]/10">2</div>
        <span class="text-sm font-semibold text-[#7B5556] tracking-wide uppercase">Analisis</span>
    </div>
    <div class="w-16 h-px bg-[#E1E3DE] mx-3"></div>
    {{-- Step 3: Inactive --}}
    <div class="flex items-center gap-2">
        <div class="flex items-center justify-center w-9 h-9 rounded-full bg-[#E1E3DE] text-[#A8ABA7] text-sm font-bold">3</div>
        <span class="text-sm font-medium text-[#A8ABA7] tracking-wide uppercase">Hasil</span>
    </div>
</div>

{{-- ═══ PAGE HEADER ═══════════════════════════════════════════════════ --}}
<header class="mb-8">
    <span class="inline-block bg-[#EBDBDD] text-[#7B5556] text-[10px] font-bold tracking-widest uppercase px-3 py-1 rounded-md mb-3">Langkah 2 dari 3</span>
    <h1 class="text-2xl md:text-3xl font-bold text-[#5D605C] tracking-tight">Hasil Deteksi & Kuesioner Klinis</h1>
    <p class="text-[#797B78] mt-2 text-sm max-w-xl leading-relaxed">AI telah memindai wajah Anda. Lengkapi pertanyaan klinis di bawah untuk mendapatkan diagnosis yang komprehensif.</p>
</header>

{{-- ═══ TOP TWO-COLUMN: Foto + Scan Results ═══════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

    {{-- KIRI: Analisis Visual --}}
    <div class="bg-white rounded-2xl border border-[#E1E3DE] overflow-hidden">
        <div class="px-6 pt-5 pb-4 border-b border-[#E1E3DE] flex items-center gap-2.5">
            <span class="w-7 h-7 rounded-lg bg-[#EBDBDD] flex items-center justify-center">
                <svg class="w-4 h-4 text-[#7B5556]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </span>
            <h2 class="text-sm font-bold text-[#5D605C] uppercase tracking-wide">Analisis Visual</h2>
        </div>
        <div class="p-6">
            {{-- Foto Preview --}}
            <div class="relative w-full aspect-square max-w-[300px] mx-auto rounded-2xl overflow-hidden bg-[#FAF9F6] border-2 border-dashed border-[#E1E3DE] mb-5">
                @if(!empty($preview_base64))
                    <img src="{{ $preview_base64 }}" alt="Foto wajah" class="w-full h-full object-cover">
                    <div class="absolute inset-0 pointer-events-none">
                        <div class="absolute top-0 left-0 w-6 h-6 border-t-2 border-l-2 border-[#7B5556] rounded-tl-lg"></div>
                        <div class="absolute top-0 right-0 w-6 h-6 border-t-2 border-r-2 border-[#7B5556] rounded-tr-lg"></div>
                        <div class="absolute bottom-0 left-0 w-6 h-6 border-b-2 border-l-2 border-[#7B5556] rounded-bl-lg"></div>
                        <div class="absolute bottom-0 right-0 w-6 h-6 border-b-2 border-r-2 border-[#7B5556] rounded-br-lg"></div>
                    </div>
                @else
                    <div class="absolute inset-0 flex flex-col items-center justify-center gap-3">
                        <div class="w-16 h-16 rounded-full bg-[#EBDBDD]/60 flex items-center justify-center">
                            <svg class="w-8 h-8 text-[#7B5556]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>
                        </div>
                        <p class="text-xs text-[#A8ABA7] font-medium">Foto diproses</p>
                    </div>
                @endif
            </div>

            {{-- Badge Keyakinan AI --}}
            @if($roboflow_success && count($temuan) > 0)
                @php $avgCF = round(collect($temuan)->avg('avg_confidence') * 100); @endphp
                <div class="flex items-center justify-between bg-[#FAF9F6] border border-[#E1E3DE] rounded-xl px-4 py-3">
                    <div class="flex items-center gap-1.5">
                        <div class="w-2 h-2 rounded-full bg-[#3A5F43]"></div>
                        <span class="text-xs font-semibold text-[#5D605C]">Tingkat Keyakinan AI</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="h-1.5 w-24 bg-[#E1E3DE] rounded-full overflow-hidden">
                            <div class="h-full bg-[#7B5556] rounded-full transition-all duration-700" style="width: {{ $avgCF }}%"></div>
                        </div>
                        <span class="text-sm font-bold text-[#7B5556]">{{ $avgCF }}%</span>
                    </div>
                </div>
            @elseif(!$roboflow_success)
                <div class="bg-amber-50 border border-amber-200 text-amber-700 rounded-xl px-4 py-3 text-sm flex items-start gap-2">
                    <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                    <span>{{ $error_message ?? 'Deteksi AI tidak tersedia. Analisis gaya hidup tetap akan diproses.' }}</span>
                </div>
            @endif
        </div>
    </div>

    {{-- KANAN: Initial Scan Results --}}
    <div class="bg-white rounded-2xl border border-[#E1E3DE]">
        <div class="px-6 pt-5 pb-4 border-b border-[#E1E3DE] flex items-center gap-2.5">
            <span class="w-7 h-7 rounded-lg bg-[#E1E3DE]/70 flex items-center justify-center">
                <svg class="w-4 h-4 text-[#5D605C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </span>
            <h2 class="text-sm font-bold text-[#5D605C] uppercase tracking-wide">Temuan Awal</h2>
        </div>
        <div class="p-6">
            @if($roboflow_success && count($temuan) > 0)
                <div class="flex flex-wrap gap-2 mb-5">
                    @foreach($temuan as $item)
                        @php $c = $keparahanColor[$item['tingkat_keparahan']] ?? $keparahanColor['Ringan']; @endphp
                        <span class="inline-flex items-center gap-1.5 {{ $c['bg'] }} {{ $c['text'] }} border {{ $c['border'] }} text-xs font-semibold px-3 py-1.5 rounded-md">
                            <span class="w-1.5 h-1.5 rounded-full {{ $c['dot'] }}"></span>
                            {{ $item['nama_objek'] }}
                        </span>
                    @endforeach
                </div>

                <div class="space-y-3">
                    @foreach($temuan as $item)
                        @php
                            $c    = $keparahanColor[$item['tingkat_keparahan']] ?? $keparahanColor['Ringan'];
                            $pct  = round($item['avg_confidence'] * 100);
                            $cfPct = round($item['cf_final'] * 100);
                        @endphp
                        <div class="flex items-center gap-4 p-4 {{ $c['bg'] }} border {{ $c['border'] }} rounded-xl">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-sm font-bold text-[#5D605C]">{{ $item['nama_objek'] }}</span>
                                    <span class="text-xs font-semibold {{ $c['text'] }} shrink-0 ml-2">{{ $item['tingkat_keparahan'] }}</span>
                                </div>
                                <div class="flex items-center gap-3 text-xs text-[#797B78]">
                                    <span>{{ $item['jumlah'] }} terdeteksi</span>
                                    <span class="text-[#E1E3DE]">|</span>
                                    <span>Keyakinan {{ $pct }}%</span>
                                    <span class="text-[#E1E3DE]">|</span>
                                    <span class="{{ $c['text'] }} font-semibold">CF {{ $cfPct }}%</span>
                                </div>
                                <div class="mt-2 h-1 w-full bg-white/60 rounded-full overflow-hidden">
                                    <div class="h-full {{ $c['dot'] }} rounded-full opacity-70" style="width: {{ $pct }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <p class="text-[11px] text-[#A8ABA7] mt-4 text-center">
                    {{ count($temuan) }} jenis kondisi · {{ array_sum(array_column($temuan, 'jumlah')) }} objek total terdeteksi
                </p>

            @elseif($roboflow_success && count($temuan) === 0)
                <div class="flex flex-col items-center justify-center py-10 text-center gap-3">
                    <div class="w-16 h-16 rounded-full bg-green-50 border-2 border-green-200 flex items-center justify-center">
                        <svg class="w-8 h-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-[#5D605C]">Tidak Ada Masalah Terdeteksi</p>
                        <p class="text-xs text-[#A8ABA7] mt-1">AI tidak mendeteksi jerawat atau komedo pada foto Anda.</p>
                    </div>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-10 text-center gap-3">
                    <div class="w-16 h-16 rounded-full bg-amber-50 border-2 border-amber-200 flex items-center justify-center">
                        <svg class="w-8 h-8 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                    </div>
                    <p class="text-sm text-[#797B78] max-w-xs">Deteksi visual tidak tersedia. Analisis akan dilanjutkan berdasarkan data gaya hidup Anda.</p>
                </div>
            @endif
        </div>
    </div>

</div>

{{-- ═══ FORM ══════════════════════════════════════════════════════════ --}}
<form action="{{ route('analisis.final') }}" method="POST" id="lifestyle-form">
    @csrf

    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl px-5 py-4 text-sm flex items-start gap-3">
            <svg class="w-5 h-5 mt-0.5 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
            <ul class="space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    {{-- ═══ SECTION 1: GEJALA KLINIS WAJAH (Anamnesis Kontekstual) ═════ --}}
    @if(isset($dynamicSymptoms) && $dynamicSymptoms->isNotEmpty())
    <div class="mb-10">
        {{-- Section Container --}}
        <div class="border border-[#E1E3DE] rounded-2xl overflow-hidden">
            {{-- Flat Section Header --}}
            <div class="bg-[#FAF9F6] px-6 py-4 border-b border-[#E1E3DE] flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-[#EBDBDD] flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-[#7B5556]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-[#5D605C]">Gejala Klinis Wajah</h2>
                        <p class="text-xs text-[#797B78] mt-0.5">Pertanyaan spesifik berdasarkan temuan visual AI.</p>
                    </div>
                </div>
                <span class="text-[10px] font-bold text-[#5D605C] bg-[#E1E3DE] px-2.5 py-1 rounded-md uppercase tracking-wider">Anamnesis</span>
            </div>

            {{-- Symptom Cards --}}
            <div class="p-5 space-y-4 bg-white">
                @foreach($dynamicSymptoms as $index => $symptom)
                <div class="bg-white rounded-2xl border border-[#E1E3DE] p-5 hover:border-[#7B5556]/40 transition-colors duration-200 symptom-card" data-symptom-id="{{ $symptom->id }}">
                    {{-- Card Top: Question + Status Pill --}}
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex items-start gap-3 flex-1 min-w-0">
                            <div class="w-7 h-7 rounded-lg bg-[#EBDBDD] flex items-center justify-center text-[#7B5556] text-xs font-bold shrink-0 mt-0.5">
                                {{ $index + 1 }}
                            </div>
                            <p class="text-sm font-medium text-[#5D605C] leading-relaxed">
                                {{ $symptom->pertanyaan }}
                            </p>
                        </div>
                        {{-- Status Pill --}}
                        <span id="symptom_status_{{ $symptom->id }}" class="shrink-0 text-xs font-bold px-2.5 py-1 rounded-md bg-gray-100 text-[#A8ABA7]">
                            Belum Diisi
                        </span>
                    </div>

                    {{-- Segmented Chips: 5 options for slider values --}}
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-2 pl-10">
                        @php
                            $symptomChoices = [
                                ['value' => '0',    'label' => 'Tidak'],
                                ['value' => '0.25', 'label' => 'Sedikit Yakin'],
                                ['value' => '0.5',  'label' => 'Cukup Yakin'],
                                ['value' => '0.75', 'label' => 'Yakin'],
                                ['value' => '1',    'label' => 'Sangat Yakin'],
                            ];
                        @endphp
                        @foreach($symptomChoices as $choice)
                        <label class="cursor-pointer">
                            <input type="radio"
                                   name="symptom_answers[{{ $symptom->id }}]"
                                   value="{{ $choice['value'] }}"
                                   class="peer sr-only symptom-radio"
                                   data-symptom-id="{{ $symptom->id }}"
                                   {{ $choice['value'] === '0' ? 'checked' : '' }}>
                            <div class="flex items-center justify-center px-3 py-2.5 rounded-xl border border-[#E1E3DE] bg-gray-50 text-[#5D605C]
                                        text-xs font-semibold text-center
                                        peer-checked:bg-[#7B5556] peer-checked:text-white peer-checked:border-[#7B5556]
                                        hover:border-[#7B5556]/40 transition-colors duration-150">
                                {{ $choice['label'] }}
                            </div>
                        </label>
                        @endforeach
                    </div>

                    {{-- CF Pakar info --}}
                    <p class="text-[10px] text-[#A8ABA7] pl-10 mt-2.5">
                        Bobot pakar: {{ number_format($symptom->cf_gejala, 1) }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- ═══ SECTION 2: POLA GAYA HIDUP (Lifestyle) ════════════════════ --}}
    <div class="mb-10">
        {{-- Section Container --}}
        <div class="border border-[#E1E3DE] rounded-2xl overflow-hidden">
            {{-- Flat Section Header --}}
            <div class="bg-[#FAF9F6] px-6 py-4 border-b border-[#E1E3DE] flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-[#E1E3DE]/70 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-[#5D605C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-[#5D605C]">Pola Gaya Hidup</h2>
                        <p class="text-xs text-[#797B78] mt-0.5">Jawab seluruh pertanyaan untuk hasil analisis yang lebih akurat.</p>
                    </div>
                </div>
                <span id="answered-count" class="text-xs font-bold text-[#7B5556] bg-[#EBDBDD] px-2.5 py-1 rounded-md">0 / {{ count($lifestyleOptions) }}</span>
            </div>

            {{-- Progress bar --}}
            <div class="h-1 w-full bg-[#E1E3DE] overflow-hidden">
                <div id="progress-bar" class="h-full bg-[#7B5556] transition-all duration-500" style="width: 0%"></div>
            </div>

            {{-- Lifestyle Question Cards --}}
            <div class="p-5 space-y-4 bg-white">
                @foreach($lifestyleOptions as $kategori => $opt)
                <div class="bg-white rounded-2xl border border-[#E1E3DE] p-5 hover:border-[#7B5556]/40 transition-colors duration-200 lifestyle-card" data-kategori="{{ $kategori }}">
                    {{-- Card Top: Question + Status Pill --}}
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex items-start gap-3 flex-1 min-w-0">
                            <div class="w-9 h-9 rounded-xl bg-[#FAF9F6] border border-[#E1E3DE] flex items-center justify-center text-[#7B5556] shrink-0">
                                {!! $opt['icon'] !!}
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-[#5D605C]">{{ $opt['label'] }}</h3>
                                <p class="text-xs text-[#797B78] mt-0.5">{{ $opt['hint'] }}</p>
                            </div>
                        </div>
                        {{-- Status Pill --}}
                        <span class="lifestyle-status shrink-0 text-xs font-bold px-2.5 py-1 rounded-md bg-gray-100 text-[#A8ABA7]" data-kategori="{{ $kategori }}">
                            Belum Diisi
                        </span>
                    </div>

                    {{-- Segmented Chips --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 pl-12">
                        @foreach($opt['choices'] as $value => $choiceLabel)
                        @php
                            $levelText = ['Low' => 'Rendah', 'Moderate' => 'Sedang', 'High' => 'Tinggi'][$value] ?? $value;
                        @endphp
                        <label class="cursor-pointer">
                            <input type="radio"
                                   name="lifestyle[{{ $kategori }}]"
                                   value="{{ $value }}"
                                   class="peer sr-only lifestyle-radio"
                                   data-kategori="{{ $kategori }}"
                                   required>
                            <div class="flex flex-col gap-1.5 p-4 rounded-xl border border-[#E1E3DE] bg-gray-50
                                        peer-checked:bg-[#7B5556] peer-checked:border-[#7B5556] peer-checked:text-white
                                        hover:border-[#7B5556]/40 transition-colors duration-150 group">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-bold tracking-wider uppercase text-[#A8ABA7] peer-checked:group-[]:text-white/70">{{ $levelText }}</span>
                                    {{-- Check icon --}}
                                    <div class="w-4 h-4 rounded-full border-2 border-[#E1E3DE] flex items-center justify-center
                                                peer-checked:group-[]:border-white peer-checked:group-[]:bg-white transition-all check-circle">
                                        <svg class="w-2.5 h-2.5 text-[#7B5556] hidden check-icon" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-xs font-medium text-[#5D605C] leading-relaxed peer-checked:group-[]:text-white">{{ $choiceLabel }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ═══ SUBMIT BAR ════════════════════════════════════════════════ --}}
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-2 pb-4">
        <a href="{{ route('analisis.index') }}"
           class="flex items-center gap-2 text-sm font-medium text-[#797B78] hover:text-[#5D605C] transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg>
            Mulai Ulang
        </a>

        <button type="submit"
                id="btn-final-submit"
                class="w-full sm:w-auto flex items-center justify-center gap-2.5
                       bg-[#7B5556] text-white px-10 py-3.5 rounded-xl text-sm font-bold
                       shadow-sm hover:bg-[#6a494a] active:bg-[#5D3E3F]
                       transition-colors duration-150
                       disabled:opacity-40 disabled:cursor-not-allowed">
            <svg id="final-spinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
            </svg>
            <span id="final-text">Proses Diagnosis</span>
            <svg id="final-arrow" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
        </button>
    </div>

</form>

@endsection

@push('scripts')
<script>
(function () {
    const total       = {{ count($lifestyleOptions) }};
    const radios      = document.querySelectorAll('.lifestyle-radio');
    const countBadge  = document.getElementById('answered-count');
    const progressBar = document.getElementById('progress-bar');
    const form        = document.getElementById('lifestyle-form');
    const spinner     = document.getElementById('final-spinner');
    const btnText     = document.getElementById('final-text');
    const arrow       = document.getElementById('final-arrow');

    // ── Lifestyle progress tracking ─────────────────────────────────
    function updateProgress() {
        const answered = new Set(
            [...radios].filter(r => r.checked).map(r => r.dataset.kategori)
        ).size;
        const pct = Math.round((answered / total) * 100);
        countBadge.textContent  = `${answered} / ${total}`;
        progressBar.style.width = `${pct}%`;
    }

    // ── Lifestyle radio change handler ──────────────────────────────
    radios.forEach(radio => {
        radio.addEventListener('change', function () {
            const kat = this.dataset.kategori;

            // Reset all check icons in this category
            document.querySelectorAll(`.lifestyle-radio[data-kategori="${kat}"]`).forEach(r => {
                const label = r.closest('label');
                const checkIcon = label.querySelector('.check-icon');
                const checkCircle = label.querySelector('.check-circle');
                const levelSpan = label.querySelector('.text-\\[10px\\]');
                const descP = label.querySelector('p');

                if (checkIcon) checkIcon.classList.add('hidden');
                if (checkCircle) {
                    checkCircle.classList.remove('border-white', 'bg-white');
                    checkCircle.classList.add('border-[#E1E3DE]');
                }
                if (levelSpan) {
                    levelSpan.classList.remove('text-white/70');
                    levelSpan.classList.add('text-[#A8ABA7]');
                }
                if (descP) {
                    descP.classList.remove('text-white');
                    descP.classList.add('text-[#5D605C]');
                }
            });

            // Activate selected
            const selectedLabel = this.closest('label');
            const checkIcon = selectedLabel.querySelector('.check-icon');
            const checkCircle = selectedLabel.querySelector('.check-circle');
            const levelSpan = selectedLabel.querySelector('.text-\\[10px\\]');
            const descP = selectedLabel.querySelector('p');

            if (checkIcon) checkIcon.classList.remove('hidden');
            if (checkCircle) {
                checkCircle.classList.add('border-white', 'bg-white');
                checkCircle.classList.remove('border-[#E1E3DE]');
            }
            if (levelSpan) {
                levelSpan.classList.add('text-white/70');
                levelSpan.classList.remove('text-[#A8ABA7]');
            }
            if (descP) {
                descP.classList.add('text-white');
                descP.classList.remove('text-[#5D605C]');
            }

            // Update status pill for this category
            const statusPill = document.querySelector(`.lifestyle-status[data-kategori="${kat}"]`);
            if (statusPill) {
                statusPill.textContent = 'Selesai';
                statusPill.classList.remove('bg-gray-100', 'text-[#A8ABA7]');
                statusPill.classList.add('bg-[#3A5F43]', 'text-white');
            }

            updateProgress();
        });
    });

    // ── Symptom radio change handler ────────────────────────────────
    const symptomRadios = document.querySelectorAll('.symptom-radio');
    symptomRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            const sid = this.dataset.symptomId;
            const val = parseFloat(this.value);
            const statusPill = document.getElementById('symptom_status_' + sid);

            if (statusPill && val > 0) {
                statusPill.textContent = 'Selesai';
                statusPill.classList.remove('bg-gray-100', 'text-[#A8ABA7]');
                statusPill.classList.add('bg-[#3A5F43]', 'text-white');
            } else if (statusPill) {
                statusPill.textContent = 'Belum Diisi';
                statusPill.classList.add('bg-gray-100', 'text-[#A8ABA7]');
                statusPill.classList.remove('bg-[#3A5F43]', 'text-white');
            }
        });
    });

    // ── Submit handler ───────────────────────────────────────────────
    form.addEventListener('submit', function () {
        spinner.classList.remove('hidden');
        arrow.classList.add('hidden');
        btnText.textContent = 'Memproses...';
    });

    updateProgress();
})();
</script>
@endpush
