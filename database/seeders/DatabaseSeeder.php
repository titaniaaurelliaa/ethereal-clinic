<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder hasil generator secara berurutan rapi
        $this->call([
            SkinProblemsTableSeeder::class,    // 1. Induk Masalah Kulit
            ProductsTableSeeder::class,        // 2. Induk Produk
            TreatmentsTableSeeder::class,      // 3. Induk Treatment
            ProblemProductTableSeeder::class,  // 4. Pivot Produk (Butuh id dari 1 & 2)
            ProblemTreatmentTableSeeder::class,// 5. Pivot Treatment (Butuh id dari 1 & 3)
            KnowledgeBasesTableSeeder::class,  // 6. Induk Basis Pengetahuan (Butuh id dari 1)
            SymptomRulesTableSeeder::class,    // 7. Anak Pertanyaan Anamnesis (Butuh id dari 6)
        ]);
    }
}