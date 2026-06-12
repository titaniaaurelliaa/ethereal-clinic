@extends('layouts_admin.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
        <p class="text-gray-500 mt-2">Selamat datang di panel administrator The Ethereal Clinic</p>
    </div>

    <!-- Stats Cards Row 1 -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Pertanyaan Anamnesis</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalSymptoms ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Masalah Kulit</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalSkinProblems ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Produk</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalProducts ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Treatment</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalTreatments ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Row 2 -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-r from-pink-500 to-pink-400 rounded-xl shadow p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/80 text-sm">Total Analisis</p>
                    <p class="text-4xl font-bold">{{ $totalAnalysis ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-sm {{ ($trendPercentage ?? 0) >= 0 ? 'text-green-300' : 'text-red-300' }}">
                    {{ ($trendPercentage ?? 0) >= 0 ? '↑' : '↓' }} {{ number_format(abs($trendPercentage ?? 0), 1) }}% dari bulan lalu
                </span>
                <p class="text-xs text-white/70 mt-1">Bulan ini: {{ $analysisThisMonth ?? 0 }} | Bulan lalu: {{ $analysisLastMonth ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Pasien</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalPatients ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Rata-rata Confidence Score</p>
                    <p class="text-3xl font-bold text-gray-800">{{ number_format($avgConfidenceScore ?? 0, 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Chart 1: Analisis Per Bulan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-1">
                <div>
                    <h3 class="text-base font-semibold text-gray-800">Statistik Analisis Per Bulan</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Tahun {{ date('Y') }}</p>
                </div>
            </div>

            <div class="flex items-center gap-2 mb-4 mt-2">
                <span class="inline-block w-3 h-3 rounded-sm" style="background:#EC4899;"></span>
                <span class="text-xs text-gray-500">Jumlah analisis</span>
            </div>

            <div style="position: relative; height: 250px;">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Trending Masalah Kulit -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-1">
                <div>
                    <h3 class="text-base font-semibold text-gray-800">Trending Masalah Kulit</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Bulan ini</p>
                </div>
            </div>

            <div id="trendLegend" class="flex flex-wrap gap-x-4 gap-y-1 mb-4 mt-2"></div>

            <div style="position: relative; height: 250px;">
                <canvas id="trendingChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tabel Riwayat Analisis Terbaru -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100 bg-gray-50/60">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Riwayat Analisis Terbaru</h3>
                <p class="text-xs text-gray-400 mt-0.5">Menampilkan 5 data analisis terakhir</p>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-pink-100 text-pink-600 text-xs font-semibold rounded-full">
                <span class="w-1.5 h-1.5 bg-pink-500 rounded-full animate-pulse"></span>
                Live Data
            </span>
        </div>

        @if(isset($recentAnalysis) && count($recentAnalysis) > 0)
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px]">
                <thead>
                    <tr style="background: linear-gradient(to right, rgba(123,85,86,0.06), rgba(155,107,108,0.06));">
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-12">No</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-32">Tanggal & Waktu</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-40">Pasien</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-48">Hasil Diagnosa</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-36">CF Score</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($recentAnalysis as $i => $analysis)
                    @php
                        $cf = $analysis->confidence_score;
                        $cfColor = $cf >= 75
                            ? ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'bar' => 'bg-emerald-500', 'badge' => 'Tinggi']
                            : ($cf >= 50
                                ? ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'bar' => 'bg-yellow-400', 'badge' => 'Sedang']
                                : ['bg' => 'bg-red-50',    'text' => 'text-red-600',    'bar' => 'bg-red-400',    'badge' => 'Rendah']);
                    @endphp
                    <tr class="hover:bg-pink-50/30 transition-colors duration-150 group">
                        <td class="px-4 py-4">
                            <span class="w-7 h-7 rounded-full bg-gray-100 text-gray-500 text-xs font-bold flex items-center justify-center group-hover:bg-[#7B5556] group-hover:text-white transition-colors">
                                {{ $i + 1 }}
                            </span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <p class="text-sm font-medium text-gray-800">{{ $analysis->created_at->format('d M Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $analysis->created_at->format('H:i') }} WIB</p>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0"
                                    style="background: linear-gradient(135deg, #7B5556, #9B6B6C);">
                                    {{ strtoupper(substr($analysis->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-800 truncate max-w-[120px]">{{ $analysis->user->name ?? 'Tidak diketahui' }}</p>
                                    <p class="text-xs text-gray-400 truncate max-w-[120px]">{{ $analysis->user->email ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-pink-100 text-pink-600 text-xs font-semibold rounded-full whitespace-nowrap">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ \Illuminate\Support\Str::limit($analysis->skinProblem->name ?? 'Tidak diketahui', 25) }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2 min-w-[120px]">
                                <div class="flex-1 bg-gray-100 rounded-full h-1.5">
                                    <div class="{{ $cfColor['bar'] }} h-1.5 rounded-full" style="width: {{ min($cf, 100) }}%"></div>
                                </div>
                                <span class="text-sm font-bold {{ $cfColor['text'] }} w-12 text-right whitespace-nowrap">
                                    {{ number_format($cf, 1) }}%
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $cfColor['bg'] }} {{ $cfColor['text'] }} whitespace-nowrap">
                                {{ $cfColor['badge'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="flex flex-col items-center justify-center py-16 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <p class="text-gray-500 font-medium">Belum ada riwayat analisis</p>
            <p class="text-gray-400 text-sm mt-1">Data akan muncul setelah pasien melakukan analisis kulit</p>
        </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data dari Blade
    const monthlyLabels = @json($bulanNama ?? []);
    const monthlyValues = @json($chartMonthlyData ?? []);
    
    @if(isset($trendingSkinProblems) && count($trendingSkinProblems) > 0)
    const trendLabels = @json($trendingSkinProblems->map(fn($i) => $i->skinProblem->name ?? 'Unknown')->toArray());
    const trendValues = @json($trendingSkinProblems->pluck('total')->toArray());
    @else
    const trendLabels = [];
    const trendValues = [];
    @endif
    
    // Warna pink untuk chart
    const PINK_MID = '#F472B6';
    const PINK_DARK = '#EC4899';
    
    // Palet warna untuk trending
    const trendPalette = [
        '#EC4899',
        '#F472B6',
        '#F9A8D4',
        '#FBCFE8',
        '#FDF2F8',
    ];
    
    const trendColors = trendPalette.slice(0, trendLabels.length);
    const GRID_COLOR = '#f0f0f0';
    const TICK_COLOR = '#9ca3af';
    
    // Chart 1: Analisis Per Bulan (Bar Chart)
    const monthlyCtx = document.getElementById('monthlyChart');
    if (monthlyCtx && monthlyLabels.length > 0) {
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Jumlah Analisis',
                    data: monthlyValues,
                    backgroundColor: PINK_MID,
                    borderColor: PINK_DARK,
                    borderWidth: 1,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: PINK_DARK,
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(ctx) {
                                return '  ' + ctx.parsed.y + ' analisis';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: TICK_COLOR, font: { size: 11 } },
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { color: TICK_COLOR, font: { size: 11 }, stepSize: 5 },
                        grid: { color: GRID_COLOR }
                    }
                }
            }
        });
    }
    
    // Legend untuk trending
    const legendWrap = document.getElementById('trendLegend');
    if (legendWrap && trendLabels.length > 0) {
        legendWrap.innerHTML = trendLabels.map((label, i) => 
            `<span style="display:inline-flex;align-items:center;gap:5px;font-size:11px;color:#6b7280;">
                <span style="width:10px;height:10px;border-radius:2px;background:${trendColors[i]};display:inline-block;"></span>
                ${label.length > 20 ? label.substring(0, 18) + '...' : label}
             </span>`
        ).join('');
    }
    
    // Chart 2: Trending Masalah Kulit (Horizontal Bar Chart)
    const trendingCtx = document.getElementById('trendingChart');
    if (trendingCtx && trendLabels.length > 0) {
        new Chart(trendingCtx, {
            type: 'bar',
            data: {
                labels: trendLabels.map(l => l.length > 25 ? l.substring(0, 22) + '...' : l),
                datasets: [{
                    label: 'Jumlah Diagnosa',
                    data: trendValues,
                    backgroundColor: trendColors,
                    borderColor: trendColors.map(() => PINK_DARK),
                    borderWidth: 0,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: PINK_DARK,
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(ctx) {
                                return '  ' + ctx.parsed.x + ' diagnosa';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: { color: TICK_COLOR, font: { size: 11 }, stepSize: 5 },
                        grid: { color: GRID_COLOR }
                    },
                    y: {
                        ticks: { color: '#374151', font: { size: 11 } },
                        grid: { display: false }
                    }
                }
            }
        });
    } else if (trendingCtx) {
        trendingCtx.style.display = 'none';
        const parent = trendingCtx.parentElement;
        if (parent && !parent.querySelector('.no-data-message')) {
            const msg = document.createElement('div');
            msg.className = 'no-data-message flex flex-col items-center justify-center py-10';
            msg.innerHTML = '<svg class="w-16 h-16 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg><p class="text-gray-400 text-center">Belum ada data trending</p>';
            parent.appendChild(msg);
        }
    }
});
</script>

@endsection