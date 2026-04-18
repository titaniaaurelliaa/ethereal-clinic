<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProblemSymptomSeeder extends Seeder
{
    public function run(): void
    {
        // Asumsi ID:
        // Jerawat = 1, Kulit Kering = 2, Kulit Berminyak = 3, Komedo = 4
        // Kulit Sensitif = 5, Hiperpigmentasi = 6, Penuaan Dini = 7
        
        // Gejala ID: 1-4 Jerawat, 5-8 Kulit Kering, 9-11 Kulit Berminyak, 12-13 Komedo
        // 14-15 Kulit Sensitif, 16-17 Hiperpigmentasi, 18-19 Penuaan Dini
        
        $relations = [
            // Jerawat (problem_id = 1) dengan gejalanya
            ['problem_id' => 1, 'symptom_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 1, 'symptom_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 1, 'symptom_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 1, 'symptom_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            
            // Kulit Kering (problem_id = 2)
            ['problem_id' => 2, 'symptom_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 2, 'symptom_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 2, 'symptom_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 2, 'symptom_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            
            // Kulit Berminyak (problem_id = 3)
            ['problem_id' => 3, 'symptom_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 3, 'symptom_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 3, 'symptom_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            
            // Komedo (problem_id = 4)
            ['problem_id' => 4, 'symptom_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 4, 'symptom_id' => 13, 'created_at' => now(), 'updated_at' => now()],
            
            // Kulit Sensitif (problem_id = 5)
            ['problem_id' => 5, 'symptom_id' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 5, 'symptom_id' => 15, 'created_at' => now(), 'updated_at' => now()],
            
            // Hiperpigmentasi (problem_id = 6)
            ['problem_id' => 6, 'symptom_id' => 16, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 6, 'symptom_id' => 17, 'created_at' => now(), 'updated_at' => now()],
            
            // Penuaan Dini (problem_id = 7)
            ['problem_id' => 7, 'symptom_id' => 18, 'created_at' => now(), 'updated_at' => now()],
            ['problem_id' => 7, 'symptom_id' => 19, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('problem_symptom')->insert($relations);
    }
}