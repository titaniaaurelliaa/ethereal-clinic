<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TreatmentsSeeder extends Seeder
{
    public function run(): void
    {
        $treatments = [
            // Perawatan untuk Jerawat
            [
                'name' => 'Blackheads (Komedo Terbuka)',
                'description' => 'Cuci muka 2 kali sehari dengan pembersih yang mengandung Salicylic Acid (BHA). Bahan ini larut dalam minyak, membersihkan pori dari dalam . Oleskan Retinoid topikal (seperti Adapalene 0.1%) di malam hari untuk membuka pori yang tersumbat. Gunakan pelembap non-komedogenik (tidak menyumbat pori). Jika ingin hasil cepat, ekstraksi komedo bisa dilakukan oleh dokter (jangan sendiri) .',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Whiteheads (Komedo Tertutup)',
                'description' => 'Perawatan serupa dengan blackheads: Cuci muka 2 kali sehari dengan pembersih lembut. Gunakan Tretinoin atau Adapalene (resep dokter) untuk mengelupas lapisan kulit penutup komedo . Hindari memencet whiteheads karena akan memperparah peradangan. Pastikan semua produk skincare berlabel "non-comedogenic".',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Papula (Jerawat Meradang Merah)',
                'description' => 'Cuci muka 2 kali sehari dengan pembersih lembut, jangan digosok keras. Gunakan Benzoyl Peroxide (cuci muka/spot treatment) untuk membunuh bakteri penyebab radang . Kombinasikan dengan Retinoid topikal (malam) atau Antibiotik topikal (dengan resep) . JANGAN MEMENCET, karena akan memperdalam peradangandan risiko bekas luka.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pustula (Jerawat Bernanah)',
                'description' => 'Cuci muka 2 kali sehari. Oleskan Benzoyl Peroxide (5% atau 2.5%) tepat di pustula untuk mengeringkan nanah dan membunuh bakteri . Jika tidak membaik, dokter mungkin meresepkan Antibiotik topikal (seperti clindamycin) hanya jika dikombinasikan dengan Benzoyl Peroxide (untuk mencegah resistensi bakteri) . Jangan dipencet, nanah akan keluar sendiri atau diserap oleh hydrocolloid patch.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nodul (Jerawat Batu Besar)',
                'description' => 'WAJIB KE DOKTER. Ini jerawat parah di bawah kulit. Cuci muka 2 kali sehari dengan pembersih LEMBUT, tetapi obat OTC (over-the-counter) TIDAK cukup. Dokter biasanya akan meresepkan Isotretinoin oral (obat paling efektif untuk jerawat batu)  atau suntik Kortikosteroid intralesi langsung ke nodul untuk mengecilkannya dengan cepat .',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kistik (Jerawat Batu Dalam)',
                'description' => 'HARUS DITANGANI DOKTER SPESIALIS KULIT. Ini bentuk jerawat paling parah dan menyakitkan. Jangan pernah memencet atau menginsisi sendiri, karena akan menyebabkan bekas luka permanen . Cuci muka 2 kali sehari dengan pembersih super lembut untuk menjaga skin barrier. Gold Standard pengobatan adalah Isotretinoin oral, dengan pemantauan fungsi hati dan lipid secara rutin . Terapi pendukung: suntik kortikosteroid untuk kista yang sangat besar.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('treatments')->insert($treatments);
    }
}