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
    
    // 1. Relasi ke History (Sudah benar)
    public function analysisHistories()
    {
        return $this->hasMany(AnalysisHistoryModel::class, 'result_problem_id');
    }

    // 2. Relasi ke Product / Obat
 public function products()
{
    // Menggunakan ProductModel::class sesuai nama file asli kamu
    return $this->belongsToMany(ProductModel::class, 'problem_product', 'skin_problem_id', 'product_id');
}

    // 3. Relasi ke Treatment / Tindakan Klinik
    public function treatments()
    {
        // Kolom FK di tabel pivot problem_treatment adalah 'problem_id' (bukan 'skin_problem_id')
        return $this->belongsToMany(TreatmentModel::class, 'problem_treatment', 'problem_id', 'treatment_id');
    }
}