<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalysisHistoryModel extends Model
{
    protected $table = 'analysis_histories';
    
    protected $fillable = [
        'user_id',
        'analysis_data',
        'result_problem_id',
        'confidence_score',
        'recommended_ingredients',
        'recommended_products',
        'recommended_treatments',
        'notes'
    ];
    
    protected $casts = [
        'analysis_data' => 'array',
        'recommended_ingredients' => 'array',
        'recommended_products' => 'array',
        'recommended_treatments' => 'array',
        'confidence_score' => 'decimal:2'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function skinProblem()
    {
        return $this->belongsTo(SkinProblemModel::class, 'result_problem_id');
    }
}