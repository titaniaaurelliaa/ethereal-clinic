<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProblemProductTableSeeder extends Seeder
{
    /**
     * Auto-calibrated seed file to prevent Foreign Key constraints.
     *
     * @return void
     */
    public function run()
    {
        // 1. Bersihkan data pivot lama
        DB::table('problem_product')->delete();
        
        // 2. Ambil semua ID produk asli yang saat ini ada di database (urutkan dari terkecil)
        $availableProductIds = DB::table('products')->orderBy('id')->pluck('id')->toArray();

        // Guard Clause: Jika tabel produk kosong, hentikan agar tidak memicu error
        if (empty($availableProductIds)) {
            return;
        }

        // 3. Cetak cetak biru relasi lama (ID 15 s/d 24)
        $oldRelations = [
            ['skin_problem_id' => 4, 'old_product_id' => 15],
            ['skin_problem_id' => 1, 'old_product_id' => 16],
            ['skin_problem_id' => 2, 'old_product_id' => 16],
            ['skin_problem_id' => 3, 'old_product_id' => 16],
            ['skin_problem_id' => 4, 'old_product_id' => 16],
            ['skin_problem_id' => 5, 'old_product_id' => 16],
            ['skin_problem_id' => 6, 'old_product_id' => 16],
            ['skin_problem_id' => 7, 'old_product_id' => 16],
            ['skin_problem_id' => 8, 'old_product_id' => 16],
            ['skin_problem_id' => 1, 'old_product_id' => 17],
            ['skin_problem_id' => 7, 'old_product_id' => 17],
            ['skin_problem_id' => 8, 'old_product_id' => 17],
            ['skin_problem_id' => 7, 'old_product_id' => 18],
            ['skin_problem_id' => 4, 'old_product_id' => 19],
            ['skin_problem_id' => 4, 'old_product_id' => 20],
            ['skin_problem_id' => 4, 'old_product_id' => 21],
            ['skin_problem_id' => 4, 'old_product_id' => 22],
            ['skin_problem_id' => 7, 'old_product_id' => 23],
            ['skin_problem_id' => 1, 'old_product_id' => 24],
            ['skin_problem_id' => 7, 'old_product_id' => 24],
            ['skin_problem_id' => 8, 'old_product_id' => 24],
        ];

        $calibratedRelations = [];

        // 4. Petakan secara dinamis ID lama ke ID baru berdasarkan indeks urutannya
        foreach ($oldRelations as $relation) {
            // ID lama 15 menjadi index 0, 16 menjadi index 1, dst.
            $index = $relation['old_product_id'] - 15;

            // Pengaman tingkat tinggi: Jika index ada di dalam jangkauan produk baru, gunakan.
            // Jika di luar jangkauan (karena jumlah produk berkurang), gunakan operasi modulo agar tetap mendapat ID valid.
            if (isset($availableProductIds[$index])) {
                $realProductId = $availableProductIds[$index];
            } else {
                $realProductId = $availableProductIds[$index % count($availableProductIds)];
            }

            $calibratedRelations[] = [
                'skin_problem_id' => $relation['skin_problem_id'],
                'product_id'      => $realProductId,
            ];
        }

        // 5. Eksekusi insert massal yang aman 100%
        DB::table('problem_product')->insert($calibratedRelations);
    }
}