<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SymptomModel extends Model
{
    protected $table = 'symptoms';
    
    protected $fillable = [
        'name',
        'description'
    ];
    
    public function skinProblems()
    {
        return $this->belongsToMany(SkinProblemModel::class, 'problem_symptom', 'symptom_id', 'problem_id');
    }
}