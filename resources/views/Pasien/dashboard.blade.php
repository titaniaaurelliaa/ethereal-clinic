@extends('layouts_pasien.app')

@section('title', 'Dashboard Pasien')

@section('content')
<header class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-8">
    <div>
        <h1 class="text-2xl md:text-3xl font-semibold text-[#5D605C] tracking-tight">Selamat datang, {{ explode(' ', Auth::user()->name)[0] }}!</h1>
        <p class="text-[#797B78] mt-2 text-sm md:text-base max-w-2xl leading-relaxed">
            Perjalanan perawatan kulit personal Anda menunjukkan kemajuan yang positif. Ini adalah ringkasan mingguan Anda.
        </p>
    </div>
    <button class="bg-gradient-to-r from-[#7B5556] to-[#EBDBDD] text-white px-6 py-2.5 rounded-full text-sm font-semibold shadow-lg shadow-[#7B5556]/20 hover:scale-105 active:scale-95 transition-all whitespace-nowrap">
        Mulai Analisis
    </button>
</header>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    
    <div class="bg-white rounded-[24px] p-6 shadow-sm border border-[#E1E3DE]/50 lg:col-span-2">
        <h3 class="text-lg font-semibold text-[#5D605C] mb-4">Regimen Pagi</h3>
        
        <div class="space-y-3">
            <div class="bg-[#E1E3DE]/30 rounded-xl p-4 flex items-center space-x-4 transition-transform hover:-translate-y-1">
                <div class="w-10 h-10 rounded-full bg-[#EBDBDD] flex items-center justify-center shrink-0 text-[#7B5556]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-[#5D605C]">Gentle Cleanser</h4>
                    <p class="text-[#797B78] text-xs mt-0.5">Langkah 1 • 07:00 AM</p>
                </div>
            </div>

            <div class="bg-[#E1E3DE]/30 rounded-xl p-4 flex items-center space-x-4 transition-transform hover:-translate-y-1">
                <div class="w-10 h-10 rounded-full bg-[#E1E3DE] flex items-center justify-center shrink-0 text-[#68575E]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-[#5D605C]">Treatment Serum</h4>
                    <p class="text-[#797B78] text-xs mt-0.5">Langkah 2 • 07:05 AM</p>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <a href="#" class="text-[11px] font-bold text-[#7B5556] tracking-widest uppercase hover:text-[#68575E] transition-colors flex items-center gap-1.5">
                LIHAT SELENGKAPNYA <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
            </a>
        </div>
    </div>

    <div class="bg-[#FFF7F6] rounded-[24px] p-6 shadow-sm border border-[#E1E3DE]/30 flex flex-col justify-center">
        <div>
            <span class="inline-block bg-[#E1E3DE]/60 text-[#68575E] text-[9px] font-bold tracking-widest uppercase px-2.5 py-1 rounded-full mb-4">
                SELF-CARE
            </span>
            <h3 class="text-xl font-semibold text-[#5D605C] mb-3 leading-tight">Pentingnya Hidrasi di Cuaca Panas</h3>
            <p class="text-[#797B78] text-xs leading-relaxed mb-6">
                Pelajari bagaimana menjaga skin barrier Anda tetap kuat meskipun dalam suhu ekstrim.
            </p>
            <a href="#" class="text-[#5D605C] font-semibold text-xs border-b border-[#E1E3DE] hover:border-[#7B5556] pb-0.5 transition-colors inline-block">
                Baca Artikel
            </a>
        </div>
    </div>

</div>

<div class="mb-6">
    <div class="inline-flex items-center gap-3 bg-gradient-to-r from-[#7B5556] to-[#EBDBDD] text-white px-6 py-3 rounded-full shadow-md">
        <span class="text-lg font-medium">Total Konsultasi</span>
        <span class="text-2xl font-bold">12</span>
    </div>
</div>

<div class="bg-white rounded-[24px] p-6 shadow-sm border border-[#E1E3DE]/50">
    
    <div class="flex justify-between items-end mb-6">
        <h3 class="text-xl font-semibold text-[#5D605C]">Riwayat Konsultasi Terbaru</h3>
        <a href="#" class="text-[#5D605C] font-medium text-xs hover:text-[#7B5556] transition-colors hidden md:block">Lihat Semua</a>
    </div>

    <div class="space-y-3">
        <div class="bg-[#E1E3DE]/30 rounded-[16px] p-4 flex flex-col md:flex-row md:items-center justify-between gap-3 transition-all hover:bg-[#E1E3DE]/50 cursor-pointer group">
            
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shrink-0 text-[#7B5556] shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <h4 class="font-bold text-[#5D605C] text-base">Pemeriksaan Kulit Berminyak</h4>
                    <p class="text-[#797B78] text-xs mt-0.5">Sesi video dengan Dr. Sanctuary</p>
                </div>
            </div>

            <div class="flex items-center justify-between md:justify-end md:space-x-8 w-full md:w-auto mt-3 md:mt-0 pt-3 md:pt-0 border-t md:border-0 border-[#E1E3DE]">
                <div class="flex flex-col md:items-end">
                    <span class="text-[9px] font-bold text-[#B0B3AE] tracking-widest uppercase mb-1">STATUS</span>
                    <div class="flex items-center gap-1.5">
                        <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div>
                        <span class="text-xs font-semibold text-[#5D605C]">Selesai</span>
                    </div>
                </div>

                <div class="flex flex-col items-end">
                    <span class="font-bold text-[#5D605C] text-sm">12 Okt 2023</span>
                    <span class="text-[10px] text-[#797B78] mt-0.5">14:30 WIB</span>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection