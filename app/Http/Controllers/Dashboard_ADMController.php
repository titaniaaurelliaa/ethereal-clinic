<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SymptomModel;
use App\Models\SkinProblemModel;
use App\Models\ProductModel;
use App\Models\TreatmentModel;
use App\Models\AnalysisHistoryModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Dashboard_ADMController extends Controller
{
    public function index()
    {
        // Total gejala
        $totalSymptoms = SymptomModel::count();
        
        // Total masalah kulit
        $totalSkinProblems = SkinProblemModel::count();
        
        // Total produk
        $totalProducts = ProductModel::count();
        
        // Total treatment
        $totalTreatments = TreatmentModel::count();
        
        // Total riwayat analisis
        $totalAnalysis = AnalysisHistoryModel::count();
        
        // Total pasien (user dengan role pasien)
        $totalPatients = User::where('role', 'pasien')->count();
        
        // Rata-rata confidence score dari semua analisis
        $avgConfidenceScore = AnalysisHistoryModel::avg('confidence_score') ?? 0;
        
        // Analisis bulan ini
        $analysisThisMonth = AnalysisHistoryModel::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        // Analisis bulan lalu
        $analysisLastMonth = AnalysisHistoryModel::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        
        // Trend persentase
        $trendPercentage = $analysisLastMonth > 0 
            ? (($analysisThisMonth - $analysisLastMonth) / $analysisLastMonth) * 100 
            : ($analysisThisMonth > 0 ? 100 : 0);
        
        // Analisis per bulan untuk chart
        $analysisPerBulan = AnalysisHistoryModel::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('YEAR(created_at) as tahun'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('tahun', 'bulan')
            ->orderBy('bulan')
            ->get();
        
        // Persiapan data untuk 12 bulan (isi 0 jika tidak ada data)
        $monthlyData = [];
        $bulanNama = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        
        foreach ($analysisPerBulan as $data) {
            $monthlyData[$data->bulan - 1] = $data->total; // -1 karena array mulai dari 0
        }
        
        $chartMonthlyData = [];
        for ($i = 0; $i < 12; $i++) {
            $chartMonthlyData[] = $monthlyData[$i] ?? 0;
        }
        
        //Masalah kulit yang sedang tren bulan ini (5 teratas)
        $trendingSkinProblems = AnalysisHistoryModel::select('result_problem_id', DB::raw('COUNT(*) as total'))
            ->with('skinProblem')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->groupBy('result_problem_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        
        // Jika tidak ada data bulan ini, ambil data keseluruhan
        if ($trendingSkinProblems->isEmpty()) {
            $trendingSkinProblems = AnalysisHistoryModel::select('result_problem_id', DB::raw('COUNT(*) as total'))
                ->with('skinProblem')
                ->groupBy('result_problem_id')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get();
        }
        
        //Gejala yang paling sering muncul di analysis_data (5 teratas)
        $gejalaTerbanyak = $this->getGejalaTerbanyakFromAnalysis();
        
        // Data untuk chart tren masalah kulit per bulan (3 teratas)
        // Ambil 3 masalah kulit dengan jumlah analisis terbanyak
        $top3SkinProblems = SkinProblemModel::withCount('analysisHistories')
            ->orderBy('analysis_histories_count', 'desc')
            ->limit(3)
            ->get();
        
        $trendLineData = [];
        $warnaChart = ['#7B5556', '#9B6B6C', '#B0B3AE'];
        
        foreach ($top3SkinProblems as $index => $problem) {
            $dataPerBulan = AnalysisHistoryModel::select(
                    DB::raw('MONTH(created_at) as bulan'),
                    DB::raw('COUNT(*) as total')
                )
                ->where('result_problem_id', $problem->id)
                ->whereYear('created_at', now()->year)
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->get()
                ->pluck('total', 'bulan')
                ->toArray();
            
            // Isi data untuk 12 bulan (default 0 jika tidak ada data)
            $fullData = [];
            for ($i = 1; $i <= 12; $i++) {
                $fullData[] = $dataPerBulan[$i] ?? 0;
            }
            
            $trendLineData[] = [
                'nama' => $problem->name,
                'data' => $fullData,
                'warna' => $warnaChart[$index % 3]
            ];
        }
        
        //Riwayat analisis terbaru dengan relasi user dan skin problem
        $recentAnalysis = AnalysisHistoryModel::with(['user', 'skinProblem'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalSymptoms',
            'totalSkinProblems',
            'totalProducts',
            'totalTreatments',
            'totalAnalysis',
            'totalPatients',
            'avgConfidenceScore',
            'analysisThisMonth',
            'analysisLastMonth',
            'trendPercentage',
            'analysisPerBulan',
            'chartMonthlyData',
            'bulanNama',
            'trendingSkinProblems',
            'gejalaTerbanyak',
            'trendLineData',
            'recentAnalysis'
        ));
    }
    
    /**
     * Ambil data gejala terbanyak dari analysis_data JSON
     */
    private function getGejalaTerbanyakFromAnalysis()
    {
        // Ambil semua analysis_data
        $analyses = AnalysisHistoryModel::select('analysis_data')->get();
        
        $gejalaCount = [];
        
        foreach ($analyses as $analysis) {
            $analysisData = $analysis->analysis_data;
            
            if (is_array($analysisData)) {
                foreach ($analysisData as $gejala) {
                    // Cek berbagai kemungkinan struktur data
                    $gejalaId = $gejala['gejala_id'] ?? $gejala['symptom_id'] ?? $gejala['id'] ?? null;
                    
                    if ($gejalaId) {
                        if (!isset($gejalaCount[$gejalaId])) {
                            $gejalaCount[$gejalaId] = 0;
                        }
                        $gejalaCount[$gejalaId]++;
                    }
                }
            }
        }
        
        // Ambil data gejala dari database
        $result = [];
        foreach ($gejalaCount as $gejalaId => $count) {
            $symptom = SymptomModel::find($gejalaId);
            if ($symptom) {
                $result[] = (object)[
                    'symptom_id' => $gejalaId,
                    'total' => $count,
                    'symptom' => $symptom
                ];
            }
        }
        
        // Urutkan berdasarkan total terbanyak
        usort($result, function($a, $b) {
            return $b->total <=> $a->total;
        });
        
        return array_slice($result, 0, 5);
    }
}