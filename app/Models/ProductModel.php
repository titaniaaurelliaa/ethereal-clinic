<?php
// app/Models/ProductModel.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'brand',
        'category',
        'description',
        'image_path',
        'how_to_use',
    ];

    /**
     * Produk yang diindikasikan untuk Masalah Kulit tertentu.
     */
    public function skinProblems()
    {
        return $this->belongsToMany(
            SkinProblemModel::class,
            'problem_product',
            'product_id',
            'skin_problem_id'
        );
    }
}