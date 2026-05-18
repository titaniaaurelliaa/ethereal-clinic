<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LifestyleRule;

/**
 * LifestyleRuleSeeder
 *
 * Menyimpan bobot CF Pakar untuk setiap pilihan gaya hidup pengguna.
 * CF yang lebih tinggi = kontribusi LEBIH BESAR terhadap risiko jerawat.
 *
 * Kategori yang tersedia:
 *   1. Tidur          – durasi tidur malam
 *   2. Stres          – tingkat stres harian
 *   3. Air            – konsumsi air putih harian
 *   4. Diet           – pola makan / konsumsi makanan pemicu
 *   5. Sinar Matahari – paparan sinar UV tanpa perlindungan
 *
 * Pilihan standar per kategori: Low | Moderate | High
 * (maknanya berbeda-beda tergantung kategori — lihat label)
 */
class LifestyleRuleSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // ══════════════════════════════════════════════════════
            // 1. TIDUR
            //    Low    = kurang tidur → risiko tinggi (kortisol naik)
            //    Moderate = cukup tidur → risiko sedang
            //    High   = tidur optimal → risiko rendah / tidak ada
            // ══════════════════════════════════════════════════════
            [
                'kategori' => 'Tidur',
                'pilihan'  => 'Low',
                'label'    => 'Kurang dari 6 jam per malam',
                'cf_pakar' => 0.60,
            ],
            [
                'kategori' => 'Tidur',
                'pilihan'  => 'Moderate',
                'label'    => '6–8 jam per malam (cukup)',
                'cf_pakar' => 0.25,
            ],
            [
                'kategori' => 'Tidur',
                'pilihan'  => 'High',
                'label'    => 'Lebih dari 8 jam per malam',
                'cf_pakar' => 0.00,
            ],

            // ══════════════════════════════════════════════════════
            // 2. STRES
            //    Low    = stres rendah → risiko rendah
            //    Moderate = stres sedang → risiko sedang
            //    High   = stres tinggi → risiko tinggi (hormon androgen)
            // ══════════════════════════════════════════════════════
            [
                'kategori' => 'Stres',
                'pilihan'  => 'Low',
                'label'    => 'Stres rendah, jarang tertekan',
                'cf_pakar' => 0.00,
            ],
            [
                'kategori' => 'Stres',
                'pilihan'  => 'Moderate',
                'label'    => 'Stres sedang, kadang merasa tertekan',
                'cf_pakar' => 0.35,
            ],
            [
                'kategori' => 'Stres',
                'pilihan'  => 'High',
                'label'    => 'Stres tinggi, sering merasa tertekan / cemas',
                'cf_pakar' => 0.70,
            ],

            // ══════════════════════════════════════════════════════
            // 3. AIR (Konsumsi Air Putih)
            //    Low    = minum sedikit → kulit dehidrasi, risiko tinggi
            //    Moderate = cukup minum
            //    High   = minum banyak → kulit terhidrasi, risiko rendah
            // ══════════════════════════════════════════════════════
            [
                'kategori' => 'Air',
                'pilihan'  => 'Low',
                'label'    => 'Kurang dari 4 gelas per hari',
                'cf_pakar' => 0.50,
            ],
            [
                'kategori' => 'Air',
                'pilihan'  => 'Moderate',
                'label'    => '4–7 gelas per hari',
                'cf_pakar' => 0.20,
            ],
            [
                'kategori' => 'Air',
                'pilihan'  => 'High',
                'label'    => '8 gelas atau lebih per hari',
                'cf_pakar' => 0.00,
            ],

            // ══════════════════════════════════════════════════════
            // 4. DIET (Pola Makan)
            //    Low    = diet sehat, hindari pemicu → risiko rendah
            //    Moderate = pola makan campuran
            //    High   = sering konsumsi pemicu (gula, susu, gorengan)
            //              → insulin spike, risiko tinggi
            // ══════════════════════════════════════════════════════
            [
                'kategori' => 'Diet',
                'pilihan'  => 'Low',
                'label'    => 'Jarang konsumsi makanan berminyak / manis / susu',
                'cf_pakar' => 0.00,
            ],
            [
                'kategori' => 'Diet',
                'pilihan'  => 'Moderate',
                'label'    => 'Kadang-kadang konsumsi makanan pemicu jerawat',
                'cf_pakar' => 0.30,
            ],
            [
                'kategori' => 'Diet',
                'pilihan'  => 'High',
                'label'    => 'Sering konsumsi gorengan, gula, minuman manis, atau susu tinggi lemak',
                'cf_pakar' => 0.65,
            ],

            // ══════════════════════════════════════════════════════
            // 5. SINAR MATAHARI (Paparan UV tanpa pelindung)
            //    Low    = jarang terpapar / selalu pakai sunscreen
            //    Moderate = sesekali tanpa perlindungan
            //    High   = sering terpapar langsung tanpa sunscreen
            //              → peradangan & overproduction sebum
            // ══════════════════════════════════════════════════════
            [
                'kategori' => 'Sinar Matahari',
                'pilihan'  => 'Low',
                'label'    => 'Jarang terpapar atau selalu pakai tabir surya',
                'cf_pakar' => 0.00,
            ],
            [
                'kategori' => 'Sinar Matahari',
                'pilihan'  => 'Moderate',
                'label'    => 'Sesekali terpapar matahari tanpa perlindungan',
                'cf_pakar' => 0.25,
            ],
            [
                'kategori' => 'Sinar Matahari',
                'pilihan'  => 'High',
                'label'    => 'Sering di luar ruangan tanpa tabir surya (> 2 jam/hari)',
                'cf_pakar' => 0.55,
            ],
        ];

        foreach ($data as $row) {
            LifestyleRule::create($row);
        }

        $this->command->info('✅  LifestyleRuleSeeder: ' . count($data) . ' rule berhasil disimpan.');
    }
}
