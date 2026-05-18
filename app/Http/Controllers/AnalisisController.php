<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AnalysisHistoryModel;
use App\Models\KnowledgeBase;          // NEW CODE: untuk resolve SymptomRule kontekstual
use App\Models\SkinProblemModel;
use App\Models\SymptomRule;             // NEW CODE: model pertanyaan anamnesis dinamis
use App\Services\SkinAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * AnalisisController
 *
 * Alur 3-Tahap Analisis Kulit Hybrid (Contextual Anamnesis — Fase 3):
 *
 *   STEP 1 ─ GET  /pasien/analisis          → index()        → view analisis.step1
 *             Form upload foto wajah.
 *
 *   STEP 2 ─ POST /pasien/analisis/scan     → scan()         → view analisis.step2
 *             Terima foto → kirim ke Roboflow → simpan temuan di Session
 *             → resolve SymptomRule kontekstual berdasarkan temuan dominan
 *             → tampilkan form anamnesis dinamis + kuesioner gaya hidup.
 *
 *   STEP 3 ─ POST /pasien/analisis/final    → processFinal() → view analisis.hasil
 *             Terima jawaban anamnesis + gaya hidup
 *             → hitung CF berlapis (Visual → Gejala Dinamis → Lifestyle)
 *             → simpan history → tampilkan hasil.
 *
 *   HISTORY ─ GET /pasien/analisis/{id}     → show()         → view analisis.hasil
 *             Tampilkan riwayat analisis tertentu milik user.
 */
class AnalisisController extends Controller
{
    /**
     * Key session untuk menyimpan data temuan visual sementara antar-step.
     * Data dihapus otomatis setelah processFinal() selesai.
     */
    private const SESSION_SCAN_KEY = 'analisis_scan_result';

    public function __construct(private readonly SkinAnalysisService $analysisService) {}

    // ═══════════════════════════════════════════════════════════════════
    // STEP 1 ─ Tampilkan form upload foto
    // ═══════════════════════════════════════════════════════════════════

    /**
     * Tampilkan halaman Step 1: upload foto wajah.
     * Session scan lama (jika ada) dibersihkan supaya tidak terbawa ke sesi baru.
     *
     * View: resources/views/analisis/step1.blade.php
     */
    public function index(Request $request)
    {
        // Bersihkan sisa session scan dari sesi analisis sebelumnya
        $request->session()->forget(self::SESSION_SCAN_KEY);

        return view('analisis.step1');
    }

    // ═══════════════════════════════════════════════════════════════════
    // STEP 2 ─ Kirim foto ke Roboflow → simpan session → kuesioner gaya hidup
    // ═══════════════════════════════════════════════════════════════════

