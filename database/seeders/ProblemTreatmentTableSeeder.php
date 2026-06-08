<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProblemTreatmentTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('problem_treatment')->delete();
        
        \DB::table('problem_treatment')->insert(array (
            0 => 
            array (
                'id' => 1,
                'problem_id' => 4,
                'treatment_id' => 16,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            1 => 
            array (
                'id' => 2,
                'problem_id' => 4,
                'treatment_id' => 17,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            2 => 
            array (
                'id' => 3,
                'problem_id' => 3,
                'treatment_id' => 18,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            3 => 
            array (
                'id' => 4,
                'problem_id' => 1,
                'treatment_id' => 19,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            4 => 
            array (
                'id' => 5,
                'problem_id' => 7,
                'treatment_id' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            5 => 
            array (
                'id' => 6,
                'problem_id' => 8,
                'treatment_id' => 21,
                'created_at' => now(),
                'updated_at' => now(),
            ),
        )); 
    }
}