<?php

namespace App\Services;

use App\Models\KnowledgeBase;
use App\Models\LifestyleRule;
use App\Models\SymptomRule;             // NEW CODE: untuk kalkulasi CF gejala dinamis
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

/**
 * SkinAnalysisService
 *
 * Implementasi mesin Certainty Factor (CF) Hybrid untuk analisis kulit wajah.
 *
 * Alur kerja:
 *   1. analyzeVisual()    → Kirim gambar ke Roboflow → hitung CF visual per objek
 *   2. analyzeLifestyle() → Baca pilihan gaya hidup → ambil CF dari lifestyle_rules
 *   3. calculateFinalCF() → Gabungkan semua CF dengan rumus kombinasi CF klasik
 *   4. buildResult()      → Bangun output terstruktur untuk view
 *
 * Rumus CF Kombinasi:
 *   CF_combine = CF_old + CF_new × (1 − CF_old)
 *
 * Rumus CF per Temuan Visual:
 *   CF(H,E) = CF_pakar × avg_confidence_roboflow
 */
class SkinAnalysisService
{
    /** Endpoint dasar Roboflow Inference API */
    private const ROBOFLOW_BASE_URL = 'https://detect.roboflow.com';

    /**
     * Peta kelas label Roboflow → nama_objek di tabel knowledge_bases.
     * Kunci: label lowercase dari response Roboflow.
     * Nilai: nama_objek yang tersimpan di knowledge_bases.
     */
    private const CLASS_MAP = [
        'pustules'   => 'Jerawat',
        'pustule'    => 'Jerawat',
        'papules'    => 'Jerawat',
        'papule'     => 'Jerawat',
        'nodules'    => 'Kista',
        'nodule'     => 'Kista',
        'cysts'      => 'Kista',
        'cyst'       => 'Kista',
        'blackhead'  => 'Komedo Hitam',
        'blackheads' => 'Komedo Hitam',
        'whitehead'  => 'Komedo Putih',
        'whiteheads' => 'Komedo Putih',
        'comedone'   => 'Komedo Putih',
        'comedones'  => 'Komedo Putih',
        'acne'       => 'Jerawat',
        'pimple'     => 'Jerawat',
        'pimples'    => 'Jerawat',
        'dark_spot'  => 'Bekas Jerawat',
        'dark_spots' => 'Bekas Jerawat',
        'scar'       => 'Bekas Jerawat',
        'scars'      => 'Bekas Jerawat',
    ];

    private Client $http;
    private string $apiKey;
    private string $modelId;

    public function __construct()
    {
        $this->apiKey  = config('services.roboflow.api_key',  env('ROBOFLOW_API_KEY'));
        $this->modelId = config('services.roboflow.model_id', env('ROBOFLOW_MODEL_ID'));

        $this->http = new Client([
            'base_uri' => self::ROBOFLOW_BASE_URL,
            'timeout'  => 30,
            'connect_timeout' => 10,
        ]);
    }

    // ═══════════════════════════════════════════════════════════════
    // PUBLIC API
    // ═══════════════════════════════════════════════════════════════

    /**
     * Analisis lengkap: visual + gaya hidup → hasil hybrid CF.
     *
     * @param  UploadedFile  $image      File foto dari request
     * @param  array         $lifestyle  Array ['kategori' => 'pilihan', ...]
     * @return array
     */
   public function analyze(UploadedFile $image, array $lifestyle): array
    {
        // 1. Analisis visual via Roboflow (Ambil nilai CF visual murni)
        $visualResult = $this->analyzeVisual($image);
        $cfVisualList = array_column($visualResult['temuan'], 'cf_final');
        $cfVisual     = $this->calculateFinalCF($cfVisualList);

        // 2. Hitung CF gaya hidup dan konversi ke Indeks Rata-rata Risiko
        $lifestyleResult = $this->analyzeLifestyle($lifestyle);
        $cfLifestyleList = array_column($lifestyleResult, 'cf_pakar');
        
        $indexRisk = !empty($cfLifestyleList) 
            ? array_sum($cfLifestyleList) / count($cfLifestyleList) 
            : 0.0;

        // 3. Modulasi Akhir dengan Konstanta Alpha (Standar Jurnal: Maksimal Pengaruh Risiko 10%)
        $alpha = 0.10;
        $cfFinal = $cfVisual + (($alpha * $indexRisk) * (1.0 - $cfVisual));
        
        // Pastikan nilai akhir tidak keluar dari rentang 0.0 - 1.0 dan dibulatkan 4 desimal
        $cfFinal = min(1.0, max(0.0, round($cfFinal, 4)));

        // 4. Bangun output terstruktur
        return $this->buildResult($visualResult, $lifestyleResult, $cfFinal);
    }

