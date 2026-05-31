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
                'skin_problem_id' => 1,
                'product_id' => 1,
            ),
            1 => 
            array (
                'skin_problem_id' => 4,
                'product_id' => 1,
            ),
            2 => 
            array (
                'skin_problem_id' => 1,
                'product_id' => 2,
            ),
            3 => 
            array (
                'skin_problem_id' => 2,
                'product_id' => 2,
            ),
            4 => 
            array (
                'skin_problem_id' => 3,
                'product_id' => 3,
            ),
            5 => 
            array (
                'skin_problem_id' => 6,
                'product_id' => 4,
            ),
            6 => 
            array (
                'skin_problem_id' => 1,
                'product_id' => 5,
            ),
            7 => 
            array (
                'skin_problem_id' => 2,
                'product_id' => 5,
            ),
            8 => 
            array (
                'skin_problem_id' => 3,
                'product_id' => 5,
            ),
            9 => 
            array (
                'skin_problem_id' => 4,
                'product_id' => 5,
            ),
            10 => 
            array (
                'skin_problem_id' => 5,
                'product_id' => 5,
            ),
            11 => 
            array (
                'skin_problem_id' => 6,
                'product_id' => 5,
            ),
            12 => 
            array (
                'skin_problem_id' => 7,
                'product_id' => 5,
            ),
            13 => 
            array (
                'skin_problem_id' => 8,
                'product_id' => 5,
            ),
        ));
        
        
    }
}