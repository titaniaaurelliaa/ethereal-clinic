<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkinProblemModel extends Model
{
    protected $table = 'skin_problems';
    
    protected $fillable = [
        'name',
        'description',
        'severity_level'
    ];
    
    public function symptoms()
    {
        return $this->belongsToMany(SymptomModel::class, 'problem_symptom', 'problem_id', 'symptom_id');
    }
    
    public function treatments()
    {
        return $this->belongsToMany(TreatmentModel::class, 'problem_treatment', 'problem_id', 'treatment_id');
    }
    
    public function analysisHistories()
    {
        return $this->hasMany(AnalysisHistoryModel::class, 'result_problem_id');
    }
}