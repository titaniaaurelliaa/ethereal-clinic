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
        'image_path'
    ];
}