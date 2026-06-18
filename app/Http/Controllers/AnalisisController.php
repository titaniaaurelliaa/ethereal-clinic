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
 * Alur 3-Tahap Analisis Kulit Hybrid (2-Pilar CF):
 *
 *   STEP 1 ─ GET  /pasien/analisis          → index()        → view analisis.step1
 *             Form upload foto wajah.
 *
 *   STEP 2 ─ POST /pasien/analisis/scan     → scan()         → view analisis.step2
 *             Terima foto → kirim ke Roboflow → simpan temuan di Session
 *             → resolve SymptomRule kontekstual berdasarkan temuan dominan
 *             → tampilkan form anamnesis dinamis.
 *
 *   STEP 3 ─ POST /pasien/analisis/final    → processFinal() → view analisis.hasil
 *             Terima jawaban anamnesis → hitung CF Hybrid 2-Pilar:
 *             CF_Final = CF_Visual + CF_Anamnesis × (1 − CF_Visual)
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
    // STEP 2 ─ Kirim foto ke Roboflow → simpan session → anamnesis klinis
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

            // ── Guard 1: Roboflow Gagal / Timeout ────────────────────
            if (!$visualResult['roboflow_success']) {
                Log::error("[SkinAnalysis] Koneksi ke Roboflow gagal: " . $visualResult['error_message']);
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Koneksi ke server AI gagal atau waktu tunggu habis (Timeout). Silakan pastikan koneksi internet Anda stabil dan coba unggah kembali foto Anda.');
            }

            // ── Guard 2: Roboflow sukses tapi tidak ada objek terdeteksi ──
            // Edge case: foto blur, bukan wajah, atau pencahayaan buruk
            // menyebabkan predictions kosong → CF Visual = 0.0 (invalid)
            if ($visualResult['roboflow_success'] && empty($visualResult['temuan'])) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'foto_wajah' => 'AI tidak mendeteksi adanya komponen jerawat atau komedo pada foto Anda. '
                                      . 'Pastikan foto wajah diambil secara tegak lurus, pencahayaan cukup, '
                                      . 'wajah terlihat jelas, dan gambar tidak blur.',
                    ]);
            }

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

            // ── Resolve SymptomRule kontekstual untuk SEMUA temuan ───
            // Iterasi seluruh temuan visual (bukan hanya item dominan ke-0)
            // agar pertanyaan anamnesis mencakup semua kondisi yang terdeteksi.
            $dynamicSymptoms = collect(); // default: kosong jika tidak ada temuan

            if (! empty($visualResult['temuan'])) {
                foreach ($visualResult['temuan'] as $temuan) {
                    // Cari KnowledgeBase yang cocok: nama_objek + rentang min/max objek
                    $knowledgeBase = KnowledgeBase::where('nama_objek', $temuan['nama_objek'])
                        ->where('min_objek', '<=', $temuan['jumlah'])
                        ->where(function ($q) use ($temuan) {
                            $q->whereNull('max_objek')
                              ->orWhere('max_objek', '>=', $temuan['jumlah']);
                        })
                        ->first();

                    if ($knowledgeBase) {
                        // Gabungkan pertanyaan anamnesis dari KB ini ke koleksi utama
                        $dynamicSymptoms = $dynamicSymptoms->merge($knowledgeBase->symptomRules);

                        Log::info('[AnalisisController@scan] SymptomRule ditemukan.', [
                            'knowledge_base_id' => $knowledgeBase->id,
                            'nama_objek'        => $temuan['nama_objek'],
                            'jumlah_pertanyaan' => $knowledgeBase->symptomRules->count(),
                            'total_kumulatif'   => $dynamicSymptoms->count(),
                        ]);
                    } else {
                        Log::info('[AnalisisController@scan] Tidak ada KnowledgeBase matching untuk anamnesis.', [
                            'nama_objek' => $temuan['nama_objek'],
                            'jumlah'     => $temuan['jumlah'],
                        ]);
                    }
                }
            }
            // ── END: Resolve SymptomRule kontekstual ─────────────────

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
    // STEP 3 ─ Terima anamnesis → CF Hybrid 2-Pilar → simpan → tampilkan
    // ═══════════════════════════════════════════════════════════════════

    /**
     * Terima jawaban anamnesis dari Step 2, ambil data visual dari Session,
     * gabungkan menggunakan CF Hybrid 2-Pilar, simpan ke riwayat, tampilkan hasil.
     *
     * Formula: CF_Final = CF_Visual + CF_Anamnesis × (1 − CF_Visual)
     *
     * Form fields:
     *   - symptom_answers : array [symptom_rule_id => nilai (0.0–1.0)]
     *
     * View: resources/views/analisis/hasil.blade.php
     */
    public function processFinal(Request $request)
    {
        // ── Guard: pastikan data scan tersedia di Session ────────────
        $scanData = $request->session()->get(self::SESSION_SCAN_KEY);

        if (! $scanData) {
            return redirect()
                ->route('analisis.index')
                ->withErrors(['system' => 'Sesi analisis tidak ditemukan. Silakan mulai ulang dari Step 1.']);
        }

        // ── Validasi input anamnesis ─────────────────────────────────
        $request->validate([
            'symptom_answers'   => 'nullable|array',
            'symptom_answers.*' => 'nullable|numeric|min:0|max:1',
        ]);

        // NEW CODE: Ambil jawaban anamnesis dinamis dari form (nullable)
        $symptomAnswers = $request->input('symptom_answers', []);

        try {
            $temuanKlinis = $scanData['temuan'];

            // ════════════════════════════════════════════════════════
            // Kalkulasi CF via Hybrid Multi-Diagnosis Engine
            // Menghitung CF final per klaster penyakit secara paralel
            // ════════════════════════════════════════════════════════
            $multiDiagnosis = $this->analysisService->calculateMultiHybridCF(
                $symptomAnswers,
                $temuanKlinis
            );

            // ── Ambil diagnosis dominan (CF tertinggi, posisi [0]) ───
            // Engine sudah mengurutkan dari cf_final terbesar ke terkecil
            $dominan = $multiDiagnosis[0] ?? [
                'nama_objek' => 'Tidak Terdeteksi',
                'cf_visual'  => 0.0,
                'cf_gejala'  => 0.0,
                'cf_final'   => 0.0,
                'persentase' => '0%',
            ];

            $cfFinal = (float) $dominan['cf_final'];

            Log::info('[AnalisisController@processFinal] Multi-Hybrid CF selesai.', [
                'jumlah_diagnosis' => count($multiDiagnosis),
                'dominan'          => $dominan['nama_objek'],
                'cf_final'         => $cfFinal,
            ]);

            // ── Susun data hasil lengkap ─────────────────────────────
            $skorKesehatan = max(0, round(100 - ($cfFinal * 100)));
            $kondisiLabel  = $this->labelFromScore($skorKesehatan);

            $hasil = [
                'cf_final'               => $cfFinal,
                'skor_kesehatan'         => $skorKesehatan,
                'kondisi_label'          => $kondisiLabel,
                'temuan_klinis'          => $temuanKlinis,
                'roboflow_success'       => $scanData['roboflow_success'],
                'error_message'          => $scanData['error_message'],
                'total_objek_terdeteksi' => array_sum(array_column($temuanKlinis, 'jumlah')),
                'jenis_objek_unik'       => count($temuanKlinis),
                // CF Breakdown per klaster penyakit (multi-diagnosis utuh)
                'cf_breakdown'           => [
                    'cf_visual'  => round($dominan['cf_visual'], 4),
                    'cf_gejala'  => round($dominan['cf_gejala'], 4),
                ],
                // Seluruh array multi-diagnosis untuk rekam medis lengkap
                'multi_diagnosis'        => $multiDiagnosis,
                // Raw predictions & dimensi gambar untuk bounding box overlay
                'raw_predictions'        => $scanData['raw_predictions'] ?? [],
                'img_width'              => $scanData['img_width']  ?? null,
                'img_height'             => $scanData['img_height'] ?? null,
                // Preview foto wajah (base64 thumbnail)
                'preview_base64'         => $scanData['preview_base64'] ?? null,
            ];

            // ── Nama objek dominan dari hasil engine ─────────────────
            $namaObjekDominan = $dominan['nama_objek'];

            // ── Simpan ke tabel analysis_histories ───────────────────
            $history = $this->saveHistory(
                hasil: $hasil,
                cfBreakdown: [
                    'cf_visual' => round($dominan['cf_visual'], 4),
                    'cf_gejala' => round($dominan['cf_gejala'], 4),
                ],
                symptomAnswers: $symptomAnswers,
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
                'history'    => $history,
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
        // FIX BUG-02: Menggunakan firstOrFail() agar tidak crash 500 jika ID tidak valid
        $history = AnalysisHistoryModel::with(['skinProblem', 'user'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->latest()
            ->firstOrFail();

        $skor  = (int) round(100 - $history->confidence_score);
        
        // Memastikan format data array jika seandainya belum di-cast otomatis oleh model
        $recProducts   = is_string($history->recommended_products) ? json_decode($history->recommended_products, true) : ($history->recommended_products ?? []);
        $recTreatments = is_string($history->recommended_treatments) ? json_decode($history->recommended_treatments, true) : ($history->recommended_treatments ?? []);

        $data  = [
            'user'                   => $history->user,
            'history'                => $history,
            'tanggal'                => $history->created_at->locale('id')->isoFormat('D MMMM YYYY'),
            'cf_final'               => round($history->confidence_score / 100, 4),
            'skor_kesehatan'         => $skor,
            'kondisi_label'          => $this->labelFromScore($skor),
            'temuan_klinis'          => $history->analysis_data['temuan_klinis']          ?? [],
            'total_objek_terdeteksi' => $history->analysis_data['total_objek_terdeteksi'] ?? 0,
            
            // DATA BARU: Passing data rekomendasi untuk tabel di PDF
            'recProducts'            => $recProducts,
            'recTreatments'          => $recTreatments,
            
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

        $filename = 'Rekam_Medis_AI_' . str_replace(' ', '_', $history->user->name) . '_' . $history->created_at->format('Ymd') . '_' . $history->id . '.pdf';

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
            'total_objek_terdeteksi' => $history->analysis_data['total_objek_terdeteksi'] ?? 0,
            'jenis_objek_unik'       => $history->analysis_data['jenis_objek_unik']       ?? 0,
            'roboflow_success'       => true,
            'error_message'          => null,
            // Restore cf_breakdown dari JSON untuk audit trail
            'cf_breakdown'           => $history->analysis_data['breakdown_cf']   ?? [],
            // Restore raw_predictions & dimensi untuk bounding box overlay
            'raw_predictions'        => $history->analysis_data['raw_predictions'] ?? [],
            'img_width'              => $history->analysis_data['img_width']       ?? null,
            'img_height'             => $history->analysis_data['img_height']      ?? null,
        ];

        return view('analisis.hasil', [
            'hasil'      => $hasil,
            'history_id' => $history->id,
            'history'    => $history,
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
     * Simpan hasil analisis ke tabel analysis_histories beserta data rekomendasi.
     *
     * @param  array   $hasil            Array output CF dari processFinal
     * @param  array   $cfBreakdown      Breakdown: cf_visual, cf_gejala
     * @param  array   $symptomAnswers   Jawaban slider anamnesis [id => nilai]
     * @param  string  $namaObjekDominan Nama objek terdeteksi paling dominan
     * @return AnalysisHistoryModel|null
     */
    private function saveHistory(
        array  $hasil,
        array  $cfBreakdown      = [],
        array  $symptomAnswers   = [],
        string $namaObjekDominan = '-',
    ): ?AnalysisHistoryModel {
        try {
            // 1. Inisialisasi variabel untuk menampung resep obat & diagnosis
            $resultProblemId = null;
            $recommendedProducts = [];
            $recommendedTreatments = [];

            // 2. Ambil ID Knowledge Base (Penyakit) dari temuan visual yang dominan
            // Karena $hasil['temuan_klinis'] sudah diurutkan dari yang terparah
            if (!empty($hasil['temuan_klinis'])) {
                $temuanDominan = $hasil['temuan_klinis'][0];
                
                // Cari relasi lengkap menggunakan Eager Loading
                $kb = KnowledgeBase::with('skinProblem.products', 'skinProblem.treatments')
                    ->where('nama_objek', $temuanDominan['nama_objek'])
                    ->where('min_objek', '<=', $temuanDominan['jumlah'])
                    ->where(function ($q) use ($temuanDominan) {
                        $q->whereNull('max_objek')
                          ->orWhere('max_objek', '>=', $temuanDominan['jumlah']);
                    })
                    ->first();

                // 3. Format Data Obat dan Treatment jika Penyakit Ditemukan
                if ($kb && $kb->skinProblem) {
                    $resultProblemId = $kb->skinProblem->id;
                    
                    // Tarik resep obat
                    $recommendedProducts = $kb->skinProblem->products->map(function($item) {
                        return [
                            'id' => $item->id,
                            'nama_produk' => $item->name,
                            'kandungan' => $item->description, // Sesuaikan dengan kolom tabel products jika beda
                            'image_path'  => $item->image_path ?? null, // Pastikan kolom image_path ada di tabel products
                        ];
                    })->toArray();

                    // Tarik resep tindakan klinik
                    $recommendedTreatments = $kb->skinProblem->treatments->map(function($item) {
                        return [
                            'id' => $item->id,
                            'nama_treatment' => $item->name,
                            'deskripsi' => $item->description ?? null,
                            'estimasi_harga' => $item->price ?? null // Sesuaikan dengan kolom harga jika ada
                        ];
                    })->toArray();
                }
            }

            // 4. Simpan ke database beserta Resep yang Ditemukan
            return AnalysisHistoryModel::create([
                'user_id' => Auth::id(),

                'analysis_data' => [
                    'temuan_klinis'          => $hasil['temuan_klinis'],
                    'total_objek_terdeteksi' => $hasil['total_objek_terdeteksi'],
                    'jenis_objek_unik'       => $hasil['jenis_objek_unik'],
                    'breakdown_cf' => [
                        'cf_visual' => $cfBreakdown['cf_visual'] ?? 0.0,
                        'cf_gejala' => $cfBreakdown['cf_gejala'] ?? 0.0,
                    ],
                    // Rekam medis multi-diagnosis lengkap (seluruh klaster penyakit)
                    'multi_diagnosis'   => $hasil['multi_diagnosis'] ?? [],
                    'jawaban_anamnesis' => $symptomAnswers,
                    'raw_predictions'   => $hasil['raw_predictions'] ?? [],
                    'img_width'         => $hasil['img_width']       ?? null,
                    'img_height'        => $hasil['img_height']      ?? null,
                ],

                // 5. Masukkan ID Penyakit Asli & Data Resep
                'result_problem_id'       => $resultProblemId ?? (SkinProblemModel::first()?->id ?? 1),
                'confidence_score'        => round($hasil['cf_final'] * 100, 2),
                'recommended_ingredients' => [],
                'recommended_products'    => $recommendedProducts,
                'recommended_treatments'  => $recommendedTreatments,

                'notes' => sprintf(
                    'Multi-Hybrid CF Engine — Dominan: %s | Skor: %d/100 (%s) | CF: Visual=%.4f Gejala=%.4f Final=%.4f | Diagnosis: %d klaster',
                    $namaObjekDominan,
                    $hasil['skor_kesehatan'],
                    $hasil['kondisi_label'],
                    $cfBreakdown['cf_visual'] ?? 0,
                    $cfBreakdown['cf_gejala'] ?? 0,
                    $hasil['cf_final'],
                    count($hasil['multi_diagnosis'] ?? []),
                ),
            ]);

        } catch (\Throwable $e) {
            Log::error('[AnalisisController] Gagal menyimpan riwayat: ' . $e->getMessage());
            return null;
        }
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
