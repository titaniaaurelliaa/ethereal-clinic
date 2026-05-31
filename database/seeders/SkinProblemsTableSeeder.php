<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SkinProblemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('skin_problems')->delete();
        
        \DB::table('skin_problems')->insert(array (
            0 => 
            array (
                'id' => 1,
            'name' => 'Jerawat Ringan (Acne Vulgaris)',
            'description' => 'Terdapat sedikit jerawat aktif (pustula/papula).',
                'severity_level' => 'ringan',
                'created_at' => '2026-05-19 09:25:39',
                'updated_at' => '2026-05-19 09:25:39',
            ),
            1 => 
            array (
                'id' => 2,
            'name' => 'Jerawat Sedang (Acne Vulgaris)',
                'description' => 'Jerawat aktif tersebar di beberapa area wajah.',
                'severity_level' => 'sedang',
                'created_at' => '2026-05-19 09:25:39',
                'updated_at' => '2026-05-19 09:25:39',
            ),
            2 => 
            array (
                'id' => 3,
            'name' => 'Jerawat Parah (Acne Vulgaris)',
                'description' => 'Peradangan jerawat yang luas dan masif.',
                'severity_level' => 'berat',
                'created_at' => '2026-05-19 09:25:39',
                'updated_at' => '2026-05-19 09:25:39',
            ),
            3 => 
            array (
                'id' => 4,
            'name' => 'Komedo (Comedonal Acne)',
            'description' => 'Tumpukan sebum/kulit mati (blackheads/whiteheads).',
                'severity_level' => 'ringan',
                'created_at' => '2026-05-19 09:25:39',
                'updated_at' => '2026-05-19 09:25:39',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Komedo Parah',
                'description' => 'Komedo menumpuk dalam jumlah banyak, rawan meradang.',
                'severity_level' => 'sedang',
                'created_at' => '2026-05-19 09:25:39',
                'updated_at' => '2026-05-19 09:25:39',
            ),
            5 => 
            array (
                'id' => 6,
            'name' => 'Bekas Jerawat (PIH/PIE)',
                'description' => 'Noda hitam atau kemerahan pasca peradangan jerawat.',
                'severity_level' => 'ringan',
                'created_at' => '2026-05-19 09:25:39',
                'updated_at' => '2026-05-19 09:25:39',
            ),
            6 => 
            array (
                'id' => 7,
            'name' => 'Kista / Jerawat Batu (Nodulokistik)',
                'description' => 'Benjolan keras di bawah kulit, nyeri, dan berakar.',
                'severity_level' => 'sedang',
                'created_at' => '2026-05-19 09:25:39',
                'updated_at' => '2026-05-19 09:25:39',
            ),
            7 => 
            array (
                'id' => 8,
            'name' => 'Kista Parah (Nodulokistik)',
            'description' => 'Kista yang meradang parah, berisiko tinggi merusak jaringan kulit (bopeng).',
                'severity_level' => 'berat',
                'created_at' => '2026-05-19 09:25:39',
                'updated_at' => '2026-05-19 09:25:39',
            ),
        ));
        
        
    }
}