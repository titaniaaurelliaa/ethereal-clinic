<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentModel extends Model
{
    protected $table = 'treatments';

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Treatment yang diindikasikan untuk Masalah Kulit tertentu.
     *
     * GAP 3 — Explicit pivot FK binding (ASYMMETRIC SCHEMA):
     * Pivot table : problem_treatment
     * FK (this)   : treatment_id  (column referencing treatments.id)
     * FK (related): problem_id    (column referencing skin_problems.id)
     *
     * IMPORTANT: This pivot uses 'problem_id' — NOT 'skin_problem_id'.
     * This is an intentional schema asymmetry confirmed against the live DB.
     */
    public function skinProblems()
    {
        return $this->belongsToMany(
            SkinProblemModel::class,
            'problem_treatment',  // pivot table
            'treatment_id',       // FK for TreatmentModel on pivot
            'problem_id'          // FK for SkinProblemModel on pivot (NOT skin_problem_id)
        );
    }
}