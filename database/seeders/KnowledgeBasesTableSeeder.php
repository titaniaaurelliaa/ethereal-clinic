<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class KnowledgeBasesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('knowledge_bases')->delete();
        
        \DB::table('knowledge_bases')->insert(array (
            0 => 
            array (
                'id' => 1,
                'skin_problem_id' => 1,
                'nama_objek' => 'Jerawat',
                'tingkat_keparahan' => 'Ringan',
                'min_objek' => 1,
                'max_objek' => 5,
                'cf_pakar' => 0.3,
                'created_at' => '2026-05-08 09:30:00',
                'updated_at' => '2026-05-08 09:30:00',
            ),
            1 => 
            array (
                'id' => 2,
                'skin_problem_id' => 2,
                'nama_objek' => 'Jerawat',
                'tingkat_keparahan' => 'Sedang',
                'min_objek' => 6,
                'max_objek' => 15,
                'cf_pakar' => 0.6,
                'created_at' => '2026-05-08 09:30:00',
                'updated_at' => '2026-05-08 09:30:00',
            ),
            2 => 
            array (
                'id' => 3,
                'skin_problem_id' => 3,
                'nama_objek' => 'Jerawat',
                'tingkat_keparahan' => 'Parah',
                'min_objek' => 16,
                'max_objek' => NULL,
                'cf_pakar' => 0.9,
                'created_at' => '2026-05-08 09:30:00',
                'updated_at' => '2026-05-08 09:30:00',
            ),
            3 => 
            array (
                'id' => 4,
                'skin_problem_id' => 4,
                'nama_objek' => 'Komedo Hitam',
                'tingkat_keparahan' => 'Ringan',
                'min_objek' => 1,
                'max_objek' => 5,
                'cf_pakar' => 0.2,
                'created_at' => '2026-05-08 09:30:00',
                'updated_at' => '2026-05-08 09:30:00',
            ),
            4 => 
            array (
                'id' => 5,
                'skin_problem_id' => 5,
                'nama_objek' => 'Komedo Hitam',
                'tingkat_keparahan' => 'Sedang',
                'min_objek' => 6,
                'max_objek' => 20,
                'cf_pakar' => 0.5,
                'created_at' => '2026-05-08 09:30:00',
                'updated_at' => '2026-05-08 09:30:00',
            ),
            5 => 
            array (
                'id' => 6,
                'skin_problem_id' => 5,
                'nama_objek' => 'Komedo Hitam',
                'tingkat_keparahan' => 'Parah',
                'min_objek' => 21,
                'max_objek' => NULL,
                'cf_pakar' => 0.75,
                'created_at' => '2026-05-08 09:30:00',
                'updated_at' => '2026-05-08 09:30:00',
            ),
            6 => 
            array (
                'id' => 7,
                'skin_problem_id' => 4,
                'nama_objek' => 'Komedo Putih',
                'tingkat_keparahan' => 'Ringan',
                'min_objek' => 1,
                'max_objek' => 5,
                'cf_pakar' => 0.2,
                'created_at' => '2026-05-08 09:30:00',
                'updated_at' => '2026-05-08 09:30:00',
            ),
            7 => 
            array (
                'id' => 8,
                'skin_problem_id' => 5,
                'nama_objek' => 'Komedo Putih',
                'tingkat_keparahan' => 'Sedang',
                'min_objek' => 6,
                'max_objek' => 20,
                'cf_pakar' => 0.5,
                'created_at' => '2026-05-08 09:30:00',
                'updated_at' => '2026-05-08 09:30:00',
            ),
            8 => 
            array (
                'id' => 9,
                'skin_problem_id' => 5,
                'nama_objek' => 'Komedo Putih',
                'tingkat_keparahan' => 'Parah',
                'min_objek' => 21,
                'max_objek' => NULL,
                'cf_pakar' => 0.7,
                'created_at' => '2026-05-08 09:30:00',
                'updated_at' => '2026-05-08 09:30:00',
            ),
            9 => 
            array (
                'id' => 10,
                'skin_problem_id' => 6,
                'nama_objek' => 'Bekas Jerawat',
                'tingkat_keparahan' => 'Ringan',
                'min_objek' => 1,
                'max_objek' => 5,
                'cf_pakar' => 0.25,
                'created_at' => '2026-05-08 09:30:00',
                'updated_at' => '2026-05-08 09:30:00',
            ),
            10 => 
            array (
                'id' => 11,
                'skin_problem_id' => 6,
                'nama_objek' => 'Bekas Jerawat',
                'tingkat_keparahan' => 'Sedang',
                'min_objek' => 6,
                'max_objek' => 15,
                'cf_pakar' => 0.55,
                'created_at' => '2026-05-08 09:30:00',
                'updated_at' => '2026-05-08 09:30:00',
            ),
            11 => 
            array (
                'id' => 12,
                'skin_problem_id' => 6,
                'nama_objek' => 'Bekas Jerawat',
                'tingkat_keparahan' => 'Parah',
                'min_objek' => 16,
                'max_objek' => NULL,
                'cf_pakar' => 0.8,
                'created_at' => '2026-05-08 09:30:00',
                'updated_at' => '2026-05-08 09:30:00',
            ),
            12 => 
            array (
                'id' => 13,
                'skin_problem_id' => 7,
                'nama_objek' => 'Kista',
                'tingkat_keparahan' => 'Ringan',
                'min_objek' => 1,
                'max_objek' => 2,
                'cf_pakar' => 0.5,
                'created_at' => '2026-05-08 09:30:00',
                'updated_at' => '2026-05-08 09:30:00',
            ),
            13 => 
            array (
                'id' => 14,
                'skin_problem_id' => 8,
                'nama_objek' => 'Kista',
                'tingkat_keparahan' => 'Sedang',
                'min_objek' => 3,
                'max_objek' => 6,
                'cf_pakar' => 0.75,
                'created_at' => '2026-05-08 09:30:00',
                'updated_at' => '2026-05-08 09:30:00',
            ),
            14 => 
            array (
                'id' => 15,
                'skin_problem_id' => 8,
                'nama_objek' => 'Kista',
                'tingkat_keparahan' => 'Parah',
                'min_objek' => 7,
                'max_objek' => NULL,
                'cf_pakar' => 0.95,
                'created_at' => '2026-05-08 09:30:00',
                'updated_at' => '2026-05-08 09:30:00',
            ),
        ));
        
        
    }
}