<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentModel extends Model
{
    protected $table = 'treatments';
    
    protected $fillable = [
        'name',
        'description',
        'category',
        'priority'
    ];
    
    public function skinProblems()
    {
        return $this->belongsToMany(SkinProblemModel::class, 'problem_treatment', 'treatment_id', 'problem_id');
    }
}