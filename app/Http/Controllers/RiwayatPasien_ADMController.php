<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AnalysisHistoryModel;
use App\Models\SymptomRule;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * RiwayatPasien_ADMController
 *
 * Mengelola halaman Manajemen Riwayat Pasien di sisi Admin.
 *
 *   INDEX ─ GET /admin/riwayat-pasien           → index()  → Daftar semua pasien
 *   SHOW  ─ GET /admin/riwayat-pasien/{userId}  → show()   → Detail riwayat medis pasien
 */
class RiwayatPasien_ADMController extends Controller
{
    // ═══════════════════════════════════════════════════════════════════
    // INDEX — Daftar Pasien (Master View)
    // ═══════════════════════════════════════════════════════════════════

    /**
     * Tampilkan tabel semua pasien beserta statistik scan mereka.
     * Mendukung filter pencarian nama/email dan filter jumlah scan.
     *
     * Eager loading:
     *   - withCount('analysisHistories') → total scan per pasien
     *   - with('latestAnalysisHistory')  → tanggal scan terakhir (hasOne + latestOfMany)
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'pasien')
            ->withCount('analysisHistories as total_scan')
            ->with('latestAnalysisHistory:id,user_id,created_at');

        // ── Filter: Pencarian nama / email ────────────────────────────
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // ── Filter: Jumlah scan ───────────────────────────────────────
        if ($request->filled('scan_filter')) {
            match ($request->scan_filter) {
                '0'    => $query->doesntHave('analysisHistories'),
                '1-5'  => $query->has('analysisHistories', '>=', 1)
                                ->has('analysisHistories', '<=', 5),
                '6-10' => $query->has('analysisHistories', '>=', 6)
                                ->has('analysisHistories', '<=', 10),
                '10+'  => $query->has('analysisHistories', '>', 10),
                default => null,
            };
        }

        $patients = $query->latest()->paginate(10)->withQueryString();

        return view('admin.riwayat_pasien.index', compact('patients'));
    }

    // ═══════════════════════════════════════════════════════════════════
    // SHOW — Detail Riwayat Medis Pasien (Detail View)
    // ═══════════════════════════════════════════════════════════════════

    /**
     * Tampilkan halaman detail riwayat medis satu pasien.
     * Layout 2 kolom: profil ringkas (kiri) + timeline scan (kanan).
     *
     * Eager loading:
     *   - AnalysisHistoryModel::with('skinProblem') → nama diagnosis
     *   - SymptomRule lookup batch → resolusi pertanyaan anamnesis
     *
     * Pagination: 5 riwayat per halaman agar tidak terlalu panjang.
     */
    public function show(int $userId)
    {
        // ── Load data pasien + total scan ─────────────────────────────
        $patient = User::where('role', 'pasien')
            ->withCount('analysisHistories as total_scan')
            ->findOrFail($userId);

        // ── Load riwayat scan dengan pagination ──────────────────────
        $histories = AnalysisHistoryModel::where('user_id', $userId)
            ->with('skinProblem')
            ->latest()
            ->paginate(5);

        // ── Resolve SymptomRule IDs → teks pertanyaan (batch) ────────
        // Kumpulkan semua ID symptom rule dari jawaban anamnesis
        // lalu load sekali saja (hindari N+1)
        $symptomRuleIds = $histories->getCollection()
            ->pluck('analysis_data')
            ->filter()
            ->flatMap(fn ($data) => array_keys($data['jawaban_anamnesis'] ?? []))
            ->unique()
            ->values()
            ->toArray();

        $symptomRules = ! empty($symptomRuleIds)
            ? SymptomRule::whereIn('id', $symptomRuleIds)->pluck('pertanyaan', 'id')
            : collect();

        return view('admin.riwayat_pasien.show', compact(
            'patient',
            'histories',
            'symptomRules',
        ));
    }
}
