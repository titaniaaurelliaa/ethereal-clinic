<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SymptomRulesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('symptom_rules')->delete();
        
        \DB::table('symptom_rules')->insert(array (
            0 => 
            array (
                'id' => 1,
                'knowledge_base_id' => 1,
                'pertanyaan' => 'Apakah benjolan terasa nyeri, gatal, atau panas meskipun tidak disentuh?',
                'cf_gejala' => 0.6,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-17 16:32:18',
            ),
            1 => 
            array (
                'id' => 2,
                'knowledge_base_id' => 1,
                'pertanyaan' => 'Apakah Anda sudah mencoba memencet atau mengeluarkan isi benjolan ini sendiri?',
                'cf_gejala' => 0.7,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-12 02:45:04',
            ),
            2 => 
            array (
                'id' => 3,
                'knowledge_base_id' => 2,
                'pertanyaan' => 'Apakah benjolan terasa nyeri, gatal, atau panas meskipun tidak disentuh?',
                'cf_gejala' => 0.8,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-12 02:45:04',
            ),
            3 => 
            array (
                'id' => 4,
                'knowledge_base_id' => 2,
                'pertanyaan' => 'Apakah Anda sudah mencoba memencet atau mengeluarkan isi benjolan ini sendiri?',
                'cf_gejala' => 0.7,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-12 02:45:04',
            ),
            4 => 
            array (
                'id' => 5,
                'knowledge_base_id' => 3,
                'pertanyaan' => 'Apakah benjolan terasa nyeri, gatal, atau panas meskipun tidak disentuh?',
                'cf_gejala' => 0.8,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-12 02:45:04',
            ),
            5 => 
            array (
                'id' => 6,
                'knowledge_base_id' => 3,
                'pertanyaan' => 'Apakah Anda sudah mencoba memencet atau mengeluarkan isi benjolan ini sendiri?',
                'cf_gejala' => 0.7,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-12 02:45:04',
            ),
            6 => 
            array (
                'id' => 7,
                'knowledge_base_id' => 4,
                'pertanyaan' => 'Apakah area kulit tersebut terasa kasar atau bertekstur seperti pasir saat diraba?',
                'cf_gejala' => 0.6,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-12 02:45:04',
            ),
            7 => 
            array (
                'id' => 8,
                'knowledge_base_id' => 4,
            'pertanyaan' => 'Apakah Anda rutin menggunakan riasan wajah (makeup) tebal di area tersebut?',
                'cf_gejala' => 0.7,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-12 02:45:04',
            ),
            8 => 
            array (
                'id' => 9,
                'knowledge_base_id' => 5,
                'pertanyaan' => 'Apakah area kulit tersebut terasa kasar atau bertekstur seperti pasir saat diraba?',
                'cf_gejala' => 0.6,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-12 02:45:04',
            ),
            9 => 
            array (
                'id' => 10,
                'knowledge_base_id' => 5,
            'pertanyaan' => 'Apakah Anda rutin menggunakan riasan wajah (makeup) tebal di area tersebut?',
                'cf_gejala' => 0.7,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-12 02:45:04',
            ),
            10 => 
            array (
                'id' => 11,
                'knowledge_base_id' => 6,
                'pertanyaan' => 'Apakah area kulit tersebut terasa kasar atau bertekstur seperti pasir saat diraba?',
                'cf_gejala' => 0.6,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-12 02:45:04',
            ),
            11 => 
            array (
                'id' => 12,
                'knowledge_base_id' => 6,
            'pertanyaan' => 'Apakah Anda rutin menggunakan riasan wajah (makeup) tebal di area tersebut?',
                'cf_gejala' => 0.7,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-12 02:45:04',
            ),
            12 => 
            array (
                'id' => 13,
                'knowledge_base_id' => 7,
                'pertanyaan' => 'Apakah area kulit tersebut terasa kasar atau bertekstur seperti pasir saat diraba?',
                'cf_gejala' => 0.6,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-12 02:45:04',
            ),
            13 => 
            array (
                'id' => 14,
                'knowledge_base_id' => 7,
            'pertanyaan' => 'Apakah Anda rutin menggunakan riasan wajah (makeup) tebal di area tersebut?',
                'cf_gejala' => 0.7,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-12 02:45:04',
            ),
            14 => 
            array (
                'id' => 15,
                'knowledge_base_id' => 8,
                'pertanyaan' => 'Apakah area kulit tersebut terasa kasar atau bertekstur seperti pasir saat diraba?',
                'cf_gejala' => 0.6,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-12 02:45:04',
            ),
            15 => 
            array (
                'id' => 16,
                'knowledge_base_id' => 8,
            'pertanyaan' => 'Apakah Anda rutin menggunakan riasan wajah (makeup) tebal di area tersebut?',
                'cf_gejala' => 0.7,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-12 02:45:04',
            ),
            16 => 
            array (
                'id' => 17,
                'knowledge_base_id' => 9,
                'pertanyaan' => 'Apakah area kulit tersebut terasa kasar atau bertekstur seperti pasir saat diraba?',
                'cf_gejala' => 0.6,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-12 02:45:04',
            ),
            17 => 
            array (
                'id' => 18,
                'knowledge_base_id' => 9,
            'pertanyaan' => 'Apakah Anda rutin menggunakan riasan wajah (makeup) tebal di area tersebut?',
                'cf_gejala' => 0.7,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-12 02:45:04',
            ),
            18 => 
            array (
                'id' => 19,
                'knowledge_base_id' => 13,
            'pertanyaan' => 'Apakah benjolan terasa berdenyut (nyut-nyutan) dan rasa sakitnya menembus hingga ke lapisan dalam kulit?',
                'cf_gejala' => 0.5,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-17 16:31:50',
            ),
            19 => 
            array (
                'id' => 20,
                'knowledge_base_id' => 13,
                'pertanyaan' => 'Apakah benjolan ini sudah bertahan di posisi yang sama lebih dari 2 minggu tanpa membaik?',
                'cf_gejala' => 0.8,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-12 02:45:04',
            ),
            20 => 
            array (
                'id' => 21,
                'knowledge_base_id' => 14,
            'pertanyaan' => 'Apakah benjolan terasa berdenyut (nyut-nyutan) dan rasa sakitnya menembus hingga ke lapisan dalam kulit?',
                'cf_gejala' => 0.9,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-12 02:45:04',
            ),
            21 => 
            array (
                'id' => 22,
                'knowledge_base_id' => 14,
                'pertanyaan' => 'Apakah benjolan ini sudah bertahan di posisi yang sama lebih dari 2 minggu tanpa membaik?',
                'cf_gejala' => 0.8,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-12 02:45:04',
            ),
            22 => 
            array (
                'id' => 23,
                'knowledge_base_id' => 15,
            'pertanyaan' => 'Apakah benjolan terasa berdenyut (nyut-nyutan) dan rasa sakitnya menembus hingga ke lapisan dalam kulit?',
                'cf_gejala' => 0.9,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-12 02:45:04',
            ),
            23 => 
            array (
                'id' => 24,
                'knowledge_base_id' => 15,
                'pertanyaan' => 'Apakah benjolan ini sudah bertahan di posisi yang sama lebih dari 2 minggu tanpa membaik?',
                'cf_gejala' => 0.8,
                'created_at' => '2026-05-12 02:45:04',
                'updated_at' => '2026-05-12 02:45:04',
            ),
        ));
        
        
    }
}