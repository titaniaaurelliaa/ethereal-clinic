<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProblemProductTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('problem_product')->delete();
        
        \DB::table('problem_product')->insert(array (
            0 => 
            array (
                'skin_problem_id' => 4,
                'product_id' => 15,
            ),
            1 => 
            array (
                'skin_problem_id' => 1,
                'product_id' => 16,
            ),
            2 => 
            array (
                'skin_problem_id' => 2,
                'product_id' => 16,
            ),
            3 => 
            array (
                'skin_problem_id' => 3,
                'product_id' => 16,
            ),
            4 => 
            array (
                'skin_problem_id' => 4,
                'product_id' => 16,
            ),
            5 => 
            array (
                'skin_problem_id' => 5,
                'product_id' => 16,
            ),
            6 => 
            array (
                'skin_problem_id' => 6,
                'product_id' => 16,
            ),
            7 => 
            array (
                'skin_problem_id' => 7,
                'product_id' => 16,
            ),
            8 => 
            array (
                'skin_problem_id' => 8,
                'product_id' => 16,
            ),
            9 => 
            array (
                'skin_problem_id' => 1,
                'product_id' => 17,
            ),
            10 => 
            array (
                'skin_problem_id' => 7,
                'product_id' => 17,
            ),
            11 => 
            array (
                'skin_problem_id' => 8,
                'product_id' => 17,
            ),
            12 => 
            array (
                'skin_problem_id' => 7,
                'product_id' => 18,
            ),
            13 => 
            array (
                'skin_problem_id' => 4,
                'product_id' => 19,
            ),
            14 => 
            array (
                'skin_problem_id' => 4,
                'product_id' => 20,
            ),
            15 => 
            array (
                'skin_problem_id' => 4,
                'product_id' => 21,
            ),
            16 => 
            array (
                'skin_problem_id' => 4,
                'product_id' => 22,
            ),
            17 => 
            array (
                'skin_problem_id' => 7,
                'product_id' => 23,
            ),
            18 => 
            array (
                'skin_problem_id' => 1,
                'product_id' => 24,
            ),
            19 => 
            array (
                'skin_problem_id' => 7,
                'product_id' => 24,
            ),
            20 => 
            array (
                'skin_problem_id' => 8,
                'product_id' => 24,
            ),
        ));
    }
}