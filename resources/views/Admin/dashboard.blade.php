@extends('layouts_admin.app')

@section('title', 'Dashboard Admin')

@section('content')
<header class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-12">
    <div>
        <h1 class="text-3xl md:text-4xl font-semibold text-[#5D605C] tracking-tight">Selamat datang, {{ explode(' ', Auth::user()->name)[0] }}!</h1>
        <p class="text-[#797B78] mt-3 md:text-lg max-w-2xl leading-relaxed">
            Perjalanan perawatan kulit personal Anda menunjukkan kemajuan yang positif. Ini adalah ringkasan mingguan Anda.
        </p>
    </div>
</header>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <!-- Total Gejala -->
    <div class="bg-white rounded-[32px] p-6 shadow-sm border border-[#E1E3DE]/50 transition-all hover:shadow-md">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-full bg-[#EBDBDD] flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#7B5556]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <span class="text-[#B0B3AE] text-xs font-medium">Total</span>
        </div>
        <h3 class="text-[#797B78] text-sm font-medium mb-1">Data Gejala</h3>
        <p class="text-3xl font-bold text-[#5D605C]">{{ $totalGejala ?? 24 }}</p>
        <p class="text-xs text-green-600 mt-2">+{{ $gejalaBaru ?? 3 }} bulan ini</p>
    </div>

    <!-- Total Konsultasi -->
    <div class="bg-white rounded-[32px] p-6 shadow-sm border border-[#E1E3DE]/50 transition-all hover:shadow-md">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-full bg-[#E1E3DE] flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#68575E]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </div>
            <span class="text-[#B0B3AE] text-xs font-medium">Total</span>
        </div>
        <h3 class="text-[#797B78] text-sm font-medium mb-1">Total Konsultasi</h3>
        <p class="text-3xl font-bold text-[#5D605C]">{{ $totalKonsultasi ?? 482 }}</p>
        <p class="text-xs text-green-600 mt-2">+{{ $konsultasiBulanIni ?? 48 }} bulan ini</p>
    </div>

    <!-- Masalah Kulit -->
    <div class="bg-white rounded-[32px] p-6 shadow-sm border border-[#E1E3DE]/50 transition-all hover:shadow-md">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-full bg-[#FFF0ED] flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#7B5556]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="text-[#B0B3AE] text-xs font-medium">Total</span>
        </div>
        <h3 class="text-[#797B78] text-sm font-medium mb-1">Masalah Kulit</h3>
        <p class="text-3xl font-bold text-[#5D605C]">{{ $totalMasalahKulit ?? 8 }}</p>
        <p class="text-xs text-[#797B78] mt-2">Terdeteksi dalam sistem</p>
    </div>

    <!-- Data Produk -->
    <div class="bg-white rounded-[32px] p-6 shadow-sm border border-[#E1E3DE]/50 transition-all hover:shadow-md">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-full bg-[#EBDBDD] flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#7B5556]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <span class="text-[#B0B3AE] text-xs font-medium">Total</span>
        </div>
        <h3 class="text-[#797B78] text-sm font-medium mb-1">Data Produk</h3>
        <p class="text-3xl font-bold text-[#5D605C]">{{ $totalProduk ?? 156 }}</p>
        <p class="text-xs text-green-600 mt-2">+{{ $produkBaru ?? 12 }} bulan ini</p>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
    <!-- Grafik Gejala Paling Banyak -->
    <div class="bg-white rounded-[32px] p-6 shadow-sm border border-[#E1E3DE]/50">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-[#5D605C]">Gejala Paling Banyak Dikonsultasikan</h3>
            <span class="text-xs text-[#B0B3AE]">Bulan ini</span>
        </div>
        <canvas id="gejalaChart" height="250"></canvas>
    </div>

    <!-- Grafik Statistik Masalah Kulit Bulanan -->
    <div class="bg-white rounded-[32px] p-6 shadow-sm border border-[#E1E3DE]/50">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-[#5D605C]">Tren Masalah Kulit Bulanan</h3>
            <select class="text-xs border border-[#E1E3DE] rounded-lg px-2 py-1 text-[#797B78]">
                <option>2024</option>
                <option>2023</option>
            </select>
        </div>
        <canvas id="trendChart" height="250"></canvas>
    </div>
</div>

<!-- Tabel Konsultasi Bulanan -->
<div class="bg-white rounded-[32px] p-6 shadow-sm border border-[#E1E3DE]/50 mb-10">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-semibold text-[#5D605C]">Statistik Konsultasi Per Bulan</h3>
        <span class="text-xs text-[#B0B3AE]">Tahun 2024</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-[#E1E3DE]">
                    <th class="text-left py-3 text-[#797B78] font-medium">Bulan</th>
                    <th class="text-left py-3 text-[#797B78] font-medium">Jumlah Konsultasi</th>
                    <th class="text-left py-3 text-[#797B78] font-medium">Persentase</th>
                    <th class="text-left py-3 text-[#797B78] font-medium">Trend</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b border-[#F0F0EE]">
                    <td class="py-3 font-medium text-[#5D605C]">Januari</td>
                    <td class="py-3 text-[#5D605C]">342</td>
                    <td class="py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-24 bg-[#E1E3DE] rounded-full h-2">
                                <div class="bg-[#7B5556] rounded-full h-2" style="width: 65%"></div>
                            </div>
                            <span class="text-xs text-[#797B78]">65%</span>
                        </div>
                    </td>
                    <td class="py-3 text-green-600 text-sm">↑ 12%</td>
                </tr>
                <tr class="border-b border-[#F0F0EE]">
                    <td class="py-3 font-medium text-[#5D605C]">Februari</td>
                    <td class="py-3 text-[#5D605C]">398</td>
                    <td class="py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-24 bg-[#E1E3DE] rounded-full h-2">
                                <div class="bg-[#7B5556] rounded-full h-2" style="width: 75%"></div>
                            </div>
                            <span class="text-xs text-[#797B78]">75%</span>
                        </div>
                    </td>
                    <td class="py-3 text-green-600 text-sm">↑ 16%</td>
                </tr>
                <tr class="border-b border-[#F0F0EE]">
                    <td class="py-3 font-medium text-[#5D605C]">Maret</td>
                    <td class="py-3 text-[#5D605C]">456</td>
                    <td class="py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-24 bg-[#E1E3DE] rounded-full h-2">
                                <div class="bg-[#7B5556] rounded-full h-2" style="width: 86%"></div>
                            </div>
                            <span class="text-xs text-[#797B78]">86%</span>
                        </div>
                    </td>
                    <td class="py-3 text-green-600 text-sm">↑ 14%</td>
                </tr>
                <tr class="border-b border-[#F0F0EE]">
                    <td class="py-3 font-medium text-[#5D605C]">April</td>
                    <td class="py-3 text-[#5D605C]">482</td>
                    <td class="py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-24 bg-[#E1E3DE] rounded-full h-2">
                                <div class="bg-[#7B5556] rounded-full h-2" style="width: 91%"></div>
                            </div>
                            <span class="text-xs text-[#797B78]">91%</span>
                        </div>
                    </td>
                    <td class="py-3 text-green-600 text-sm">↑ 5%</td>
                </tr>
                <tr>
                    <td class="py-3 font-medium text-[#5D605C]">Mei</td>
                    <td class="py-3 text-[#5D605C]">520</td>
                    <td class="py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-24 bg-[#E1E3DE] rounded-full h-2">
                                <div class="bg-[#7B5556] rounded-full h-2" style="width: 98%"></div>
                            </div>
                            <span class="text-xs text-[#797B78]">98%</span>
                        </div>
                    </td>
                    <td class="py-3 text-green-600 text-sm">↑ 8%</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Trending Issues -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Trending Issues -->
    <div class="bg-white rounded-[32px] p-8 shadow-sm border border-[#E1E3DE]/50">
        <h3 class="text-xl font-semibold text-[#5D605C] mb-4">Masalah Kulit Trending</h3>
        <p class="text-[#797B78] text-sm mb-6">Top 5 masalah kulit yang paling banyak dikonsultasikan bulan ini</p>
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-[#EBDBDD] flex items-center justify-center text-[#7B5556] font-bold">1</div>
                    <span class="font-medium text-[#5D605C]">Jerawat</span>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-32 bg-[#E1E3DE] rounded-full h-2">
                        <div class="bg-[#7B5556] rounded-full h-2" style="width: 95%"></div>
                    </div>
                    <span class="text-sm text-[#797B78]">95%</span>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-[#E1E3DE] flex items-center justify-center text-[#68575E] font-bold">2</div>
                    <span class="font-medium text-[#5D605C]">Kulit Kering</span>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-32 bg-[#E1E3DE] rounded-full h-2">
                        <div class="bg-[#7B5556] rounded-full h-2" style="width: 78%"></div>
                    </div>
                    <span class="text-sm text-[#797B78]">78%</span>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-[#E1E3DE] flex items-center justify-center text-[#68575E] font-bold">3</div>
                    <span class="font-medium text-[#5D605C]">Komedo</span>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-32 bg-[#E1E3DE] rounded-full h-2">
                        <div class="bg-[#7B5556] rounded-full h-2" style="width: 62%"></div>
                    </div>
                    <span class="text-sm text-[#797B78]">62%</span>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-[#E1E3DE] flex items-center justify-center text-[#68575E] font-bold">4</div>
                    <span class="font-medium text-[#5D605C]">Bekas Jerawat</span>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-32 bg-[#E1E3DE] rounded-full h-2">
                        <div class="bg-[#7B5556] rounded-full h-2" style="width: 51%"></div>
                    </div>
                    <span class="text-sm text-[#797B78]">51%</span>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-[#E1E3DE] flex items-center justify-center text-[#68575E] font-bold">5</div>
                    <span class="font-medium text-[#5D605C]">Kulit Kusam</span>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-32 bg-[#E1E3DE] rounded-full h-2">
                        <div class="bg-[#7B5556] rounded-full h-2" style="width: 43%"></div>
                    </div>
                    <span class="text-sm text-[#797B78]">43%</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Grafik Gejala Paling Banyak
    const gejalaCtx = document.getElementById('gejalaChart').getContext('2d');
    new Chart(gejalaCtx, {
        type: 'bar',
        data: {
            labels: ['Jerawat', 'Kulit Kering', 'Komedo', 'Bekas Jerawat', 'Kulit Kusam', 'Minyak Berlebih'],
            datasets: [{
                label: 'Jumlah Konsultasi',
                data: [245, 189, 156, 134, 98, 87],
                backgroundColor: '#EBDBDD',
                borderColor: '#7B5556',
                borderWidth: 1,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 12 } }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#E1E3DE' },
                    title: { display: true, text: 'Jumlah Konsultasi', color: '#797B78' }
                },
                x: {
                    ticks: { font: { size: 11 } }
                }
            }
        }
    });

    // Grafik Tren Masalah Kulit Bulanan
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [
                {
                    label: 'Jerawat',
                    data: [120, 135, 150, 165, 180, 195, 210, 225, 240, 245, 250, 260],
                    borderColor: '#7B5556',
                    backgroundColor: 'rgba(123, 85, 86, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Kulit Kering',
                    data: [80, 85, 90, 100, 110, 125, 140, 155, 170, 180, 185, 189],
                    borderColor: '#9B6B6C',
                    backgroundColor: 'rgba(155, 107, 108, 0.05)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Komedo',
                    data: [65, 70, 78, 85, 95, 105, 115, 125, 135, 145, 150, 156],
                    borderColor: '#B0B3AE',
                    backgroundColor: 'rgba(176, 179, 174, 0.05)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 12 } }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#E1E3DE' },
                    title: { display: true, text: 'Jumlah Konsultasi', color: '#797B78' }
                }
            }
        }
    });
</script>
@endpush

@endsection