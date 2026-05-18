<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\KnowledgeBase;
use App\Models\SymptomRule;

/**
 * SymptomRuleSeeder
 *
 * Mengisi tabel symptom_rules dengan pertanyaan anamnesis medis (Subjective)
 * yang relevan secara klinis untuk setiap kondisi kulit yang dapat dideteksi AI.
 *
 * Strategi:
 *   - ID KnowledgeBase di-resolve secara DINAMIS lewat nama_objek agar seeder
 *     tidak bergantung pada urutan insert atau hardcoded ID.
 *   - Jika suatu objek belum ada di tabel knowledge_bases, peringatan akan
 *     ditampilkan ke konsol dan baris akan di-skip (tidak gagal fatal).
 *   - Pertanyaan yang sama (misal: untuk Komedo Hitam & Komedo Putih)
 *     diinsert pada SETIAP knowledge_base_id yang ditemukan untuk nama tersebut,
 *     sehingga anamnesis benar-benar kontekstual per-entri.
 */
class SymptomRuleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Definisi master pertanyaan anamnesis per nama_objek.
     *
     * Format:
     *   'nama_objek' => [
     *       ['pertanyaan' => '...', 'cf_gejala' => 0.0],
     *   ]
     *
     * @var array<string, array<int, array{pertanyaan: string, cf_gejala: float}>>
     */
    private array $questionMap = [
        // ── Jerawat (Papule / Pustule) ──────────────────────────────────────
        'Jerawat' => [
            [
                'pertanyaan' => 'Apakah benjolan terasa nyeri, gatal, atau panas meskipun tidak disentuh?',
                'cf_gejala'  => 0.8,
            ],
            [
                'pertanyaan' => 'Apakah Anda sudah mencoba memencet atau mengeluarkan isi benjolan ini sendiri?',
                'cf_gejala'  => 0.7,
            ],
        ],

        // ── Komedo Hitam (Blackhead) ─────────────────────────────────────────
        'Komedo Hitam' => [
            [
                'pertanyaan' => 'Apakah area kulit tersebut terasa kasar atau bertekstur seperti pasir saat diraba?',
                'cf_gejala'  => 0.6,
            ],
            [
                'pertanyaan' => 'Apakah Anda rutin menggunakan riasan wajah (makeup) tebal di area tersebut?',
                'cf_gejala'  => 0.7,
            ],
        ],

        // ── Komedo Putih (Whitehead) ─────────────────────────────────────────
        'Komedo Putih' => [
            [
                'pertanyaan' => 'Apakah area kulit tersebut terasa kasar atau bertekstur seperti pasir saat diraba?',
                'cf_gejala'  => 0.6,
            ],
            [
                'pertanyaan' => 'Apakah Anda rutin menggunakan riasan wajah (makeup) tebal di area tersebut?',
                'cf_gejala'  => 0.7,
            ],
        ],

        // ── Kista (Cystic Acne) ──────────────────────────────────────────────
        'Kista' => [
            [
                'pertanyaan' => 'Apakah benjolan terasa berdenyut (nyut-nyutan) dan rasa sakitnya menembus hingga ke lapisan dalam kulit?',
                'cf_gejala'  => 0.9,
            ],
            [
                'pertanyaan' => 'Apakah benjolan ini sudah bertahan di posisi yang sama lebih dari 2 minggu tanpa membaik?',
                'cf_gejala'  => 0.8,
            ],
        ],
    ];

    // ─────────────────────────────────────────────────────────────────────────

    public function run(): void
    {
        $this->command->info('');
        $this->command->info('┌─────────────────────────────────────────────────┐');
        $this->command->info('│  SymptomRuleSeeder — Anamnesis Kontekstual       │');
        $this->command->info('└─────────────────────────────────────────────────┘');

        $totalInserted = 0;

        foreach ($this->questionMap as $namaObjek => $questions) {
            // Resolve semua knowledge_base_id untuk nama_objek ini secara dinamis.
            // Satu nama_objek bisa punya beberapa baris (Ringan / Sedang / Parah).
            $knowledgeBases = KnowledgeBase::where('nama_objek', $namaObjek)->get();

            if ($knowledgeBases->isEmpty()) {
                $this->command->warn("  [SKIP] Tidak ditemukan KnowledgeBase untuk objek: \"{$namaObjek}\"");
                continue;
            }

            $this->command->line("  ► Objek: <fg=cyan>{$namaObjek}</> ({$knowledgeBases->count()} entri KB ditemukan)");

            foreach ($knowledgeBases as $kb) {
                $rows = array_map(
                    fn(array $q): array => [
                        'knowledge_base_id' => $kb->id,
                        'pertanyaan'        => $q['pertanyaan'],
                        'cf_gejala'         => $q['cf_gejala'],
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ],
                    $questions
                );

                // Bulk insert per knowledge_base_id untuk efisiensi query
                SymptomRule::insert($rows);

                $count = count($rows);
                $totalInserted += $count;

                $this->command->line(
                    "     KB ID #{$kb->id} [{$kb->tingkat_keparahan}] → {$count} pertanyaan di-insert."
                );
            }
        }

        $this->command->info('');
        $this->command->info("  ✓ Total {$totalInserted} SymptomRule berhasil di-seed.");
        $this->command->info('');
    }
}
