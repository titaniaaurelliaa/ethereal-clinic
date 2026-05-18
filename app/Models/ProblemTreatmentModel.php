<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProblemTreatmentModel extends Pivot
{
    protected $table = 'problem_treatment';
    
    protected $fillable = [
        'problem_id',
        'treatment_id'
    ];
}