@extends('layouts_pasien.app')

@section('title', 'Riwayat Analisis — The Ethereal Clinic')

@section('content')

{{-- ═══ PAGE HEADER ═══════════════════════════════════════════════════ --}}
<header class="relative bg-gradient-to-br from-white to-[#EBDBDD]/30 rounded-[32px] p-8 mb-8 overflow-hidden shadow-sm border border-[#E1E3DE]/50">
    <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-gradient-to-br from-[#7B5556]/10 to-transparent rounded-full blur-2xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-32 h-32 bg-gradient-to-tr from-[#7B5556]/10 to-transparent rounded-full blur-2xl pointer-events-none"></div>

    <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <span class="inline-block py-1 px-3 rounded-full bg-[#7B5556]/10 text-[#7B5556] text-xs font-bold tracking-wider uppercase mb-3">
                Rekam Medis Digital
            </span>
            <h1 class="text-2xl md:text-3xl font-extrabold text-[#5D605C] tracking-tight">
                Riwayat Analisis Kulit
            </h1>
            <p class="text-[#797B78] mt-2 text-sm max-w-lg leading-relaxed">
                Pantau perjalanan perawatan kulit Anda dari waktu ke waktu. Semua hasil pemindaian AI tersimpan di sini.
            </p>
        </div>

        <a href="{{ route('analisis.index') }}"
           class="group flex items-center gap-2.5 bg-gradient-to-r from-[#7B5556] to-[#996b6d] text-white px-6 py-3 rounded-full text-sm font-bold shadow-lg shadow-[#7B5556]/25 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 shrink-0">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Analisis Baru
        </a>
    </div>
</header>

@if($histories->isNotEmpty())

{{-- ═══ COMPONENT 1: SKIN PROGRESS ANALYTICS CHART ═══════════════════ --}}
<div class="bg-white rounded-[28px] border border-[#E1E3DE]/60 shadow-sm p-6 md:p-8 mb-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="p-2.5 bg-[#7B5556]/10 rounded-xl">
            <svg class="w-5 h-5 text-[#7B5556]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
            </svg>
        </div>
        <div>
            <h2 class="text-lg font-bold text-[#5D605C]">Tren Kepastian Diagnosis</h2>
            <p class="text-xs text-[#797B78] mt-0.5">Perubahan confidence score dari setiap analisis Anda.</p>
        </div>
    </div>

    <div class="relative w-full" style="height: 280px;">
        <canvas id="historyChart"></canvas>
    </div>
</div>

{{-- ═══ COMPONENT 2: RESPONSIVE HISTORY LIST ══════════════════════════ --}}
<div class="mb-8">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-lg font-bold text-[#5D605C] flex items-center gap-2.5">
            <div class="p-2 bg-[#7B5556]/10 rounded-xl">
                <svg class="w-5 h-5 text-[#7B5556]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            Semua Rekam Medis
        </h2>
        <span class="text-xs font-bold text-[#797B78] bg-[#E1E3DE]/40 px-3 py-1.5 rounded-full">
            {{ $histories->count() }} Data
        </span>
    </div>

    <div class="flex flex-col gap-4">
        @foreach($histories as $index => $history)
            @php
                $percentage = round($history->confidence_score);
                $problemName = $history->skinProblem->name ?? 'Masalah Terdeteksi';
                $scanDate = $history->created_at->translatedFormat('d F Y - H:i');

                // Warna badge berdasarkan persentase
                $badgeColor = match(true) {
                    $percentage >= 80 => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'ring' => 'ring-red-100'],
                    $percentage >= 60 => ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'border' => 'border-orange-200', 'ring' => 'ring-orange-100'],
                    $percentage >= 40 => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'ring' => 'ring-amber-100'],
                    default           => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'border' => 'border-green-200', 'ring' => 'ring-green-100'],
                };
            @endphp

            <div class="group bg-white rounded-[24px] border border-[#E1E3DE]/60 shadow-sm hover:shadow-md hover:border-[#7B5556]/20 p-5 md:p-6 transition-all duration-300"
                 style="animation: fadeInUp 0.4s ease-out {{ $index * 0.06 }}s both;">

                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">

                    {{-- Nomor urut & Info --}}
                    <div class="flex items-center gap-4 flex-1 min-w-0">
                        {{-- Sequence number --}}
                        <div class="w-10 h-10 rounded-2xl bg-[#EBDBDD]/60 text-[#7B5556] flex items-center justify-center text-sm font-bold shrink-0 group-hover:bg-[#7B5556]/15 transition-colors">
                            {{ $histories->count() - $index }}
                        </div>

                        <div class="flex-1 min-w-0">
                            {{-- Tanggal --}}
                            <div class="flex items-center gap-1.5 mb-1.5">
                                <svg class="w-3.5 h-3.5 text-[#797B78] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-xs text-[#797B78] font-medium">{{ $scanDate }} WIB</span>
                            </div>

                            {{-- Nama masalah --}}
                            <h3 class="text-base font-bold text-[#5D605C] truncate group-hover:text-[#7B5556] transition-colors">
                                {{ $problemName }}
                            </h3>
                        </div>
                    </div>

                    {{-- Badge confidence --}}
                    <div class="shrink-0">
                        <span class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-full text-sm font-bold border {{ $badgeColor['bg'] }} {{ $badgeColor['text'] }} {{ $badgeColor['border'] }} ring-2 {{ $badgeColor['ring'] }}">
                            {{ $percentage }}%
                            <span class="text-[10px] font-semibold opacity-70">CF</span>
                        </span>
                    </div>

                    {{-- Action buttons --}}
                    <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto">
                        <a href="{{ route('analisis.show', $history->id) }}"
                           class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-bold
                                  bg-[#EBDBDD]/50 text-[#7B5556] border border-[#7B5556]/10
                                  hover:bg-[#7B5556] hover:text-white hover:border-[#7B5556]
                                  transition-all duration-200 group/btn">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Lihat Detail
                        </a>

                        <a href="{{ route('analisis.pdf', $history->id) }}"
                           class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-bold
                                  bg-gray-50 text-[#5D605C] border border-[#E1E3DE]
                                  hover:bg-[#5D605C] hover:text-white hover:border-[#5D605C]
                                  transition-all duration-200">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Cetak PDF
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@else

{{-- ═══ COMPONENT 3: EMPTY STATE ══════════════════════════════════════ --}}
<div class="bg-white rounded-[32px] border-2 border-dashed border-[#E1E3DE] p-10 md:p-16 text-center shadow-sm">
    <div class="max-w-sm mx-auto">
        {{-- Icon --}}
        <div class="w-24 h-24 bg-gradient-to-br from-[#EBDBDD]/60 to-[#E1E3DE]/30 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner border border-[#E1E3DE]/50">
            <svg class="w-12 h-12 text-[#7B5556]/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>

        <h3 class="text-xl font-bold text-[#5D605C] mb-2">
            Belum Ada Riwayat Rekam Medis
        </h3>
        <p class="text-sm text-[#797B78] leading-relaxed mb-8">
            Anda belum pernah melakukan analisis kulit. Mulai pemindaian pertama Anda sekarang untuk mendapatkan diagnosis dari AI kami.
        </p>

    </div>
</div>

@endif

{{-- ═══ ANIMATIONS ════════════════════════════════════════════════════ --}}
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(16px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

@endsection

@push('scripts')
@if($histories->isNotEmpty())
{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
(function () {
    // ── Data dari PHP (urutan kronologis: lama → baru untuk chart) ──
    const histories = @json(
        $histories->sortBy('created_at')->values()->map(fn($h) => [
            'date'  => $h->created_at->translatedFormat('d M Y'),
            'score' => round($h->confidence_score),
        ])
    );

    const labels = histories.map(h => h.date);
    const scores = histories.map(h => h.score);

    const ctx = document.getElementById('historyChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Confidence Score (%)',
                data: scores,
                borderColor: '#7B5556',
                backgroundColor: 'rgba(123, 85, 86, 0.08)',
                pointBackgroundColor: '#7B5556',
                pointBorderColor: '#fff',
                pointBorderWidth: 2.5,
                pointRadius: 5,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: '#7B5556',
                pointHoverBorderColor: '#EBDBDD',
                pointHoverBorderWidth: 3,
                borderWidth: 2.5,
                fill: true,
                tension: 0.35,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index',
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#5D605C',
                    titleColor: '#EBDBDD',
                    bodyColor: '#fff',
                    titleFont: { weight: '700', size: 11 },
                    bodyFont: { weight: '600', size: 13 },
                    padding: { x: 14, y: 10 },
                    cornerRadius: 12,
                    displayColors: false,
                    callbacks: {
                        title: (items) => items[0].label,
                        label: (item) => `CF Score: ${item.parsed.y}%`,
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#797B78',
                        font: { size: 10, weight: '600' },
                        maxRotation: 45,
                        autoSkip: true,
                        maxTicksLimit: 10,
                    },
                    border: { color: '#E1E3DE' },
                },
                y: {
                    min: 0,
                    max: 100,
                    grid: {
                        color: 'rgba(225,227,222,0.5)',
                        drawBorder: false,
                    },
                    ticks: {
                        color: '#797B78',
                        font: { size: 10, weight: '600' },
                        stepSize: 20,
                        callback: (val) => val + '%',
                    },
                    border: { display: false },
                }
            }
        }
    });
})();
</script>
@endif
@endpush
