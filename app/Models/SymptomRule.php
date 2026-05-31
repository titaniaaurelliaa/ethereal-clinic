<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SymptomRule extends Model
{
    use HasFactory;

    protected $table = 'symptom_rules';

    protected $fillable = [
        'knowledge_base_id',
        'pertanyaan',
        'cf_gejala',
    ];

    protected $casts = [
        'knowledge_base_id' => 'integer',
        'cf_gejala'         => 'float',
    ];

    // ──────────────────────────────────────────────────
    // Relasi
    // ──────────────────────────────────────────────────

    /**
     * Setiap SymptomRule (pertanyaan anamnesis) milik satu KnowledgeBase.
     * Relasi ini memungkinkan kita mengetahui objek/tingkat keparahan apa
     * yang memicu pertanyaan ini.
     */
    public function knowledgeBase(): BelongsTo
    {
        return $this->belongsTo(KnowledgeBase::class, 'knowledge_base_id');
    }

    // ──────────────────────────────────────────────────
    // Query Helpers
    // ──────────────────────────────────────────────────

    /**
     * Mengambil semua pertanyaan anamnesis yang relevan untuk satu
     * KnowledgeBase tertentu (berdasarkan ID-nya).
     *
     * Digunakan oleh engine anamnesis di Step 2 setelah AI melakukan deteksi.
     *
     * @param  int  $knowledgeBaseId
     * @return \Illuminate\Database\Eloquent\Collection<int, static>
     */
    public static function forKnowledgeBase(int $knowledgeBaseId): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('knowledge_base_id', $knowledgeBaseId)->get();
    }
}