    /**
     * Kirim gambar ke Roboflow dan hitung CF visual per jenis objek.
     *
     * @param  UploadedFile $image
     * @return array{
     *   temuan: array,
     *   raw_predictions: array,
     *   roboflow_success: bool,
     *   error_message: string|null
     * }
     * @throws \RuntimeException jika Roboflow gagal dan tidak ada fallback
     */
    public function analyzeVisual(UploadedFile $image): array
    {
        // Encode gambar ke base64
        $imageBase64 = base64_encode(file_get_contents($image->getRealPath()));

        try {
            $response = $this->http->post("/{$this->modelId}", [
                'query'   => ['api_key' => $this->apiKey],
                'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
                'body'    => $imageBase64,
            ]);

            $raw = json_decode($response->getBody()->getContents(), true);

            if (! isset($raw['predictions'])) {
                throw new \RuntimeException('Response Roboflow tidak mengandung field "predictions".');
            }

            $temuan = $this->processPredictions($raw['predictions']);

            return [
                'temuan'           => $temuan,
                'raw_predictions'  => $raw['predictions'],
                'roboflow_success' => true,
                'error_message'    => null,
            ];

        } catch (ConnectException $e) {
            Log::error('[SkinAnalysis] Koneksi ke Roboflow gagal: ' . $e->getMessage());

            return [
                'temuan'           => [],
                'raw_predictions'  => [],
                'roboflow_success' => false,
                'error_message'    => 'Koneksi ke server AI gagal. Pastikan koneksi internet aktif.',
            ];

        } catch (RequestException $e) {
            $statusCode = $e->hasResponse() ? $e->getResponse()->getStatusCode() : 0;
            $body       = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : '';

            Log::error("[SkinAnalysis] Roboflow HTTP {$statusCode}: {$body}");

            return [
                'temuan'           => [],
                'raw_predictions'  => [],
                'roboflow_success' => false,
                'error_message'    => "API Roboflow merespons dengan kode error {$statusCode}. Coba lagi beberapa saat.",
            ];

        } catch (\Throwable $e) {
            Log::error('[SkinAnalysis] Error tidak terduga: ' . $e->getMessage());

            return [
                'temuan'           => [],
                'raw_predictions'  => [],
                'roboflow_success' => false,
                'error_message'    => 'Terjadi kesalahan sistem. Silakan coba lagi.',
            ];
        }
    }

    /**
     * Hitung CF gaya hidup berdasarkan input form pengguna.
     *
     * @param  array $lifestyle  Contoh: ['Tidur' => 'Low', 'Stres' => 'High', ...]
     * @return array             Array of ['kategori', 'pilihan', 'label', 'cf_pakar']
     */
    public function analyzeLifestyle(array $lifestyle): array
    {
        $result = [];

        foreach ($lifestyle as $kategori => $pilihan) {
            if (blank($pilihan)) {
                continue;
            }

            $rule = LifestyleRule::findRule($kategori, $pilihan);

            if ($rule) {
                $result[] = [
                    'kategori' => $rule->kategori,
                    'pilihan'  => $rule->pilihan,
                    'label'    => $rule->label,
                    'cf_pakar' => $rule->cf_pakar,
                ];
            }
        }

        return $result;
    }

