<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProblemSymptomModel extends Pivot
{
    protected $table = 'problem_symptom';
    
    protected $fillable = [
        'problem_id',
        'symptom_id'
    ];
}