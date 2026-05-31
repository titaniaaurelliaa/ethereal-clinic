<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SymptomRule;          // replaces the dropped symptoms table
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
        
        // Analisis bulan lalu — clone now() to avoid mutating the same Carbon instance
        $lastMonth = now()->subMonth();
        $analysisLastMonth = AnalysisHistoryModel::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
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
        
        // Total pertanyaan anamnesis (SymptomRule — pengganti tabel symptoms yang sudah dihapus)
        $totalSymptoms = SymptomRule::count();

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
            'trendLineData',
            'recentAnalysis'
        ));
    }
    
}