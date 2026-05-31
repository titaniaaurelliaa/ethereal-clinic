<?php

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
    ];

    /**
     * Produk yang diindikasikan untuk Masalah Kulit tertentu.
     *
     * GAP 3 — Explicit pivot FK binding:
     * Pivot table : problem_product
     * FK (this)   : product_id       (column referencing products.id)
     * FK (related): skin_problem_id  (column referencing skin_problems.id)
     */
    public function skinProblems()
    {
        return $this->belongsToMany(
            SkinProblemModel::class,
            'problem_product',  // pivot table
            'product_id',       // FK for ProductModel on pivot
            'skin_problem_id'   // FK for SkinProblemModel on pivot
        );
    }
}