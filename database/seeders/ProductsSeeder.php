<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Produk untuk Jerawat (problem_id = 1)
            [
                'name' => 'Facial Wash Salicylic Acid',
                'brand' => 'Avoskin',
                'category' => 'facial_wash',
                'description' => 'Pembersih wajah dengan kandungan Salicylic Acid yang membantu membersihkan jerawat dan mencegah timbulnya jerawat baru. Cocok untuk kulit berjerawat dan berminyak.',
                'image_path' => 'public/images/product/avoskin-salicylic.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Acne Spot Treatment',
                'brand' => 'Emina',
                'category' => 'treatment',
                'description' => 'Krim khusus untuk mengeringkan jerawat dengan cepat. Mengandung tea tree oil dan zinc yang membantu mengurangi peradangan.',
                'image_path' => 'public/images/product/emina-spot-treatment.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Azelaic Acid Serum',
                'brand' => 'Anua',
                'category' => 'serum',
                'description' => 'Serum dengan Azelaic Acid yang membantu mencerahkan bekas jerawat dan mengurangi kemerahan. Aman untuk kulit sensitif.',
                'image_path' => 'public/images/product/anua-azelaic.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Produk untuk Kulit Kering (problem_id = 2)
            [
                'name' => 'Hydrating Moisturizer',
                'brand' => 'Skintific',
                'category' => 'moisturizer',
                'description' => 'Pelembab dengan kandungan hyaluronic acid dan ceramide yang menghidrasi kulit kering sepanjang hari. Tekstur ringan dan tidak lengket.',
                'image_path' => 'public/images/product/skintific-hydrating.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gentle Cleansing Milk',
                'brand' => 'Wardah',
                'category' => 'facial_wash',
                'description' => 'Pembersih wajah berbasis susu yang lembut dan tidak menghilangkan kelembaban alami kulit. Cocok untuk kulit kering dan sensitif.',
                'image_path' => 'public/images/product/wardah-cleansing-milk.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Produk untuk Kulit Berminyak (problem_id = 3)
            [
                'name' => 'Niacinamide Serum',
                'brand' => 'The Originote',
                'category' => 'serum',
                'description' => 'Serum dengan Niacinamide 10% yang membantu mengontrol minyak berlebih dan mengecilkan pori-pori.',
                'image_path' => 'public/images/product/originote-niacinamide.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Oil Control Moisturizer',
                'brand' => 'Garnier',
                'category' => 'moisturizer',
                'description' => 'Pelembab ringan yang mengontrol minyak tanpa membuat kulit kering. Mengandung salicylic acid untuk mencegah jerawat.',
                'image_path' => 'public/images/product/garnier-oil-control.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Produk untuk Komedo (problem_id = 4)
            [
                'name' => 'BHA Exfoliant',
                'brand' => 'Paula\'s Choice',
                'category' => 'exfoliant',
                'description' => 'Eksfoliator cair dengan BHA 2% yang membersihkan pori-pori dan mengangkat komedo hitam maupun putih.',
                'image_path' => 'public/images/product/paulas-choice-bha.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pore Strip',
                'brand' => 'Pimplo',
                'category' => 'treatment',
                'description' => 'Striper pori-pori yang efektif mengangkat komedo hitam di area hidung dan dagu.',
                'image_path' => 'public/images/product/pimplo-pore-strip.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Produk untuk Kulit Sensitif (problem_id = 5)
            [
                'name' => 'Cica Repair Serum',
                'brand' => 'Azarine',
                'category' => 'serum',
                'description' => 'Serum dengan Centella Asiatica (Cica) yang menenangkan kulit merah dan iritasi. Membantu memperbaiki skin barrier.',
                'image_path' => 'public/images/product/azarine-cica.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Produk untuk Hiperpigmentasi (problem_id = 6)
            [
                'name' => 'Vitamin C Serum',
                'brand' => 'Luxcrime',
                'category' => 'serum',
                'description' => 'Serum vitamin C 15% yang mencerahkan bekas jerawat dan meratakan warna kulit.',
                'image_path' => 'public/images/product/luxcrime-vitc.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Produk untuk Semua Jenis Kulit (Sunscreen)
            [
                'name' => 'Sunscreen SPF 50 PA++++',
                'brand' => 'Skin Aqua',
                'category' => 'sunscreen',
                'description' => 'Tabir surya ringan dengan SPF 50 PA++++ yang melindungi kulit dari sinar UV tanpa meninggalkan whitecast.',
                'image_path' => 'public/images/product/skinaqua-sunscreen.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('products')->insert($products);
    }
}