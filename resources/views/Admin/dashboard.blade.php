{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts_admin.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
        <p class="text-gray-500 mt-2">Selamat datang di panel administrator The Ethereal Clinic</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card Total Pertanyaan Anamnesis (SymptomRule) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Pertanyaan Anamnesis</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalSymptoms }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card Total Masalah Kulit -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Masalah Kulit</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalSkinProblems }}</p>
                </div>
                <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card Total Produk -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Produk</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalProducts }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card Total Treatment -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Treatment</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalTreatments }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Card Total Analisis -->
        <div class="bg-gradient-to-r from-[#7B5556] to-[#9B6B6C] rounded-xl shadow p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/80 text-sm">Total Analisis</p>
                    <p class="text-4xl font-bold">{{ $totalAnalysis }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-sm {{ $trendPercentage >= 0 ? 'text-green-300' : 'text-red-300' }}">
                    {{ $trendPercentage >= 0 ? '↑' : '↓' }} {{ number_format(abs($trendPercentage), 1) }}% dari bulan lalu
                </span>
                <p class="text-xs text-white/70 mt-1">Bulan ini: {{ $analysisThisMonth }} | Bulan lalu: {{ $analysisLastMonth }}</p>
            </div>
        </div>

        <!-- Card Total Pasien -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Pasien</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalPatients }}</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card Rata-rata CF Score -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Rata-rata Confidence Score</p>
                    <p class="text-3xl font-bold text-gray-800">{{ number_format($avgConfidenceScore, 2) }}</p>
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
        <!-- Chart: Analisis Per Bulan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Analisis Per Bulan ({{ date('Y') }})</h3>
            <canvas id="monthlyChart" height="200"></canvas>
        </div>

        <!-- Chart: Trending Masalah Kulit -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Trending Masalah Kulit Bulan Ini</h3>
            <canvas id="trendingChart" height="200"></canvas>
        </div>
    </div>

    <!-- Tabel Riwayat Analisis Terbaru -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Riwayat Analisis Terbaru</h3>
            <span class="text-sm text-gray-500">5 data terakhir</span>
        </div>
        
        @if(count($recentAnalysis) > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 text-gray-600 font-medium">Tanggal</th>
                            <th class="text-left py-3 text-gray-600 font-medium">Pasien</th>
                            <th class="text-left py-3 text-gray-600 font-medium">Hasil Diagnosa</th>
                            <th class="text-left py-3 text-gray-600 font-medium">CF Score</th>
                         </tr>
                    </thead>
                    <tbody>
                        @foreach($recentAnalysis as $analysis)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-3 text-gray-700">{{ $analysis->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-3 text-gray-700">{{ $analysis->user->name ?? 'Tidak diketahui' }}</td>
                            <td class="py-3 text-gray-700">{{ $analysis->skinProblem->name ?? 'Tidak diketahui' }}</td>
                            <td class="py-3">
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                    {{ number_format($analysis->confidence_score, 2) }}%
                                </span>
                            </td>
                         </tr>
                        @endforeach
                    </tbody>
                 </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Belum ada riwayat analisis</p>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart 1: Analisis Per Bulan (Bar Chart)
    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($bulanNama) !!},
            datasets: [{
                label: 'Jumlah Analisis',
                data: {!! json_encode($chartMonthlyData) !!},
                backgroundColor: '#EBDBDD',
                borderColor: '#7B5556',
                borderWidth: 1,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Chart 2: Trending Masalah Kulit (Bar Chart)
    @if(count($trendingSkinProblems) > 0)
    new Chart(document.getElementById('trendingChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($trendingSkinProblems->map(function($item) { return $item->skinProblem->name; })->toArray()) !!},
            datasets: [{
                label: 'Jumlah Diagnosa',
                data: {!! json_encode($trendingSkinProblems->pluck('total')->toArray()) !!},
                backgroundColor: '#FFB6C1',
                borderColor: '#7B5556',
                borderWidth: 1,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
    @endif
</script>
@endpush

@endsection