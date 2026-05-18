<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KnowledgeBase;

/**
 * KnowledgeBaseSeeder
 *
 * Menyimpan bobot CF Pakar medis untuk setiap objek jerawat
 * berdasarkan jumlah yang terdeteksi oleh model AI (YOLO/Roboflow).
 *
 * Skema Tingkat Keparahan:
 *   Ringan : 1–5  objek → CF rendah  (0.2 – 0.4)
 *   Sedang : 6–15 objek → CF sedang  (0.5 – 0.7)
 *   Parah  : > 15 objek → CF tinggi  (0.75 – 1.0)
 *
 * Objek yang dikenali sistem:
 *   1. Jerawat          – papula/pustula aktif
 *   2. Komedo Hitam     – blackhead (open comedone)
 *   3. Komedo Putih     – whitehead (closed comedone)
 *   4. Bekas Jerawat    – post-inflammatory hyperpigmentation
 *   5. Kista / Nodul   – jerawat kistik dalam
 */
class KnowledgeBaseSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // ─────────────────────────────────────────
            // 1. JERAWAT (Papula / Pustula Aktif)
            // ─────────────────────────────────────────
            [
                'nama_objek'        => 'Jerawat',
                'tingkat_keparahan' => 'Ringan',
                'min_objek'         => 1,
                'max_objek'         => 5,
                'cf_pakar'          => 0.30,
            ],
            [
                'nama_objek'        => 'Jerawat',
                'tingkat_keparahan' => 'Sedang',
                'min_objek'         => 6,
                'max_objek'         => 15,
                'cf_pakar'          => 0.60,
            ],
            [
                'nama_objek'        => 'Jerawat',
                'tingkat_keparahan' => 'Parah',
                'min_objek'         => 16,
                'max_objek'         => null, // tidak terbatas
                'cf_pakar'          => 0.90,
            ],

            // ─────────────────────────────────────────
            // 2. KOMEDO HITAM (Blackhead)
            // ─────────────────────────────────────────
            [
                'nama_objek'        => 'Komedo Hitam',
                'tingkat_keparahan' => 'Ringan',
                'min_objek'         => 1,
                'max_objek'         => 5,
                'cf_pakar'          => 0.20,
            ],
            [
                'nama_objek'        => 'Komedo Hitam',
                'tingkat_keparahan' => 'Sedang',
                'min_objek'         => 6,
                'max_objek'         => 20,
                'cf_pakar'          => 0.50,
            ],
            [
                'nama_objek'        => 'Komedo Hitam',
                'tingkat_keparahan' => 'Parah',
                'min_objek'         => 21,
                'max_objek'         => null,
                'cf_pakar'          => 0.75,
            ],

            // ─────────────────────────────────────────
            // 3. KOMEDO PUTIH (Whitehead)
            // ─────────────────────────────────────────
            [
                'nama_objek'        => 'Komedo Putih',
                'tingkat_keparahan' => 'Ringan',
                'min_objek'         => 1,
                'max_objek'         => 5,
                'cf_pakar'          => 0.20,
            ],
            [
                'nama_objek'        => 'Komedo Putih',
                'tingkat_keparahan' => 'Sedang',
                'min_objek'         => 6,
                'max_objek'         => 20,
                'cf_pakar'          => 0.50,
            ],
            [
                'nama_objek'        => 'Komedo Putih',
                'tingkat_keparahan' => 'Parah',
                'min_objek'         => 21,
                'max_objek'         => null,
                'cf_pakar'          => 0.70,
            ],

            // ─────────────────────────────────────────
            // 4. BEKAS JERAWAT (PIH / Hiperpigmentasi)
            // ─────────────────────────────────────────
            [
                'nama_objek'        => 'Bekas Jerawat',
                'tingkat_keparahan' => 'Ringan',
                'min_objek'         => 1,
                'max_objek'         => 5,
                'cf_pakar'          => 0.25,
            ],
            [
                'nama_objek'        => 'Bekas Jerawat',
                'tingkat_keparahan' => 'Sedang',
                'min_objek'         => 6,
                'max_objek'         => 15,
                'cf_pakar'          => 0.55,
            ],
            [
                'nama_objek'        => 'Bekas Jerawat',
                'tingkat_keparahan' => 'Parah',
                'min_objek'         => 16,
                'max_objek'         => null,
                'cf_pakar'          => 0.80,
            ],

            // ─────────────────────────────────────────
            // 5. KISTA / NODUL (Jerawat Kistik Dalam)
            // ─────────────────────────────────────────
            [
                'nama_objek'        => 'Kista',
                'tingkat_keparahan' => 'Ringan',
                'min_objek'         => 1,
                'max_objek'         => 2,
                'cf_pakar'          => 0.50, // bahkan 1-2 kista sudah cukup serius
            ],
            [
                'nama_objek'        => 'Kista',
                'tingkat_keparahan' => 'Sedang',
                'min_objek'         => 3,
                'max_objek'         => 6,
                'cf_pakar'          => 0.75,
            ],
            [
                'nama_objek'        => 'Kista',
                'tingkat_keparahan' => 'Parah',
                'min_objek'         => 7,
                'max_objek'         => null,
                'cf_pakar'          => 0.95,
            ],
        ];

        foreach ($data as $row) {
            KnowledgeBase::create($row);
        }

        $this->command->info('✅  KnowledgeBaseSeeder: ' . count($data) . ' rule berhasil disimpan.');
    }
}