    /**
     * Gabungkan daftar nilai CF menggunakan rumus kombinasi CF klasik:
     *   CF_combine = CF_old + CF_new × (1 − CF_old)
     *
     * @param  float[] $cfList  Daftar nilai CF (0.0 – 1.0)
     * @return float            CF gabungan akhir
     */
    public function calculateFinalCF(array $cfList): float
    {
        // Saring nilai 0 agar tidak mengisi slot CF tanpa kontribusi nyata
        $cfList = array_filter($cfList, fn($cf) => $cf > 0.0);

        if (empty($cfList)) {
            return 0.0;
        }

        $cfCombined = 0.0;

        foreach ($cfList as $cf) {
            $cfCombined = $cfCombined + ($cf * (1 - $cfCombined));
        }

        // Clamp ke rentang [0, 1]
        return min(1.0, max(0.0, round($cfCombined, 4)));
    }

    // ═══════════════════════════════════════════════════════════════
    // NEW CODE: Metode Anamnesis Kontekstual (Fase 3)
    // ═══════════════════════════════════════════════════════════════

    /**
     * Hitung CF gabungan dari jawaban anamnesis dinamis pasien.
     *
     * Algoritma per gejala:
     *   CF_gejala = CF_user × CF_pakar
     *   (CF_user  = jawaban pasien dari slider form, nilai 0.0 – 1.0)
     *   (CF_pakar = cf_gejala yang tersimpan di tabel symptom_rules)
     *
     * Seluruh nilai CF_gejala kemudian dikombinasikan secara paralel:
     *   CF_combine = CF_lama + CF_baru × (1 − CF_lama)
     *
     * @param  array<int|string, float|null>  $symptomAnswers
     *         Array [symptom_rule_id => cf_user_value] dari form.
     *         Nilai null / 0 diabaikan (pertanyaan tidak dijawab).
     * @return float  CF gabungan gejala (0.0 – 1.0)
     */
    // NEW CODE:
    public function calculateSymptomCF(array $symptomAnswers): float
    {
        if (empty($symptomAnswers)) {
            return 0.0;
        }

        // Kumpulkan hanya ID yang memiliki nilai jawaban valid (> 0)
        $validIds = array_keys(array_filter(
            $symptomAnswers,
            fn($v) => is_numeric($v) && (float) $v > 0.0
        ));

        if (empty($validIds)) {
            return 0.0;
        }

        // NEW CODE: Ambil CF Pakar dari database sekaligus untuk semua ID
        $rules = SymptomRule::whereIn('id', $validIds)
                            ->pluck('cf_pakar', 'id');

        $cfCombined = 0.0;

        foreach ($validIds as $id) {
            // Pastikan rule-nya ada di DB (hindari injeksi ID palsu)
            if (! isset($rules[$id])) {
                Log::warning("[SkinAnalysis] SymptomRule ID={$id} tidak ditemukan di DB, dilewati.");
                continue;
            }

            // NEW CODE: Rumus dasar gejala
            $cfUser  = min(1.0, max(0.0, (float) $symptomAnswers[$id]));
            $cfPakar = (float) $rules[$id];
            $cfGejala = $cfUser * $cfPakar;

            if ($cfGejala <= 0.0) {
                continue;
            }

            // NEW CODE: Rumus kombinasi paralel
            $cfCombined = $cfCombined + ($cfGejala * (1.0 - $cfCombined));

            Log::debug("[SkinAnalysis] SymptomRule ID={$id}: CFuser={$cfUser}, CFpakar={$cfPakar}, CFgejala={$cfGejala}, combined={$cfCombined}");
        }

        return min(1.0, max(0.0, round($cfCombined, 4)));
    }

    /**
     * Kombinasikan dua nilai CF menggunakan rumus paralel:
     *   CF_result = CF_a + CF_b × (1 − CF_a)
     *
     * Digunakan untuk menggabungkan antar-tahap (Visual → Gejala → Lifestyle).
     *
     * @param  float $cfA  CF kiri (Tahap N)
     * @param  float $cfB  CF kanan (Tahap N+1)
     * @return float
     */
    // NEW CODE:
    public function combineParallel(float $cfA, float $cfB): float
    {
        if ($cfA <= 0.0 && $cfB <= 0.0) {
            return 0.0;
        }

        $result = $cfA + ($cfB * (1.0 - $cfA));

        return min(1.0, max(0.0, round($result, 4)));
    }

