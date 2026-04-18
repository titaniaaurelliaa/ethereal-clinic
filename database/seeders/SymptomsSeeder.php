<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SymptomsSeeder extends Seeder
{
    public function run(): void
    {
        $symptoms = [
            // Gejala Jerawat
            [
                'name' => 'Muncul benjolan merah pada wajah',
                'description' => 'Benjolan kecil berwarna merah yang terasa sakit saat disentuh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ada bintik putih di permukaan kulit',
                'description' => 'Bintik kecil berwarna putih seperti ujung jerawat yang matang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wajah terasa sakit jika disentuh',
                'description' => 'Area kulit terasa nyeri atau tidak nyaman saat ditekan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ada benjolan besar dan dalam di kulit',
                'description' => 'Benjolan besar yang terasa keras dan berada di dalam kulit (jerawat batu/kista)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Gejala Kulit Kering
            [
                'name' => 'Kulit terasa kasar seperti pasir',
                'description' => 'Tekstur kulit tidak halus saat diraba, terasa berbutir',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kulit mengelupas atau bersisik',
                'description' => 'Ada serpihan kulit halus yang terkelupas dari permukaan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kulit terasa kencang setelah mencuci muka',
                'description' => 'Wajah terasa tertarik dan tidak nyaman setelah dibersihkan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kulit terasa gatal',
                'description' => 'Rasa gatal pada area kulit tertentu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Gejala Kulit Berminyak
            [
                'name' => 'Wajah terlihat mengkilap',
                'description' => 'Permukaan wajah tampak berkilau terutama di area T-zone (dahi, hidung, dagu)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pori-pori terlihat besar',
                'description' => 'Lubang pori-pori tampak jelas dan membesar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Makeup cepat luntur',
                'description' => 'Riasan wajah tidak tahan lama dan mudah bergeser',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Gejala Komedo
            [
                'name' => 'Ada bintik hitam di pori-pori',
                'description' => 'Titik-titik hitam kecil di area hidung, dagu, atau dahi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ada bintik putih di pori-pori tertutup',
                'description' => 'Benjolan kecil berwarna putih di bawah permukaan kulit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Gejala Kulit Sensitif
            [
                'name' => 'Kulit mudah memerah',
                'description' => 'Kulit menjadi kemerahan setelah menggunakan produk baru atau terkena suhu ekstrem',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kulit terasa perih saat pakai produk',
                'description' => 'Rasa panas atau menyengat saat mengaplikasikan skincare',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Gejala Hiperpigmentasi
            [
                'name' => 'Ada bercak gelap di wajah',
                'description' => 'Area kulit yang lebih gelap dibandingkan warna kulit sekitarnya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bekas jerawat berwarna coklat kehitaman',
                'description' => 'Bekas jerawat yang meninggalkan noda gelap',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Gejala Penuaan Dini
            [
                'name' => 'Muncul garis-garis halus di wajah',
                'description' => 'Garis tipis yang muncul di sekitar mata, dahi, atau mulut',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kulit wajah terasa kendur',
                'description' => 'Kulit kehilangan kekencangan dan elastisitasnya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('symptoms')->insert($symptoms);
    }
}