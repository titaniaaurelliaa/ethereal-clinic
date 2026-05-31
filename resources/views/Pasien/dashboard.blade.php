@extends('layouts_pasien.app')

@section('title', 'Dashboard Pasien')

@section('content')
<header class="relative bg-gradient-to-br from-white to-[#EBDBDD]/30 rounded-[32px] p-8 mb-8 overflow-hidden shadow-sm border border-[#E1E3DE]/50 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
    <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-gradient-to-br from-[#7B5556]/10 to-transparent rounded-full blur-2xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-32 h-32 bg-gradient-to-tr from-[#7B5556]/10 to-transparent rounded-full blur-2xl pointer-events-none"></div>
    
    <div class="relative z-10">
        <span class="inline-block py-1 px-3 rounded-full bg-[#7B5556]/10 text-[#7B5556] text-xs font-bold tracking-wider uppercase mb-3">
            Klinik Estetika Digital
        </span>
        <h1 class="text-3xl md:text-4xl font-extrabold text-[#5D605C] tracking-tight">
            Selamat datang, <span class="text-[#7B5556]">{{ explode(' ', Auth::user()->name)[0] }}!</span>
        </h1>
        <p class="text-[#797B78] mt-3 text-sm md:text-base max-w-xl leading-relaxed">
            Perjalanan perawatan kulit personal Anda menunjukkan kemajuan yang positif. Pantau terus kondisi wajah Anda secara rutin.
        </p>
    </div>
    
    <div class="relative z-10 w-full lg:w-auto">
        <a href="{{ route('analisis.index') }}" class="group relative flex items-center justify-center gap-3 bg-gradient-to-r from-[#7B5556] to-[#996b6d] text-white px-8 py-4 rounded-full text-base font-bold shadow-xl shadow-[#7B5556]/30 hover:shadow-2xl hover:shadow-[#7B5556]/40 hover:-translate-y-1 transition-all duration-300 w-full lg:w-auto overflow-hidden">
            <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent group-hover:animate-[shimmer_1.5s_infinite]"></div>
            
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
            </svg>
            Mulai Analisis Wajah
        </a>
    </div>
</header>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    
    <div class="bg-white rounded-[32px] p-7 shadow-sm hover:shadow-md transition-shadow duration-300 border border-[#E1E3DE]/60 lg:col-span-2 flex flex-col justify-between group">
        <div>
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-[#5D605C] flex items-center gap-2">
                    <div class="p-2 bg-[#7B5556]/10 rounded-xl text-[#7B5556]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    Status Pemindaian Terakhir
                </h3>
            </div>
            
            @if($latestHistory)
                @php
                    // Murni dibulatkan (misal: 85%)
                    $percentage = round($latestHistory->confidence_score);
                @endphp
                <div class="flex flex-col md:flex-row justify-between items-stretch p-1 gap-6">
                    <div class="flex-1">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 text-[11px] font-bold text-gray-500 tracking-wider uppercase mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $latestHistory->created_at->translatedFormat('d F Y - H:i') }} WIB
                        </span>
                        <h4 class="font-extrabold text-[#7B5556] text-3xl tracking-tight mb-2">
                            {{ $latestHistory->skinProblem->name ?? 'Masalah Terdeteksi' }}
                        </h4>
                        <p class="text-sm text-gray-500 leading-relaxed">
                            Berdasarkan hasil analisis klinis dan visual AI, kami telah menyiapkan resep pengobatan dan tindakan khusus untuk Anda.
                        </p>
                    </div>
                    
                    <div class="shrink-0 flex flex-col items-center justify-center p-6 bg-gradient-to-br from-[#7B5556]/5 to-transparent border border-[#7B5556]/10 rounded-3xl w-full md:w-48 transition-transform duration-500 group-hover:scale-105">
                        <div class="relative flex items-center justify-center w-24 h-24 mb-2">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                <path class="text-gray-200" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                <path class="text-[#7B5556] animate-[dash_1.5s_ease-out_forwards]" stroke-dasharray="{{ $percentage }}, 100" stroke-width="3" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-2xl font-black text-[#5D605C]">{{ $percentage }}%</span>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Tingkat Kepastian</span>
                    </div>
                </div>
            @else
                <div class="text-center py-12 px-4 border-2 border-dashed border-[#E1E3DE] rounded-3xl bg-gray-50/50 hover:bg-gray-50 transition-colors">
                    <div class="w-20 h-20 bg-white shadow-sm rounded-full flex items-center justify-center mx-auto mb-4 border border-[#E1E3DE]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        </svg>
                    </div>
                    <p class="text-gray-500 font-bold text-lg mb-1">Belum Ada Rekam Medis</p>
                    <p class="text-sm text-gray-400 max-w-sm mx-auto">Ambil foto wajah pertama Anda dan dapatkan analisis kondisi kulit seketika.</p>
                </div>
            @endif
        </div>

        @if($latestHistory)
            <div class="mt-6 pt-5 border-t border-[#E1E3DE]/40 flex justify-end">
                <a href="{{ route('analisis.show', $latestHistory->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-50 hover:bg-[#7B5556]/10 text-sm font-bold text-[#7B5556] rounded-xl transition-colors group/btn">
                    Lihat Rekomendasi Medis
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover/btn:translate-x-1.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-[32px] p-7 shadow-sm hover:shadow-md transition-shadow duration-300 border border-[#E1E3DE]/60 flex flex-col justify-between overflow-hidden relative">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-[#7B5556]/5 rounded-full blur-xl pointer-events-none"></div>
        
        <div>
            <h3 class="text-xl font-bold text-[#5D605C] mb-6 flex items-center gap-2">
                <div class="p-2 bg-gray-100 rounded-xl text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                Panduan Diagnosis
            </h3>
            
            <div class="space-y-4 text-sm text-[#5D605C]">
                <div class="flex gap-4 p-3 rounded-2xl hover:bg-gray-50 transition-colors">
                    <div class="shrink-0 w-8 h-8 rounded-full bg-[#7B5556]/10 text-[#7B5556] flex items-center justify-center font-bold text-sm">1</div>
                    <p class="leading-relaxed"><strong class="block text-gray-700">Wajah Bersih</strong>Pastikan tidak ada make-up atau kotoran sebelum difoto.</p>
                </div>
                <div class="flex gap-4 p-3 rounded-2xl hover:bg-gray-50 transition-colors">
                    <div class="shrink-0 w-8 h-8 rounded-full bg-[#7B5556]/10 text-[#7B5556] flex items-center justify-center font-bold text-sm">2</div>
                    <p class="leading-relaxed"><strong class="block text-gray-700">Cahaya Terang</strong>Gunakan pencahayaan merata, hindari bayangan di wajah.</p>
                </div>
                <div class="flex gap-4 p-3 rounded-2xl hover:bg-gray-50 transition-colors">
                    <div class="shrink-0 w-8 h-8 rounded-full bg-[#7B5556]/10 text-[#7B5556] flex items-center justify-center font-bold text-sm">3</div>
                    <p class="leading-relaxed"><strong class="block text-gray-700">Jawab Jujur</strong>Isi kuesioner anamnesis sesuai kondisi nyata kulit Anda.</p>
                </div>
            </div>
        </div>
        
        <div class="mt-6 pt-5 border-t border-[#E1E3DE]/40">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-4 rounded-2xl border border-gray-200/50">
                <span class="text-[10px] font-bold text-gray-500 block uppercase tracking-wider mb-1 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    Disclaimer Medis
                </span>
                <p class="text-[11px] text-gray-500 leading-snug">Hasil diagnosis AI bersifat prediktif. Tetap konsultasikan tindakan pengobatan lanjutan dengan dokter klinik.</p>
            </div>
        </div>
    </div>
</div>

<div class="mb-10">
    <div class="flex justify-between items-end mb-6">
        <h3 class="text-xl font-bold text-[#5D605C] flex items-center gap-3">
            <div class="p-2 bg-[#7B5556]/10 rounded-xl text-[#7B5556]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6m-6 4h3" />
                </svg>
            </div>
            Artikel Kesehatan Terkini
        </h3>

    </div>
    
    <div class="flex overflow-x-auto snap-x snap-mandatory gap-5 pb-6 hide-scrollbar px-1">
        @foreach($berita as $item)
            <div class="group relative snap-start shrink-0 w-[280px] md:w-[320px] bg-white border border-[#E1E3DE] rounded-[24px] overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col h-full cursor-pointer">
                
                <div class="relative w-full h-44 bg-gray-100 overflow-hidden">
                    <img src="{{ $item['image'] }}" alt="{{ $item['judul'] }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                
                <div class="p-5 flex-1 flex flex-col justify-between bg-white z-10">
                    <div>
                        <h4 class="font-bold text-[#5D605C] text-base line-clamp-2 leading-snug group-hover:text-[#7B5556] transition-colors">
                            {{ $item['judul'] }}
                        </h4>
                        <p class="text-xs text-gray-500 mt-2.5 line-clamp-2 leading-relaxed">
                            {{ $item['deskripsi'] }}
                        </p>
                    </div>
                    
                    <div class="mt-5 pt-4 border-t border-gray-100">
                        <a href="{{ $item['link'] }}" target="_blank" rel="noopener noreferrer" class="flex justify-between items-center text-sm font-bold text-[#7B5556] hover:text-[#5D605C] transition-colors">
                            Baca Selengkapnya
                            <div class="w-8 h-8 rounded-full bg-[#7B5556]/10 flex items-center justify-center group-hover:bg-[#7B5556] group-hover:text-white transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:rotate-45 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    /* Menyembunyikan Scrollbar Slider */
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    
    /* Animasi Shimmer Tombol */
    @keyframes shimmer {
        100% { transform: translateX(100%); }
    }
    
    /* Animasi Progress Circle SVG */
    @keyframes dash {
        to { stroke-dashoffset: 0; }
    }
    
    /* Animasi Panah Geser */
    @keyframes bounce-horizontal {
        0%, 100% { transform: translateX(0); }
        50% { transform: translateX(25%); }
    }
</style>
@endsection