    // ═══════════════════════════════════════════════════════════════
    // Hybrid Multi-Diagnosis Certainty Factor Engine
    // ═══════════════════════════════════════════════════════════════

    /**
     * Mesin kalkulasi CF Hybrid Multi-Diagnosis.
     *
     * Menghitung CF final PER KLASTER PENYAKIT dengan menggabungkan dua pilar:
     *   Pilar 1 — CF Visual  : confidence Roboflow × cf_pakar dari KnowledgeBase
     *   Pilar 2 — CF Gejala  : jawaban anamnesis × cf_pakar dari SymptomRule
     *
     * Rumus Kombinasi Paralel Gejala (intra-klaster):
     *   CF_combine = CF_old + CF_new × (1 − CF_old)
     *
     * Rumus Fusi Hybrid (inter-pilar):
     *   CF_final = CF_visual + CF_combine × (1 − CF_visual)
     *
     * @param  array<int|string, float|null>  $answers        [symptom_rule_id => user_value] dari form kuesioner
     * @param  array<int, array{nama_objek: string, confidence: float, jumlah: int}>  $visualResults  Temuan multi-objek Roboflow
     * @return array<int, array{nama_objek: string, cf_visual: float, cf_gejala: float, cf_final: float, persentase: string}>
     */
    public function calculateMultiHybridCF(array $answers, array $visualResults): array
    {
        // ══════════════════════════════════════════════════════════════
        // TAHAP 1 — Filtering: Saring jawaban valid (non-null, >= 0)
        // ══════════════════════════════════════════════════════════════
        $validAnswers = array_filter(
            $answers,
            fn($v) => !is_null($v) && is_numeric($v) && floatval($v) >= 0
        );

        // ══════════════════════════════════════════════════════════════
        // TAHAP 2 — Eager Loading (Anti N+1 Query)
        // Ambil SymptomRule beserta relasi KnowledgeBase sekaligus
        // ══════════════════════════════════════════════════════════════
        $ruleIds = array_keys($validAnswers);
        $rules   = collect();

        if (!empty($ruleIds)) {
            $rules = SymptomRule::with('knowledgeBase')
                ->whereIn('id', $ruleIds)
                ->get();
        }

        // ══════════════════════════════════════════════════════════════
        // TAHAP 3 — Isolasi & Klasterisasi Penyakit (Disease Isolation)
        // Kelompokkan setiap gejala ke klaster penyakit induknya
        // berdasarkan relasi SymptomRule → KnowledgeBase → nama_objek
        // ══════════════════════════════════════════════════════════════
        $groupedCalculations = [];

        foreach ($rules as $rule) {
            // Guard: lewati jika relasi KnowledgeBase putus
            if (!$rule->knowledgeBase) {
                Log::warning("[SkinAnalysis] SymptomRule ID={$rule->id} tidak memiliki relasi KnowledgeBase, dilewati.");
                continue;
            }

            $namaObjek = $rule->knowledgeBase->nama_objek;

            // Inisialisasi klaster baru jika belum ada
            if (!isset($groupedCalculations[$namaObjek])) {
                $groupedCalculations[$namaObjek] = [
                    'nama_objek' => $namaObjek,
                    'symptoms'   => [],
                    'cf_visual'  => 0.0,
                ];
            }

            // Hitung CF Gejala Tunggal: CF_user × CF_pakar
            $cfUser          = min(1.0, max(0.0, floatval($validAnswers[$rule->id])));
            $cfPakarGejala   = floatval($rule->cf_pakar);
            $cfGejalaTunggal = $cfUser * $cfPakarGejala;

            if ($cfGejalaTunggal > 0.0) {
                $groupedCalculations[$namaObjek]['symptoms'][] = $cfGejalaTunggal;
            }
        }

        // ══════════════════════════════════════════════════════════════
        // TAHAP 4 — Kalibrasi Visual Dinamis ($CF_visual)
        // Ambil cf_pakar visual dari database via KnowledgeBase::findRule()
        // bukan menggunakan konstanta statis 0.6
        // ══════════════════════════════════════════════════════════════
        foreach ($visualResults as $visual) {
            $namaObjek = $visual['nama_objek'] ?? '';

            if (empty($namaObjek)) {
                continue;
            }

            // Inisialisasi klaster jika belum ada (kondisi: visual ada tapi tanpa gejala)
            if (!isset($groupedCalculations[$namaObjek])) {
                $groupedCalculations[$namaObjek] = [
                    'nama_objek' => $namaObjek,
                    'symptoms'   => [],
                    'cf_visual'  => 0.0,
                ];
            }

           // Resolve cf_pakar visual secara dinamis dari database
        $kbRule        = KnowledgeBase::findRule($namaObjek, intval($visual['jumlah']));
        $cfPakarVisual = $kbRule ? floatval($kbRule->cf_pakar) : 0.6;

        //PERBAIKAN DI SINI: Ambil skor secara dinamis (antisipasi key avg_confidence atau confidence)
        $confidenceScore = floatval($visual['avg_confidence'] ?? $visual['confidence'] ?? 0.0);

        // CF_visual = confidence_score × cf_pakar_visual_dari_db
        $cfVisual = $confidenceScore * $cfPakarVisual;
        $groupedCalculations[$namaObjek]['cf_visual'] = round($cfVisual, 4);
        }

        // ══════════════════════════════════════════════════════════════
        // TAHAP 5 — Core Math Engine (per Klaster Penyakit)
        // ══════════════════════════════════════════════════════════════
        $results = [];

        foreach ($groupedCalculations as $namaObjek => $cluster) {
            // ── A. Akumulasi Kombinasi Gejala Paralel ────────────────
            // CF_combine = CF_old + CF_new × (1 − CF_old)
            $cfCombine = 0.0;

            foreach ($cluster['symptoms'] as $cfGejala) {
                $cfCombine = $cfCombine + ($cfGejala * (1.0 - $cfCombine));
            }

            $cfCombine = round($cfCombine, 4);

            // ── B. Fusi Hybrid Visual + Gejala ───────────────────────
            // CF_final = CF_visual + CF_combine × (1 − CF_visual)
            $cfVisual = $cluster['cf_visual'];
            $cfFinal  = $cfVisual + ($cfCombine * (1.0 - $cfVisual));
            $cfFinal  = min(1.0, max(0.0, round($cfFinal, 4)));

            // ── TAHAP 6 — Standarisasi Format Output ─────────────────
            $results[] = [
                'nama_objek' => $namaObjek,
                'cf_visual'  => round($cfVisual, 4),
                'cf_gejala'  => $cfCombine,
                'cf_final'   => $cfFinal,
                'persentase' => round($cfFinal * 100, 1) . '%',
            ];

            // ── TAHAP 7 — Audit Trail Logging ────────────────────────
            Log::info("[SkinAnalysis] Multi-Hybrid CF — Klaster: {$namaObjek}", [
                'cf_visual'         => round($cfVisual, 4),
                'cf_gejala_combine' => $cfCombine,
                'cf_final'          => $cfFinal,
                'persentase'        => round($cfFinal * 100, 1) . '%',
                'jumlah_gejala'     => count($cluster['symptoms']),
                'detail_cf_gejala'  => $cluster['symptoms'],
            ]);
        }

        // Urutkan: CF_final tertinggi di posisi pertama (diagnosis paling kuat)
        usort($results, fn($a, $b) => $b['cf_final'] <=> $a['cf_final']);

        return $results;
    }

