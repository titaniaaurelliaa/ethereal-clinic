<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProblemTreatmentSeeder extends Seeder
{
    public function run(): void
    {
        // Asumsi ID:
        // Jerawat = 1, Kulit Kering = 2, Kulit Berminyak = 3, Komedo = 4
        // Kulit Sensitif = 5, Hiperpigmentasi = 6, Penuaan Dini = 7
        
        // Treatment ID: 
        // 1-3 Jerawat, 4-5 Kulit Kering, 6-7 Kulit Berminyak, 8 Komedo
        // 9 Kulit Sensitif, 10-11 Hiperpigmentasi, 12-14 Semua Jenis
        
        $relations = [
            // Jerawat (problem_id = 1)
            ['problem_id' => 1, 'treatment_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 1, 'treatment_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 1, 'treatment_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 1, 'treatment_id' => 10, 'created_at' => now(), 'updated_at' => now()], // Sunscreen
            ['problem_id' => 1, 'treatment_id' => 11, 'created_at' => now(), 'updated_at' => now()], // Hindari matahari
            ['problem_id' => 1, 'treatment_id' => 14, 'created_at' => now(), 'updated_at' => now()], // Kurangi gula
            
            // Kulit Kering (problem_id = 2)
            ['problem_id' => 2, 'treatment_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 2, 'treatment_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 2, 'treatment_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 2, 'treatment_id' => 12, 'created_at' => now(), 'updated_at' => now()], // Minum air
            
            // Kulit Berminyak (problem_id = 3)
            ['problem_id' => 3, 'treatment_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 3, 'treatment_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 3, 'treatment_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 3, 'treatment_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            
            // Komedo (problem_id = 4)
            ['problem_id' => 4, 'treatment_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 4, 'treatment_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 4, 'treatment_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            
            // Kulit Sensitif (problem_id = 5)
            ['problem_id' => 5, 'treatment_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 5, 'treatment_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 5, 'treatment_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            
            // Hiperpigmentasi (problem_id = 6)
            ['problem_id' => 6, 'treatment_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 6, 'treatment_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 6, 'treatment_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            
            // Penuaan Dini (problem_id = 7)
            ['problem_id' => 7, 'treatment_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 7, 'treatment_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 7, 'treatment_id' => 13, 'created_at' => now(), 'updated_at' => now()], // Istirahat cukup
            ['problem_id' => 7, 'treatment_id' => 12, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('problem_treatment')->insert($relations);
    }
}