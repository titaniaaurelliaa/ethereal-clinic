<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkinProblemsSeeder extends Seeder
{
    public function run(): void
    {
        $problems = [
            [
                'name' => 'Jerawat',
                'description' => 'Jerawat adalah kondisi kulit yang terjadi ketika folikel rambut tersumbat oleh minyak dan sel kulit mati. Biasanya muncul sebagai komedo, papula, pustula, atau kista.',
                'severity_level' => 'sedang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kulit Kering',
                'description' => 'Kulit kering ditandai dengan kulit yang terasa kasar, bersisik, pecah-pecah, dan terasa gatal. Kondisi ini bisa disebabkan oleh faktor cuaca, kurangnya kelembaban, atau penggunaan produk yang terlalu keras.',
                'severity_level' => 'ringan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kulit Berminyak',
                'description' => 'Kulit berminyak terjadi karena produksi sebum (minyak alami) yang berlebihan oleh kelenjar sebasea. Biasanya ditandai dengan wajah yang terlihat mengkilap, pori-pori besar, dan rentan terhadap jerawat.',
                'severity_level' => 'ringan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Komedo (Minyak & Milia)',
                'description' => 'Komedo adalah pori-pori yang tersumbat oleh minyak dan sel kulit mati. Komedo hitam (blackhead) terbuka di permukaan, sedangkan komedo putih (whitehead) tertutup oleh lapisan tipis kulit.',
                'severity_level' => 'ringan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kulit Sensitif',
                'description' => 'Kulit sensitif mudah bereaksi terhadap produk, cuaca, atau stres. Gejalanya berupa kemerahan, gatal, perih, atau rasa terbakar pada kulit.',
                'severity_level' => 'sedang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hiperpigmentasi (Bekas Jerawat)',
                'description' => 'Hiperpigmentasi adalah kondisi di mana kulit menghasilkan melanin berlebih, menyebabkan bercak gelap pada kulit. Sering terjadi setelah peradangan seperti bekas jerawat.',
                'severity_level' => 'ringan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Penuaan Dini',
                'description' => 'Penuaan dini ditandai dengan munculnya garis halus, kerutan, dan kulit kendur sebelum waktunya. Bisa disebabkan oleh paparan sinar matahari, polusi, dan gaya hidup tidak sehat.',
                'severity_level' => 'sedang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('skin_problems')->insert($problems);
    }
}