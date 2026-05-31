<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KnowledgeBase extends Model
{
    use HasFactory;

    protected $table = 'knowledge_bases';

    protected $fillable = [
        'skin_problem_id',
        'nama_objek',
        'tingkat_keparahan',
        'min_objek',
        'max_objek',
        'cf_pakar',
    ];

    protected $casts = [
        'skin_problem_id' => 'integer',
        'min_objek'       => 'integer',
        'max_objek'       => 'integer',
        'cf_pakar'        => 'float',
    ];

    /**
     * Mencari rule yang sesuai berdasarkan nama objek dan jumlah deteksi.
     * Mengembalikan KnowledgeBase pertama yang cocok (min <= count <= max).
     */
    public static function findRule(string $namaObjek, int $jumlah): ?self
    {
        return static::where('nama_objek', $namaObjek)
            ->where('min_objek', '<=', $jumlah)
            ->where(function ($q) use ($jumlah) {
                $q->whereNull('max_objek')
                  ->orWhere('max_objek', '>=', $jumlah);
            })
            ->first();
    }

    // ──────────────────────────────────────────────────────────────────────
    // Relations
    // ──────────────────────────────────────────────────────────────────────

    /**
     * Satu KnowledgeBase merujuk pada Satu Penyakit Kulit.
     */
    public function skinProblem(): BelongsTo
    {
        return $this->belongsTo(SkinProblemModel::class, 'skin_problem_id');
    }

    /**
     * Satu KnowledgeBase dapat memiliki banyak pertanyaan anamnesis (SymptomRule).
     */
    public function symptomRules(): HasMany
    {
        return $this->hasMany(SymptomRule::class, 'knowledge_base_id');
    }
}
