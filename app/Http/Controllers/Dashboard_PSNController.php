<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AnalysisHistoryModel;
use App\Models\News;
class Dashboard_PSNController extends Controller
{
    public function index()
    {
       
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        
        $latestHistory = $user->analysisHistories()->latest()->first();
        
        // 3. Ambil 3 berita terbaru dari database (dinamis)
        $beritaList = News::with('user')->latest()->take(3)->get();

        // 4. Lempar semua variabel tersebut ke file view dashboard.blade.php
        return view('Pasien.dashboard', compact('user', 'latestHistory', 'beritaList'));
    }

    /**
     * Tampilkan riwayat seluruh analisis kulit milik pasien yang sedang login.
     * Data bersifat READ-ONLY — tidak mengubah atau menghitung ulang CF.
     *
     * View: resources/views/Pasien/history/index.blade.php
     */
    public function history()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $histories = $user->analysisHistories()
            ->with('skinProblem')
            ->latest()
            ->get();

        return view('Pasien.history.index', compact('histories'));
    }
}