    /**
     * Terima foto wajah, panggil analyzeVisual(), simpan hasilnya ke Session,
     * lalu tampilkan Step 2 berisi preview deteksi AI dan kuesioner gaya hidup.
     *
     * Form fields:
     *   - foto_wajah : file (jpg|jpeg|png|webp, max 5MB)
     *
     * Session yang disimpan (SESSION_SCAN_KEY):
     *   [
     *     'temuan'           => [...],   // hasil processPredictions()
     *     'roboflow_success' => bool,
     *     'error_message'    => string|null,
     *   ]
     *
     * View: resources/views/analisis/step2.blade.php
     */
    public function scan(Request $request)
    {
        // ── Validasi foto ────────────────────────────────────────────
        $request->validate([
            'foto_wajah' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'foto_wajah.required' => 'Foto wajah wajib diunggah.',
            'foto_wajah.image'    => 'File yang diunggah harus berupa gambar.',
            'foto_wajah.mimes'    => 'Format foto harus JPG, JPEG, PNG, atau WebP.',
            'foto_wajah.max'      => 'Ukuran foto maksimal 5 MB.',
        ]);

        $imageFile = $request->file('foto_wajah');

        try {
            // ── Panggil analyzeVisual ────────────────────────────────
            $visualResult = $this->analysisService->analyzeVisual($imageFile);

            // ── Buat thumbnail base64 untuk preview di Step 2 ───────
            // Resize ke lebar maks 480px agar tidak bloat session
            $previewBase64 = $this->makePreviewBase64($imageFile->getRealPath());

            // ── Simpan ke Session (diambil lagi di processFinal) ─────
            // Ambil dimensi gambar asli untuk kalkulasi skala bounding box di frontend
            $imageSize = @getimagesize($imageFile->getRealPath());
            $request->session()->put(self::SESSION_SCAN_KEY, [
                'temuan'           => $visualResult['temuan'],
                'roboflow_success' => $visualResult['roboflow_success'],
                'error_message'    => $visualResult['error_message'],
                'preview_base64'   => $previewBase64,
                // LANGKAH 1: Simpan raw_predictions (koordinat bbox) ke session
                'raw_predictions'  => $visualResult['raw_predictions'],
                // Dimensi asli gambar yang dikirim ke Roboflow (untuk skala bbox)
                'img_width'        => $imageSize[0] ?? null,
                'img_height'       => $imageSize[1] ?? null,
            ]);

            // Log ringkasan untuk debugging
            Log::info('[AnalisisController@scan] Scan selesai.', [
                'user_id'          => Auth::id(),
                'roboflow_success' => $visualResult['roboflow_success'],
                'jumlah_temuan'    => count($visualResult['temuan']),
            ]);

            // ── NEW CODE: Resolve SymptomRule kontekstual ────────────
            // Ambil temuan visual yang paling dominan (CF tertinggi, urutan pertama)
            // untuk menentukan pertanyaan anamnesis yang relevan bagi pasien.
            $dynamicSymptoms = collect(); // default: kosong jika tidak ada temuan

            if (! empty($visualResult['temuan'])) {
                $temuanDominan = $visualResult['temuan'][0]; // sudah diurutkan by cf_final DESC

                // Cari KnowledgeBase yang cocok: nama_objek + rentang min/max objek
                $knowledgeBase = KnowledgeBase::where('nama_objek', $temuanDominan['nama_objek'])
                    ->where('min_objek', '<=', $temuanDominan['jumlah'])
                    ->where(function ($q) use ($temuanDominan) {
                        $q->whereNull('max_objek')
                          ->orWhere('max_objek', '>=', $temuanDominan['jumlah']);
                    })
                    ->first();

                if ($knowledgeBase) {
                    // Ambil semua pertanyaan anamnesis terkait KB ini via relasi hasMany
                    $dynamicSymptoms = $knowledgeBase->symptomRules;

                    Log::info('[AnalisisController@scan] SymptomRule ditemukan.', [
                        'knowledge_base_id' => $knowledgeBase->id,
                        'nama_objek'        => $temuanDominan['nama_objek'],
                        'jumlah_pertanyaan' => $dynamicSymptoms->count(),
                    ]);
                } else {
                    Log::info('[AnalisisController@scan] Tidak ada KnowledgeBase matching untuk anamnesis.', [
                        'nama_objek' => $temuanDominan['nama_objek'],
                        'jumlah'     => $temuanDominan['jumlah'],
                    ]);
                }
            }
            // ── END NEW CODE ─────────────────────────────────────────

            // ── Tampilkan Step 2 ─────────────────────────────────────
            return view('analisis.step2', [
                'temuan'           => $visualResult['temuan'],
                'roboflow_success' => $visualResult['roboflow_success'],
                'error_message'    => $visualResult['error_message'],
                'preview_base64'   => $previewBase64,
                'dynamicSymptoms'  => $dynamicSymptoms, // NEW CODE: kirim ke view
            ]);

        } catch (\Throwable $e) {
            Log::error('[AnalisisController@scan] Exception: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
            ]);

            return back()
                ->withInput()
                ->withErrors([
                    'foto_wajah' => 'Gagal memproses foto. Pastikan file tidak rusak dan coba lagi.',
                ]);
        }
    }

    // ═══════════════════════════════════════════════════════════════════
    // STEP 3 ─ Terima gaya hidup → gabungkan CF → simpan → tampilkan hasil
    // ═══════════════════════════════════════════════════════════════════

    /**
     * Terima pilihan gaya hidup dari Step 2, ambil data visual dari Session,
     * gabungkan keduanya menggunakan CF Engine, simpan ke riwayat, tampilkan hasil.
     *
     * Form fields:
     *   - lifestyle[Tidur]          : 'Low'|'Moderate'|'High'
     *   - lifestyle[Stres]          : 'Low'|'Moderate'|'High'
     *   - lifestyle[Air]            : 'Low'|'Moderate'|'High'
     *   - lifestyle[Diet]           : 'Low'|'Moderate'|'High'
     *   - lifestyle[Sinar Matahari] : 'Low'|'Moderate'|'High'
     *
     * View: resources/views/analisis/hasil.blade.php
     */
    public function processFinal(Request $request)
    {
        // ── Guard: pastikan data scan tersedia di Session ────────────
        // NEW CODE: Jika user me-refresh halaman Step 2 langsung, session hilang
        // dan kita redirect aman ke Step 1 agar tidak ada error.
        $scanData = $request->session()->get(self::SESSION_SCAN_KEY);

        if (! $scanData) {
            return redirect()
                ->route('analisis.index')
                ->withErrors(['system' => 'Sesi analisis tidak ditemukan. Silakan mulai ulang dari Step 1.']);
        }

        // ── Validasi input gaya hidup ────────────────────────────────
        $request->validate([
            'lifestyle'                   => 'required|array|min:5',
            'lifestyle.Tidur'             => 'required|string|in:Low,Moderate,High',
            'lifestyle.Stres'             => 'required|string|in:Low,Moderate,High',
            'lifestyle.Air'               => 'required|string|in:Low,Moderate,High',
            'lifestyle.Diet'              => 'required|string|in:Low,Moderate,High',
            'lifestyle.Sinar Matahari'    => 'required|string|in:Low,Moderate,High',
            // NEW CODE: jawaban anamnesis bersifat opsional (0.0–1.0 per pertanyaan)
            // symptom_answers adalah array [symptom_rule_id => cf_user_value]
            'symptom_answers'             => 'nullable|array',
            'symptom_answers.*'           => 'nullable|numeric|min:0|max:1',
        ], [
            'lifestyle.required'   => 'Semua pertanyaan gaya hidup wajib dijawab.',
            'lifestyle.min'        => 'Harap jawab seluruh 5 pertanyaan gaya hidup.',
            'lifestyle.*.required' => 'Pertanyaan ini wajib dijawab.',
            'lifestyle.*.in'       => 'Pilihan tidak valid.',
        ]);

        $lifestyle = $request->input('lifestyle');

        // NEW CODE: Ambil jawaban anamnesis dinamis dari form (nullable)
        $symptomAnswers = $request->input('symptom_answers', []);

        try {
            // ── Hitung CF gaya hidup ─────────────────────────────────
            $lifestyleResult = $this->analysisService->analyzeLifestyle($lifestyle);

            $temuanKlinis = $scanData['temuan'];

            // ════════════════════════════════════════════════════════
            // NEW CODE: Kalkulasi CF Berlapis (3-Tahap)
            //
            // Tahap 1: CF Visual — dari array temuan Roboflow
            $cfVisualList = array_column($temuanKlinis, 'cf_final');
            $cfVisual     = $this->analysisService->calculateFinalCF($cfVisualList);

            // Tahap 2: CF Gejala Dinamis — proses jawaban anamnesis
            // Ambil SymptomRule dari DB (cf_gejala = CF Pakar)
            // lalu hitung CFgejala = CFuser × CFpakar, kombinasi paralel.
            $cfGejala = $this->analysisService->calculateSymptomCF($symptomAnswers);

            // Gabungkan Tahap 1 + Tahap 2 (paralel)
            $cfCombined = $this->analysisService->combineParallel($cfVisual, $cfGejala);

            // ── GANTI DENGAN KODE BARU INI ──────────────────────────
        $cfLifestyleList = array_column($lifestyleResult, 'cf_pakar');

            // Hitung Weighted Average Index untuk Gaya Hidup (Skala Stabil 0.0 - 1.0)
        $indexRisk = !empty($cfLifestyleList) 
        ? array_sum($cfLifestyleList) / count($cfLifestyleList) 
        : 0.0;

    // Konstanta Alpha sebagai Batas Maksimal Pengaruh Faktor Risiko (10%)
        $alpha = 0.10;

    // Rumus Modulasi Akhir: Bukti Klinis diperkuat oleh Indeks Risiko secara terbatas
    $cfFinal = $cfCombined + (($alpha * $indexRisk) * (1.0 - $cfCombined));
    $cfFinal = min(1.0, max(0.0, round($cfFinal, 4)));

    // Set nilai rata-rata ke variabel $cfLifestyle untuk menjaga integritas database
    $cfLifestyle = round($indexRisk, 4);
    // ────────────────────────────────────────────────────────

            Log::info('[AnalisisController@processFinal] CF Breakdown.', [
                'cf_visual'   => $cfVisual,
                'cf_gejala'   => $cfGejala,
                'cf_combined' => $cfCombined,
                'cf_lifestyle'=> $cfLifestyle,
                'cf_final'    => $cfFinal,
            ]);

            // ── Susun data hasil lengkap ─────────────────────────────
            $skorKesehatan  = max(0, round(100 - ($cfFinal * 100)));
            $kondisiLabel   = $this->labelFromScore($skorKesehatan);
            $lifestyleRisiko = array_values(
                array_filter($lifestyleResult, fn($l) => $l['cf_pakar'] > 0.0)
            );

            $hasil = [
                'cf_final'               => $cfFinal,
                'skor_kesehatan'         => $skorKesehatan,
                'kondisi_label'          => $kondisiLabel,
                'temuan_klinis'          => $temuanKlinis,
                'roboflow_success'       => $scanData['roboflow_success'],
                'error_message'          => $scanData['error_message'],
                'lifestyle_detail'       => $lifestyleResult,
                'lifestyle_berisiko'     => $lifestyleRisiko,
                'total_objek_terdeteksi' => array_sum(array_column($temuanKlinis, 'jumlah')),
                'jenis_objek_unik'       => count($temuanKlinis),
                // NEW CODE: simpan breakdown CF untuk keperluan audit/debug
                'cf_breakdown'           => [
                    'visual'    => round($cfVisual, 4),
                    'gejala'    => round($cfGejala, 4),
                    'lifestyle' => round($cfLifestyle, 4),
                ],
                // LANGKAH 1: Teruskan raw_predictions & dimensi gambar ke view & saveHistory
                'raw_predictions'        => $scanData['raw_predictions'] ?? [],
                'img_width'              => $scanData['img_width']  ?? null,
                'img_height'             => $scanData['img_height'] ?? null,
                // Preview foto wajah (base64 thumbnail, disimpan sebelum session dihapus)
                'preview_base64'         => $scanData['preview_base64'] ?? null,
            ];

            // ── NEW CODE: FASE 4 — Resolusi nama objek dominan untuk notes & audit ──
            $namaObjekDominan = ! empty($temuanKlinis)
                ? ($temuanKlinis[0]['nama_objek'] ?? 'Tidak Terdeteksi')
                : 'Tidak Terdeteksi';
            // ─────────────────────────────────────────────────────────────────────

            // ── Simpan ke tabel analysis_histories ───────────────────
            // NEW CODE: FASE 4 — Kirim konteks lengkap ke saveHistory
            $history = $this->saveHistory(
                hasil: $hasil,
                cfBreakdown: [
                    'cf_visual'    => round($cfVisual, 4),
                    'cf_gejala'    => round($cfGejala, 4),
                    'cf_interim'   => round($cfCombined, 4),
                    'cf_lifestyle' => round($cfLifestyle, 4),
                ],
                symptomAnswers: $symptomAnswers,
                lifestyle: $lifestyle,
                namaObjekDominan: $namaObjekDominan,
            );

            // ── Bersihkan session setelah berhasil disimpan ──────────
            $request->session()->forget(self::SESSION_SCAN_KEY);

            Log::info('[AnalisisController@processFinal] Analisis selesai.', [
                'user_id'        => Auth::id(),
                'cf_final'       => $cfFinal,
                'skor_kesehatan' => $skorKesehatan,
                'history_id'     => $history?->id,
            ]);

            return view('analisis.hasil', [
                'hasil'      => $hasil,
                'history_id' => $history?->id,
            ]);

        } catch (\Throwable $e) {
            Log::error('[AnalisisController@processFinal] Exception: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->withErrors([
                    'system' => 'Terjadi kesalahan sistem. Silakan coba lagi.',
                ]);
        }
    }

    // ═══════════════════════════════════════════════════════════════════
    // EXPORT PDF ─ Download rekam medis analisis sebagai PDF
    // ═══════════════════════════════════════════════════════════════════

    /**
     * Generate dan download PDF rekam medis dari hasil analisis.
     * View template: resources/views/analisis/pdf.blade.php (inline CSS only, no Tailwind)
 */
    public function exportPdf(int $id)
    {
        $history = AnalysisHistoryModel::with(['skinProblem', 'user'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $skor  = (int) round(100 - $history->confidence_score);
        $data  = [
            'user'                   => $history->user,
            'history'                => $history,
            'tanggal'                => $history->created_at->locale('id')->isoFormat('D MMMM YYYY'),
            'cf_final'               => round($history->confidence_score / 100, 4),
            'skor_kesehatan'         => $skor,
            'kondisi_label'          => $this->labelFromScore($skor),
            'temuan_klinis'          => $history->analysis_data['temuan_klinis']          ?? [],
            'lifestyle_detail'       => $history->analysis_data['lifestyle_detail']       ?? [],
            'lifestyle_berisiko'     => $history->analysis_data['lifestyle_berisiko']     ?? [],
            'total_objek_terdeteksi' => $history->analysis_data['total_objek_terdeteksi'] ?? 0,
            'generated_at'           => now()->locale('id')->isoFormat('D MMMM YYYY, HH:mm') . ' WIB',
        ];

        $pdf = Pdf::loadView('analisis.pdf', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => false,
                'defaultFont'          => 'sans-serif',
                'dpi'                  => 96,
            ]);

        $filename = 'Rekam_Medis_AI_' . str_replace(' ', '_', $history->user->name) . '_' . $history->created_at->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }

    // ═══════════════════════════════════════════════════════════════════
    // SHOW ─ Tampilkan riwayat analisis tertentu
    // ═══════════════════════════════════════════════════════════════════

    /**
     * Tampilkan detail hasil dari riwayat analisis (by ID).
     * Hanya pemilik riwayat yang dapat mengakses (isolasi per user).
     *
     * View: resources/views/analisis/hasil.blade.php
     */
    public function show(int $id)
    {
        $history = AnalysisHistoryModel::with(['skinProblem'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $skor  = (int) round(100 - $history->confidence_score);
        $hasil = [
            'cf_final'               => round($history->confidence_score / 100, 4),
            'skor_kesehatan'         => $skor,
            'kondisi_label'          => $this->labelFromScore($skor),
            'temuan_klinis'          => $history->analysis_data['temuan_klinis']          ?? [],
            'lifestyle_detail'       => $history->analysis_data['lifestyle_detail']       ?? [],
            'lifestyle_berisiko'     => $history->analysis_data['lifestyle_berisiko']     ?? [],
            'total_objek_terdeteksi' => $history->analysis_data['total_objek_terdeteksi'] ?? 0,
            'jenis_objek_unik'       => $history->analysis_data['jenis_objek_unik']       ?? 0,
            'roboflow_success'       => true,
            'error_message'          => null,
            // NEW CODE: FASE 4 — Restore cf_breakdown dari JSON agar view dapat menampilkan audit trail
            'cf_breakdown'           => $history->analysis_data['breakdown_cf']   ?? [],
            // LANGKAH 1: Restore raw_predictions & dimensi untuk bounding box pada halaman riwayat
            'raw_predictions'        => $history->analysis_data['raw_predictions'] ?? [],
            'img_width'              => $history->analysis_data['img_width']       ?? null,
            'img_height'             => $history->analysis_data['img_height']      ?? null,
        ];

        return view('analisis.hasil', [
            'hasil'      => $hasil,
            'history_id' => $history->id,
        ]);
    }

    // ═══════════════════════════════════════════════════════════════════
    // PRIVATE HELPERS
    // ═══════════════════════════════════════════════════════════════════

    /**
     * Buat thumbnail base64 dari path gambar asli.
     * Resize ke lebar maks 480px menggunakan GD (built-in PHP).
     * Return null jika GD tidak tersedia atau file tidak valid.
     */
    private function makePreviewBase64(string $path): ?string
    {
        if (! function_exists('imagecreatefromstring')) {
            // GD tidak aktif — kembalikan null, view akan tampilkan placeholder
            return null;
        }

        try {
            $raw = file_get_contents($path);
            if ($raw === false) return null;

            $src = imagecreatefromstring($raw);
            if (! $src) return null;

            $origW = imagesx($src);
            $origH = imagesy($src);
            $maxW  = 480;

            if ($origW > $maxW) {
                $newW = $maxW;
                $newH = (int) round(($origH / $origW) * $maxW);
            } else {
                $newW = $origW;
                $newH = $origH;
            }

            $dst = imagecreatetruecolor($newW, $newH);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);

            ob_start();
            imagejpeg($dst, null, 82);
            $jpeg = ob_get_clean();

            imagedestroy($src);
            imagedestroy($dst);

            return 'data:image/jpeg;base64,' . base64_encode($jpeg);

        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * Simpan hasil analisis ke tabel analysis_histories.
     *
     * // NEW CODE: FASE 4 — Menerima parameter tambahan untuk audit trail lengkap:
     * @param  array   $hasil            Array output CF dari processFinal
     * @param  array   $cfBreakdown      Breakdown: cf_visual, cf_gejala, cf_interim, cf_lifestyle
     * @param  array   $symptomAnswers   Jawaban slider anamnesis [id => nilai]
     * @param  array   $lifestyle        Jawaban gaya hidup [kategori => pilihan]
     * @param  string  $namaObjekDominan Nama objek terdeteksi paling dominan
     * @return AnalysisHistoryModel|null
     */
    private function saveHistory(
        array  $hasil,
        array  $cfBreakdown      = [],   // NEW CODE: FASE 4
        array  $symptomAnswers   = [],   // NEW CODE: FASE 4
        array  $lifestyle        = [],   // NEW CODE: FASE 4
        string $namaObjekDominan = '-',  // NEW CODE: FASE 4
    ): ?AnalysisHistoryModel {
        try {
            $problemId = $this->resolveSkinProblemId($hasil);

            return AnalysisHistoryModel::create([
                'user_id'          => Auth::id(),

                // NEW CODE: FASE 4 — analysis_data sekarang menyimpan audit trail lengkap
                'analysis_data' => [
                    // Data klinis utama
                    'temuan_klinis'          => $hasil['temuan_klinis'],
                    'lifestyle_detail'       => $hasil['lifestyle_detail'],
                    'lifestyle_berisiko'     => $hasil['lifestyle_berisiko'],
                    'total_objek_terdeteksi' => $hasil['total_objek_terdeteksi'],
                    'jenis_objek_unik'       => $hasil['jenis_objek_unik'],

                    // NEW CODE: FASE 4 — Audit trail CF Breakdown (3-tahap)
                    'breakdown_cf' => [
                        'cf_visual'    => $cfBreakdown['cf_visual']    ?? 0.0,
                        'cf_gejala'    => $cfBreakdown['cf_gejala']    ?? 0.0,
                        'cf_interim'   => $cfBreakdown['cf_interim']   ?? 0.0,
                        'cf_lifestyle' => $cfBreakdown['cf_lifestyle']  ?? 0.0,
                    ],

                    // NEW CODE: FASE 4 — Simpan input mentah untuk keperluan audit
                    'jawaban_anamnesis' => $symptomAnswers,
                    'jawaban_lifestyle' => $lifestyle,
                    // LANGKAH 1: Simpan raw_predictions ke JSON agar bounding box bisa digambar ulang
                    'raw_predictions'   => $hasil['raw_predictions'] ?? [],
                    'img_width'         => $hasil['img_width']       ?? null,
                    'img_height'        => $hasil['img_height']      ?? null,
                ],

                'result_problem_id'       => $problemId,
                'confidence_score'        => round($hasil['cf_final'] * 100, 2),
                'recommended_ingredients' => [],
                'recommended_products'    => [],
                'recommended_treatments'  => [],

                // NEW CODE: FASE 4 — Notes informatif dengan objek dominan
                'notes' => sprintf(
                    'Analisis Hybrid CF — Objek Dominan: %s | Skor: %d/100 (%s) | CF: Visual=%.2f Gejala=%.2f Lifestyle=%.2f Final=%.2f',
                    $namaObjekDominan,
                    $hasil['skor_kesehatan'],
                    $hasil['kondisi_label'],
                    $cfBreakdown['cf_visual']    ?? 0,
                    $cfBreakdown['cf_gejala']    ?? 0,
                    $cfBreakdown['cf_lifestyle'] ?? 0,
                    $hasil['cf_final'],
                ),
            ]);

        } catch (\Throwable $e) {
            Log::error('[AnalisisController] Gagal menyimpan riwayat: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Tentukan skin_problem_id dari tabel skin_problems berdasarkan skor kesehatan.
     */
    private function resolveSkinProblemId(array $hasil): int
    {
        $skor = $hasil['skor_kesehatan'];

        $severityTarget = match (true) {
            $skor >= 60 => 'ringan',
            $skor >= 30 => 'sedang',
            default     => 'berat',
        };

        $problem = SkinProblemModel::where('severity_level', $severityTarget)->first()
                ?? SkinProblemModel::first();

        return $problem?->id ?? 1;
    }

    /**
     * Konversi skor kesehatan numerik (0–100) ke label teks kondisi.
     */
    private function labelFromScore(int $skor): string
    {
        return match (true) {
            $skor >= 80 => 'Kulit Sehat',
            $skor >= 60 => 'Kondisi Ringan',
            $skor >= 40 => 'Kondisi Sedang',
            $skor >= 20 => 'Kondisi Parah',
            default     => 'Kondisi Sangat Parah',
        };
    }
}
