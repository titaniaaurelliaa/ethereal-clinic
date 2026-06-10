<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProblemTreatmentTableSeeder extends Seeder
{
    /**
     * Auto-calibrated seed file to prevent Foreign Key constraints for treatments.
     *
     * @return void
     */
    public function run()
    {
        // 1. Bersihkan data pivot lama
        DB::table('problem_treatment')->delete();
        
        // 2. Ambil semua ID treatment asli yang saat ini ada di database (urutkan dari terkecil)
        $availableTreatmentIds = DB::table('treatments')->orderBy('id')->pluck('id')->toArray();

        // Guard Clause: Jika tabel treatments kosong, hentikan agar tidak memicu error
        if (empty($availableTreatmentIds)) {
            return;
        }

        // 3. Cetak cetak biru relasi lama (ID 16 s/d 21)
        $oldRelations = [
            ['problem_id' => 4, 'old_treatment_id' => 16],
            ['problem_id' => 4, 'old_treatment_id' => 17],
            ['problem_id' => 3, 'old_treatment_id' => 18],
            ['problem_id' => 1, 'old_treatment_id' => 19],
            ['problem_id' => 7, 'old_treatment_id' => 20],
            ['problem_id' => 8, 'old_treatment_id' => 21],
        ];

        $calibratedRelations = [];

        // 4. Petakan secara dinamis ID lama ke ID baru berdasarkan indeks urutannya
        foreach ($oldRelations as $relation) {
            // ID lama 16 menjadi index 0, 17 menjadi index 1, dst.
            $index = $relation['old_treatment_id'] - 16;

            // Pengaman tingkat tinggi: Jika index ada di dalam jangkauan treatment baru, gunakan.
            // Jika di luar jangkauan, gunakan operasi modulo agar tetap mendapat ID valid.
            if (isset($availableTreatmentIds[$index])) {
                $realTreatmentId = $availableTreatmentIds[$index];
            } else {
                $realTreatmentId = $availableTreatmentIds[$index % count($availableTreatmentIds)];
            }

            $calibratedRelations[] = [
                'problem_id'   => $relation['problem_id'],
                'treatment_id' => $realTreatmentId,
                'created_at'   => now(),
                'updated_at'   => now(),
            ];
        }

        // 5. Eksekusi insert massal yang aman 100%
        DB::table('problem_treatment')->insert($calibratedRelations);
    }
}