    // ═══════════════════════════════════════════════════════════════
    // PRIVATE HELPERS
    // ═══════════════════════════════════════════════════════════════

    /**
     * Proses array predictions dari Roboflow menjadi temuan klinis terstruktur.
     * Setiap prediksi dikelompokkan per nama_objek, lalu dicari rule KB-nya.
     *
     * CF per temuan = CF_pakar × rata-rata confidence Roboflow
     */
    private function processPredictions(array $predictions): array
    {
        // ── Kelompokkan prediksi per nama_objek ─────────────────────
        $grouped = [];

        foreach ($predictions as $pred) {
            $classRaw  = strtolower($pred['class'] ?? '');
            $namaObjek = self::CLASS_MAP[$classRaw] ?? null;

            if (! $namaObjek) {
                // Label tidak dikenal → log dan lewati
                Log::debug("[SkinAnalysis] Label tidak dikenal: '{$classRaw}'");
                continue;
            }

            if (! isset($grouped[$namaObjek])) {
                $grouped[$namaObjek] = ['count' => 0, 'confidences' => []];
            }

            $grouped[$namaObjek]['count']++;
            $grouped[$namaObjek]['confidences'][] = (float) ($pred['confidence'] ?? 0.0);
        }

        // ── Hitung CF per kelompok ───────────────────────────────────
        $temuan = [];

        foreach ($grouped as $namaObjek => $data) {
            $jumlah       = $data['count'];
            $avgConfidence = ! empty($data['confidences'])
                ? array_sum($data['confidences']) / count($data['confidences'])
                : 0.0;

            // Cari rule KB yang cocok berdasarkan jumlah
            $rule = KnowledgeBase::findRule($namaObjek, $jumlah);

            if (! $rule) {
                // Tidak ada rule → gunakan CF minimal
                Log::warning("[SkinAnalysis] Tidak ada rule KB untuk '{$namaObjek}' jumlah={$jumlah}");
                continue;
            }

            // CF(H,E) = CF_pakar × avg_confidence
            $cfFinal = round($rule->cf_pakar * $avgConfidence, 4);

            $temuan[] = [
                'nama_objek'        => $namaObjek,
                'jumlah'            => $jumlah,
                'avg_confidence'    => round($avgConfidence, 4),
                'tingkat_keparahan' => $rule->tingkat_keparahan,
                'cf_pakar'          => $rule->cf_pakar,
                'cf_final'          => $cfFinal,
            ];
        }

        // Urutkan: CF tertinggi di atas (temuan paling dominan)
        usort($temuan, fn($a, $b) => $b['cf_final'] <=> $a['cf_final']);

        return $temuan;
    }

