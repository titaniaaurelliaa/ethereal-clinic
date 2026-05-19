<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KnowledgeBase extends Model
{
    use HasFactory;

    protected $table = 'knowledge_bases';

    protected $fillable = [
        'nama_objek',
        'tingkat_keparahan',
        'min_objek',
        'max_objek',
        'cf_pakar',
    ];

    protected $casts = [
        'min_objek'  => 'integer',
        'max_objek'  => 'integer',
        'cf_pakar'   => 'float',
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

    // ──────────────────────────────────────────────────
    // Relasi
    // ──────────────────────────────────────────────────

    /**
     * Satu KnowledgeBase (objek + tingkat keparahan) dapat memiliki banyak
     * pertanyaan anamnesis (SymptomRule) yang akan diajukan ke pengguna
     * secara kontekstual setelah AI mendeteksi kondisi tersebut.
     */
    public function symptomRules(): HasMany
    {
        return $this->hasMany(SymptomRule::class, 'knowledge_base_id');
    }
    public function skinProblem()
{
    // Relasi: Satu Knowledge Base merujuk pada Satu Penyakit Kulit
    return $this->belongsTo(SkinProblemModel::class, 'skin_problem_id');
}
}
