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
                'problem_id' => 2,
                'treatment_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'problem_id' => 3,
                'treatment_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'problem_id' => 3,
                'treatment_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'problem_id' => 5,
                'treatment_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'problem_id' => 7,
                'treatment_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'problem_id' => 8,
                'treatment_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}