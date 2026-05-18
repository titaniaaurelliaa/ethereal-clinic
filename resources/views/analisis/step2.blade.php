@extends('layouts_pasien.app')
@section('title', 'Analisis Kulit — Kuesioner Gaya Hidup')

@php
$lifestyleOptions = [
    'Tidur' => [
        'emoji' => '😴',
        'label' => 'Durasi Tidur Malam',
        'hint'  => 'Berapa lama Anda tidur rata-rata?',
        'choices' => [
            'Low'      => 'Kurang dari 6 jam',
            'Moderate' => '6 – 8 jam (cukup)',
            'High'     => 'Lebih dari 8 jam',
        ],
    ],
    'Stres' => [
        'emoji' => '😰',
        'label' => 'Tingkat Stres Harian',
        'hint'  => 'Seberapa sering Anda merasa tertekan?',
        'choices' => [
            'Low'      => 'Jarang stres',
            'Moderate' => 'Kadang-kadang stres',
            'High'     => 'Sering merasa tertekan',
        ],
    ],
    'Air' => [
        'emoji' => '💧',
        'label' => 'Konsumsi Air Putih',
        'hint'  => 'Berapa gelas air putih per hari?',
        'choices' => [
            'Low'      => 'Kurang dari 4 gelas',
            'Moderate' => '4 – 7 gelas',
            'High'     => '8 gelas atau lebih',
        ],
    ],
    'Diet' => [
        'emoji' => '🥗',
        'label' => 'Pola Makan',
        'hint'  => 'Seberapa sering konsumsi makanan pemicu?',
        'choices' => [
            'Low'      => 'Jarang (makanan sehat)',
            'Moderate' => 'Kadang-kadang',
            'High'     => 'Sering (gorengan/manis/susu)',
        ],
    ],
    'Sinar Matahari' => [
        'emoji' => '☀️',
        'label' => 'Paparan Sinar UV',
        'hint'  => 'Seberapa sering tanpa tabir surya?',
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

{{-- STEPPER --}}
<div class="flex items-center justify-center gap-0 mb-10">
    {{-- Step 1: Done --}}
    <div class="flex items-center gap-2">
        <div class="flex items-center justify-center w-9 h-9 rounded-full bg-[#8B3A3A]/20 text-[#8B3A3A] text-sm font-bold">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        </div>
        <span class="text-sm font-medium text-[#8B3A3A]/60 tracking-wide uppercase">Unggah</span>
    </div>
    <div class="w-16 h-px bg-[#8B3A3A]/30 mx-3"></div>
    {{-- Step 2: Aktif --}}
    <div class="flex items-center gap-2">
        <div class="flex items-center justify-center w-9 h-9 rounded-full bg-[#8B3A3A] text-white text-sm font-bold shadow-md shadow-[#8B3A3A]/30 ring-4 ring-[#8B3A3A]/10">2</div>
        <span class="text-sm font-semibold text-[#8B3A3A] tracking-wide uppercase">Analisis</span>
    </div>
    <div class="w-16 h-px bg-[#E1E3DE] mx-3"></div>
    {{-- Step 3: Inactive --}}
    <div class="flex items-center gap-2">
        <div class="flex items-center justify-center w-9 h-9 rounded-full bg-[#E1E3DE] text-[#A8ABA7] text-sm font-bold">3</div>
        <span class="text-sm font-medium text-[#A8ABA7] tracking-wide uppercase">Hasil</span>
    </div>
</div>

{{-- PAGE HEADER --}}
<header class="mb-8">
    <span class="inline-block bg-[#EBDBDD] text-[#8B3A3A] text-[10px] font-bold tracking-widest uppercase px-3 py-1 rounded-full mb-3">Langkah 2 dari 3</span>
    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 tracking-tight">Hasil Deteksi & Gaya Hidup</h1>
    <p class="text-[#797B78] mt-2 text-sm max-w-xl leading-relaxed">AI telah memindai wajah Anda. Lengkapi kuesioner gaya hidup di bawah untuk mendapatkan analisis yang komprehensif.</p>
</header>

{{-- TOP TWO-COLUMN: Foto + Scan Results --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

    {{-- KIRI: Analisis Visual --}}
    <div class="bg-white rounded-[24px] border border-[#E1E3DE]/70 shadow-sm overflow-hidden">
        <div class="px-6 pt-6 pb-4 border-b border-[#E1E3DE]/50">
            <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-[#EBDBDD] flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#8B3A3A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </span>
                Analisis Visual
            </h2>
        </div>
        <div class="p-6">
            {{-- Foto Preview --}}
            <div class="relative w-full aspect-square max-w-[300px] mx-auto rounded-2xl overflow-hidden bg-[#FAF9F6] border-2 border-dashed border-[#D5C5C5] mb-5">
                @if(!empty($preview_base64))
                    <img src="{{ $preview_base64 }}" alt="Foto wajah" class="w-full h-full object-cover">
                    {{-- Overlay scan lines --}}
                    <div class="absolute inset-0 pointer-events-none">
                        <div class="absolute top-0 left-0 w-6 h-6 border-t-2 border-l-2 border-[#8B3A3A] rounded-tl-lg"></div>
                        <div class="absolute top-0 right-0 w-6 h-6 border-t-2 border-r-2 border-[#8B3A3A] rounded-tr-lg"></div>
                        <div class="absolute bottom-0 left-0 w-6 h-6 border-b-2 border-l-2 border-[#8B3A3A] rounded-bl-lg"></div>
                        <div class="absolute bottom-0 right-0 w-6 h-6 border-b-2 border-r-2 border-[#8B3A3A] rounded-br-lg"></div>
                    </div>
                @else
                    <div class="absolute inset-0 flex flex-col items-center justify-center gap-3">
                        <div class="w-16 h-16 rounded-full bg-[#EBDBDD]/60 flex items-center justify-center">
                            <svg class="w-8 h-8 text-[#8B3A3A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
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
                <div class="flex items-center justify-center gap-2 bg-[#FAF9F6] border border-[#E1E3DE] rounded-2xl px-4 py-3">
                    <div class="flex items-center gap-1.5">
                        <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                        <span class="text-xs font-semibold text-[#5D605C]">Tingkat Keyakinan AI</span>
                    </div>
                    <div class="ml-auto flex items-center gap-2">
                        <div class="h-1.5 w-24 bg-[#E1E3DE] rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-[#8B3A3A] to-[#EBDBDD] rounded-full transition-all duration-700" style="width: {{ $avgCF }}%"></div>
                        </div>
                        <span class="text-sm font-bold text-[#8B3A3A]">{{ $avgCF }}%</span>
                    </div>
                </div>
            @elseif(!$roboflow_success)
                <div class="bg-amber-50 border border-amber-200 text-amber-700 rounded-2xl px-4 py-3 text-sm flex items-start gap-2">
                    <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                    <span>{{ $error_message ?? 'Deteksi AI tidak tersedia. Analisis gaya hidup tetap akan diproses.' }}</span>
                </div>
            @endif
        </div>
    </div>

    {{-- KANAN: Initial Scan Results --}}
    <div class="bg-white rounded-[24px] border border-[#E1E3DE]/70 shadow-sm">
        <div class="px-6 pt-6 pb-4 border-b border-[#E1E3DE]/50">
            <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-[#E1E3DE]/70 flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#5D605C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </span>
                Initial Scan Results
            </h2>
        </div>
        <div class="p-6">
            @if($roboflow_success && count($temuan) > 0)
                {{-- Summary badges --}}
                <div class="flex flex-wrap gap-2 mb-5">
                    @foreach($temuan as $item)
                        @php $c = $keparahanColor[$item['tingkat_keparahan']] ?? $keparahanColor['Ringan']; @endphp
                        <span class="inline-flex items-center gap-1.5 {{ $c['bg'] }} {{ $c['text'] }} border {{ $c['border'] }} text-xs font-semibold px-3 py-1.5 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full {{ $c['dot'] }}"></span>
                            {{ $item['nama_objek'] }}
                        </span>
                    @endforeach
                </div>

                {{-- Detail per temuan --}}
                <div class="space-y-3">
                    @foreach($temuan as $item)
                        @php
                            $c    = $keparahanColor[$item['tingkat_keparahan']] ?? $keparahanColor['Ringan'];
                            $pct  = round($item['avg_confidence'] * 100);
                            $cfPct = round($item['cf_final'] * 100);
                        @endphp
                        <div class="flex items-center gap-4 p-4 {{ $c['bg'] }} border {{ $c['border'] }} rounded-2xl">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-sm font-bold text-gray-800">{{ $item['nama_objek'] }}</span>
                                    <span class="text-xs font-semibold {{ $c['text'] }} shrink-0 ml-2">{{ $item['tingkat_keparahan'] }}</span>
                                </div>
                                <div class="flex items-center gap-3 text-xs text-[#797B78]">
                                    <span>{{ $item['jumlah'] }} terdeteksi</span>
                                    <span>·</span>
                                    <span>Keyakinan {{ $pct }}%</span>
                                    <span>·</span>
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
                        <p class="text-sm font-bold text-gray-800">Tidak Ada Masalah Terdeteksi</p>
                        <p class="text-xs text-[#A8ABA7] mt-1">AI tidak mendeteksi jerawat atau komedo pada foto Anda.</p>
                    </div>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-10 text-center gap-3">
                    <div class="w-16 h-16 rounded-full bg-amber-50 border-2 border-amber-200 flex items-center justify-center text-2xl">⚠️</div>
                    <p class="text-sm text-[#797B78] max-w-xs">Deteksi visual tidak tersedia. Analisis akan dilanjutkan berdasarkan data gaya hidup Anda.</p>
                </div>
            @endif
        </div>
    </div>

</div>

{{-- LIFESTYLE FORM --}}
<form action="{{ route('analisis.final') }}" method="POST" id="lifestyle-form">
    @csrf

    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-2xl px-5 py-4 text-sm flex items-start gap-3">
            <svg class="w-5 h-5 mt-0.5 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
            <ul class="space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════ --}}
    {{-- NEW CODE: SECTION ANAMNESIS KONTEKSTUAL (Gejala Dinamis)       --}}
    {{-- Hanya tampil jika AI mendeteksi kondisi dengan SymptomRule      --}}
    {{-- ═══════════════════════════════════════════════════════════════ --}}
    @if(isset($dynamicSymptoms) && $dynamicSymptoms->isNotEmpty())
    <div class="mb-8">
        {{-- Header Section --}}
        <div class="flex items-center gap-3 mb-5">
            <div class="w-8 h-8 rounded-xl bg-[#EBDBDD] flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-[#8B3A3A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Anamnesis Kontekstual</h2>
                <p class="text-sm text-[#797B78] mt-0.5">
                    Berdasarkan deteksi AI, kami memiliki beberapa pertanyaan spesifik untuk Anda.
                    Geser slider ke kanan jika jawaban Anda <strong>Ya / Benar</strong>.
                </p>
            </div>
        </div>

        {{-- Symptom Question Cards --}}
        <div class="space-y-4">
            @foreach($dynamicSymptoms as $index => $symptom)
            <div class="bg-white rounded-[20px] border border-[#E1E3DE]/70 shadow-sm p-6">
                <div class="flex items-start gap-3 mb-4">
                    {{-- Nomor pertanyaan --}}
                    <div class="w-7 h-7 rounded-full bg-[#EBDBDD] flex items-center justify-center text-[#8B3A3A] text-xs font-bold shrink-0 mt-0.5">
                        {{ $index + 1 }}
                    </div>
                    <p class="text-sm font-medium text-gray-800 leading-relaxed">
                        {{ $symptom->pertanyaan }}
                    </p>
                </div>

                {{-- Slider jawaban (CF User: 0.0 = Tidak, 1.0 = Ya/Sangat) --}}
                <div class="flex items-center gap-4 pl-10">
                    <span class="text-xs text-gray-400 w-8 shrink-0">Tidak</span>

                    <div class="flex-1 relative">
                        <input
                            type="range"
                            name="symptom_answers[{{ $symptom->id }}]"
                            id="symptom_slider_{{ $symptom->id }}"
                            min="0" max="1" step="0.25"
                            value="0"
                            class="w-full h-2 appearance-none rounded-full outline-none cursor-pointer symptom-slider"
                            data-symptom-id="{{ $symptom->id }}"
                            style="accent-color: #8B3A3A;"
                            oninput="updateSymptomLabel({{ $symptom->id }}, this.value)">

                        {{-- Tick labels --}}
                        <div class="flex justify-between text-[10px] text-gray-300 mt-1 px-0.5">
                            <span>0</span><span>0.25</span><span>0.50</span><span>0.75</span><span>1.0</span>
                        </div>
                    </div>

                    <span class="text-xs text-gray-400 w-8 shrink-0 text-right">Ya</span>

                    {{-- Badge nilai terpilih --}}
                    <span id="symptom_label_{{ $symptom->id }}"
                          class="text-xs font-bold px-2.5 py-1 rounded-full bg-gray-100 text-gray-500 w-16 text-center shrink-0 transition-colors duration-200">
                        Tidak
                    </span>
                </div>

                {{-- CF Pakar info (subtle) --}}
                <p class="text-[10px] text-gray-300 pl-10 mt-2">
                    Bobot pakar: {{ number_format($symptom->cf_gejala, 1) }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    {{-- END NEW CODE ═══════════════════════════════════════════════════ --}}

    {{-- Section Header --}}
    <div class="flex items-center gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Kuesioner Gaya Hidup</h2>
            <p class="text-sm text-[#797B78] mt-0.5">Jawab semua pertanyaan untuk hasil analisis yang lebih akurat.</p>
        </div>
        <div class="ml-auto shrink-0">
            <span id="answered-count" class="text-xs font-bold text-[#8B3A3A] bg-[#EBDBDD] px-3 py-1 rounded-full">0 / {{ count($lifestyleOptions) }} dijawab</span>
        </div>
    </div>

    {{-- Progress bar --}}
    <div class="h-1.5 w-full bg-[#E1E3DE] rounded-full mb-8 overflow-hidden">
        <div id="progress-bar" class="h-full bg-gradient-to-r from-[#8B3A3A] to-[#EBDBDD] rounded-full transition-all duration-500" style="width: 0%"></div>
    </div>

    {{-- Lifestyle Question Cards --}}
    <div class="space-y-6">
        @foreach($lifestyleOptions as $kategori => $opt)
        <div class="bg-white rounded-[20px] border border-[#E1E3DE]/70 shadow-sm p-6 lifestyle-card" data-kategori="{{ $kategori }}">
            <div class="flex items-start gap-4 mb-5">
                <div class="w-12 h-12 rounded-2xl bg-[#FAF9F6] border border-[#E1E3DE] flex items-center justify-center text-2xl shrink-0">
                    {{ $opt['emoji'] }}
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-800">{{ $opt['label'] }}</h3>
                    <p class="text-xs text-[#797B78] mt-0.5">{{ $opt['hint'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                @foreach($opt['choices'] as $value => $choiceLabel)
                <label class="relative cursor-pointer">
                    <input type="radio"
                           name="lifestyle[{{ $kategori }}]"
                           value="{{ $value }}"
                           class="peer sr-only lifestyle-radio"
                           data-kategori="{{ $kategori }}"
                           required>
                    <div class="flex flex-col gap-2 p-4 rounded-2xl border-2 border-[#E1E3DE] bg-[#FAF9F6]
                                transition-all duration-200
                                peer-checked:border-[#8B3A3A] peer-checked:bg-[#EBDBDD]/30 peer-checked:shadow-md
                                hover:border-[#8B3A3A]/40 hover:bg-[#FFF7F6]
                                group">
                        {{-- Choice indicator --}}
                        <div class="flex items-center justify-between">
                            @php
                                $levelEmoji = ['Low' => '🟢', 'Moderate' => '🟡', 'High' => '🔴'][$value] ?? '⚪';
                                $levelText  = ['Low' => 'Rendah', 'Moderate' => 'Sedang', 'High' => 'Tinggi'][$value] ?? $value;
                            @endphp
                            <span class="text-base">{{ $levelEmoji }}</span>
                            <span class="text-[10px] font-bold tracking-wider uppercase text-[#A8ABA7] peer-checked:text-[#8B3A3A] group-[.peer-checked_~_&]:text-[#8B3A3A]">{{ $levelText }}</span>
                            {{-- Check icon --}}
                            <div class="w-4 h-4 rounded-full border-2 border-[#D5C5C5] flex items-center justify-center
                                        peer-checked:border-[#8B3A3A] peer-checked:bg-[#8B3A3A] transition-all">
                                <svg class="w-2.5 h-2.5 text-white hidden" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs font-medium text-[#5D605C] leading-relaxed">{{ $choiceLabel }}</p>
                    </div>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    {{-- Submit --}}
    <div class="flex justify-between items-center mt-8">
        <a href="{{ route('analisis.index') }}"
           class="flex items-center gap-2 text-sm font-medium text-[#797B78] hover:text-gray-800 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg>
            Mulai Ulang
        </a>

        <button type="submit"
                id="btn-final-submit"
                class="flex items-center gap-2.5 bg-[#8B3A3A] text-white px-8 py-3 rounded-full text-sm font-semibold
                       shadow-lg shadow-[#8B3A3A]/25 transition-all duration-200
                       hover:bg-[#7a3131] hover:shadow-xl hover:-translate-y-0.5
                       active:scale-95 active:translate-y-0
                       disabled:opacity-40 disabled:cursor-not-allowed disabled:shadow-none">
            <svg id="final-spinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
            </svg>
            <span id="final-text">Lanjutkan Analisis</span>
            <svg id="final-arrow" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
        </button>
    </div>

</form>

@endsection

@push('scripts')
<script>
// ── NEW CODE: Feedback visual untuk slider anamnesis ─────────────────────────
function updateSymptomLabel(id, value) {
    const label = document.getElementById('symptom_label_' + id);
    if (!label) return;

    const v = parseFloat(value);
    const map = {
        0:    { text: 'Tidak',   cls: 'bg-gray-100 text-gray-500'   },
        0.25: { text: 'Sedikit', cls: 'bg-blue-100 text-blue-600'   },
        0.5:  { text: 'Kadang',  cls: 'bg-amber-100 text-amber-600' },
        0.75: { text: 'Sering',  cls: 'bg-orange-100 text-orange-600'},
        1:    { text: 'Ya',      cls: 'bg-[#EBDBDD] text-[#8B3A3A]' },
    };

    // Cari nilai terdekat
    const nearest = Object.keys(map).reduce((a, b) =>
        Math.abs(b - v) < Math.abs(a - v) ? b : a
    );

    const { text, cls } = map[nearest];
    label.textContent = text;
    label.className   = `text-xs font-bold px-2.5 py-1 rounded-full w-16 text-center shrink-0 transition-colors duration-200 ${cls}`;
}
// ── END NEW CODE ─────────────────────────────────────────────────────────────

(function () {
    const total       = {{ count($lifestyleOptions) }};
    const radios      = document.querySelectorAll('.lifestyle-radio');
    const countBadge  = document.getElementById('answered-count');
    const progressBar = document.getElementById('progress-bar');
    const form        = document.getElementById('lifestyle-form');
    const spinner     = document.getElementById('final-spinner');
    const btnText     = document.getElementById('final-text');
    const arrow       = document.getElementById('final-arrow');

    function updateProgress() {
        const answered = new Set(
            [...radios].filter(r => r.checked).map(r => r.dataset.kategori)
        ).size;
        const pct = Math.round((answered / total) * 100);
        countBadge.textContent  = `${answered} / ${total} dijawab`;
        progressBar.style.width = `${pct}%`;
    }

    // Visual check mark inside radio card
    radios.forEach(radio => {
        radio.addEventListener('change', function () {
            document.querySelectorAll(`.lifestyle-radio[data-kategori="${this.dataset.kategori}"]`).forEach(r => {
                const check = r.closest('label').querySelector('svg');
                if (!r.checked) { check?.classList.add('hidden'); }
            });
            const check = this.closest('label').querySelector('svg');
            check?.classList.remove('hidden');
            updateProgress();
        });
    });

    form.addEventListener('submit', function () {
        spinner.classList.remove('hidden');
        arrow.classList.add('hidden');
        btnText.textContent = 'Memproses...';
    });

    updateProgress();
})();
</script>
@endpush
