<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AnalysisHistoryModel;
use App\Models\User;
class Dashboard_PSNController extends Controller
{
    public function index()
    {
       
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        
        $latestHistory = $user->analysisHistories()->latest()->first();
        
        // 3. Data array untuk Artikel/Berita Kesehatan (Bisa digeser/slide di tampilan)
        $berita = [
            [
                'judul' => 'Mengenal Jerawat Pustula dan Cara Penanganannya',
                'deskripsi' => 'Ketahui penyebab munculnya jerawat bernanah dan langkah awal perawatannya secara klinis.',
                'image' => 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571?auto=format&fit=crop&w=500&q=80',
                'link' => 'https://www.alodokter.com/komunitas/topic/jerawat-pustula',
            ],
            [
                'judul' => 'Pentingnya Menjaga Skin Barrier Wajah',
                'deskripsi' => 'Skin barrier yang rusak adalah awal dari segala masalah kulit, termasuk jerawat meradang.',
                'image' => 'https://images.unsplash.com/photo-1617897903246-719242758050?auto=format&fit=crop&w=500&q=80',
                'link' => 'https://www.halodoc.com/artikel/kenali-tanda-skin-barrier-rusak-dan-cara-mengatasinya',
            ],
            [
                'judul' => 'Makanan yang Memicu Timbulnya Jerawat',
                'deskripsi' => 'Gaya hidup dan pola makan sangat berpengaruh. Hindari 5 jenis makanan ini agar kulit tetap bersih.',
                'image' => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?auto=format&fit=crop&w=500&q=80',
                'link' => 'https://yankes.kemkes.go.id/view_artikel/1218/makanan-penyebab-jerawat',
            ],
            [
                'judul' => 'Perbedaan Jerawat Papula dan Nodula',
                'deskripsi' => 'Jangan salah penanganan! Kenali perbedaan mendasar antara jerawat meradang biasa dan jerawat batu.',
                'image' => 'https://images.unsplash.com/photo-1515377905703-c4788e51af15?auto=format&fit=crop&w=500&q=80',
                'link' => 'https://www.siloamhospitals.com/informasi-siloam/artikel/apa-itu-jerawat-nodul',
            ]
        ];

        // 4. Lempar semua variabel tersebut ke file view dashboard.blade.php
        return view('Pasien.dashboard', compact('user', 'latestHistory', 'berita'));
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