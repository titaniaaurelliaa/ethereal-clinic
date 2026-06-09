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
            0 => array (
                'id' => 1,
                'knowledge_base_id' => 4,
                'pertanyaan' => 'Terdapat bintik kecil berwarna hitam pada permukaan kulit',
                'cf_pakar' => 0.8,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            1 => array (
                'id' => 2,
                'knowledge_base_id' => 4,
                'pertanyaan' => 'Pori-pori kulit tampak membesar dan terbuka',
                'cf_pakar' => 0.6,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            2 => array (
                'id' => 3,
                'knowledge_base_id' => 4,
                'pertanyaan' => 'Tidak disertai rasa nyeri atau peradangan',
                'cf_pakar' => 0.6,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            3 => array (
                'id' => 4,
                'knowledge_base_id' => 4,
                'pertanyaan' => 'Umumnya muncul pada area hidung, dahi, dan dagu',
                'cf_pakar' => 0.0,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            4 => array (
                'id' => 5,
                'knowledge_base_id' => 4,
                'pertanyaan' => 'Muncul benjolan kecil berwarna putih atau sewarna kulit',
                'cf_pakar' => 0.8,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            5 => array (
                'id' => 6,
                'knowledge_base_id' => 4,
                'pertanyaan' => 'Pori-pori tersumbat namun tertutup oleh kulit',
                'cf_pakar' => 0.6,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            6 => array (
                'id' => 7,
                'knowledge_base_id' => 4,
                'pertanyaan' => 'Tidak menimbulkan rasa nyeri',
                'cf_pakar' => 0.5,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            7 => array (
                'id' => 8,
                'knowledge_base_id' => 4,
                'pertanyaan' => 'Umumnya muncul di wajah dan dagu',
                'cf_pakar' => 0.3,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            8 => array (
                'id' => 9,
                'knowledge_base_id' => 4,
                'pertanyaan' => 'Benjolan kecil berwarna kemerahan',
                'cf_pakar' => 0.8,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            9 => array (
                'id' => 10,
                'knowledge_base_id' => 2,
                'pertanyaan' => 'Terasa nyeri saat disentuh',
                'cf_pakar' => 0.6,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            10 => array (
                'id' => 11,
                'knowledge_base_id' => 2,
                'pertanyaan' => 'Tidak mengandung nanah',
                'cf_pakar' => 0.5,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            11 => array (
                'id' => 12,
                'knowledge_base_id' => 2,
                'pertanyaan' => 'Menunjukkan adanya peradangan pada kulit',
                'cf_pakar' => 0.7,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            12 => array (
                'id' => 13,
                'knowledge_base_id' => 2,
                'pertanyaan' => 'Benjolan merah dengan puncak berwarna putih atau kuning',
                'cf_pakar' => 0.8,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            13 => array (
                'id' => 14,
                'knowledge_base_id' => 2,
                'pertanyaan' => 'Mengandung nanah',
                'cf_pakar' => 1.0,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            14 => array (
                'id' => 15,
                'knowledge_base_id' => 2,
                'pertanyaan' => 'Terasa nyeri dan meradang',
                'cf_pakar' => 0.6,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            15 => array (
                'id' => 16,
                'knowledge_base_id' => 7,
                'pertanyaan' => 'Benjolan besar dan keras di bawah kulit',
                'cf_pakar' => 0.8,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            16 => array (
                'id' => 17,
                'knowledge_base_id' => 7,
                'pertanyaan' => 'Terasa sangat nyeri',
                'cf_pakar' => 0.6,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            17 => array (
                'id' => 18,
                'knowledge_base_id' => 7,
                'pertanyaan' => 'Tidak memiliki puncak nanah yang jelas',
                'cf_pakar' => 0.5,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            18 => array (
                'id' => 19,
                'knowledge_base_id' => 8,
                'pertanyaan' => 'Benjolan besar berisi cairan atau nanah di bawah kulit',
                'cf_pakar' => 0.8,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            19 => array (
                'id' => 20,
                'knowledge_base_id' => 8,
                'pertanyaan' => 'Nyeri hebat dan peradangan luas',
                'cf_pakar' => 0.6,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            20 => array (
                'id' => 21,
                'knowledge_base_id' => 8,
                'pertanyaan' => 'Ukuran jerawat relatif besar dan lunak',
                'cf_pakar' => 0.5,
                'created_at' => now(),
                'updated_at' => now(),
            ),
        ));
        
        
    }
}