<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'skin_type',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    /**
     * Relasi One-to-Many ke tabel analysis_histories
     */
    public function analysisHistories()
    {
        return $this->hasMany(AnalysisHistoryModel::class, 'user_id', 'id');
    }
    
    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
    /**
     * Cek apakah user adalah pasien
     */
    public function isPasien()
    {
        return $this->role === 'pasien';
    }

    public function latestAnalysisHistory()
    {
        return $this->hasOne(AnalysisHistoryModel::class, 'user_id', 'id')
                    ->whereRaw('analysis_histories.id = (SELECT MAX(inner_ah.id) FROM analysis_histories inner_ah WHERE inner_ah.user_id = analysis_histories.user_id)');
    }
}