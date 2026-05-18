<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LifestyleRule extends Model
{
    use HasFactory;

    protected $table = 'lifestyle_rules';

    protected $fillable = [
        'kategori',
        'pilihan',
        'label',
        'cf_pakar',
    ];

    protected $casts = [
        'cf_pakar' => 'float',
    ];

    /**
     * Mencari rule berdasarkan kategori dan pilihan pengguna.
     */
    public static function findRule(string $kategori, string $pilihan): ?self
    {
        return static::where('kategori', $kategori)
            ->where('pilihan', $pilihan)
            ->first();
    }

    /**
     * Mengembalikan semua kategori yang tersedia (distinct).
     */
    public static function availableKategori(): array
    {
        return static::distinct()->pluck('kategori')->toArray();
    }
}