    /**
     * Susun array output lengkap yang akan dikirim ke view / disimpan ke history.
     */
    private function buildResult(array $visualResult, array $lifestyleResult, float $cfFinal): array
    {
        // Skor Kesehatan Wajah: semakin tinggi CF → semakin bermasalah
        // Rentang skor: 0 (wajah sangat bermasalah) – 100 (wajah sehat)
        $skorKesehatan = max(0, round(100 - ($cfFinal * 100)));

        // Tentukan label kondisi berdasarkan skor
        $kondisiLabel = match (true) {
            $skorKesehatan >= 80 => 'Kulit Sehat',
            $skorKesehatan >= 60 => 'Kondisi Ringan',
            $skorKesehatan >= 40 => 'Kondisi Sedang',
            $skorKesehatan >= 20 => 'Kondisi Parah',
            default              => 'Kondisi Sangat Parah',
        };

        // Ringkasan gaya hidup: filter hanya yang berkontribusi (cf > 0)
        $lifestyleBerisiko = array_filter(
            $lifestyleResult,
            fn($l) => $l['cf_pakar'] > 0.0
        );

        return [
            // ── Hasil utama ──────────────────────────────
            'cf_final'           => $cfFinal,
            'skor_kesehatan'     => $skorKesehatan,
            'kondisi_label'      => $kondisiLabel,

            // ── Detail visual ────────────────────────────
            'temuan_klinis'      => $visualResult['temuan'],
            'roboflow_success'   => $visualResult['roboflow_success'],
            'error_message'      => $visualResult['error_message'],

            // ── Detail gaya hidup ────────────────────────
            'lifestyle_detail'   => $lifestyleResult,
            'lifestyle_berisiko' => array_values($lifestyleBerisiko),

            // ── Statistik tambahan ───────────────────────
            'total_objek_terdeteksi' => array_sum(array_column($visualResult['temuan'], 'jumlah')),
            'jenis_objek_unik'       => count($visualResult['temuan']),
        ];
    }
}
