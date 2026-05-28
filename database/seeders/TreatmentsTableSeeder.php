<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TreatmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('treatments')->delete();
        
        \DB::table('treatments')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Cuci Muka 2 Kali Sehari',
                'description' => 'Cuci muka dengan pembersih yang lembut setiap pagi dan malam hari. Hindari menggosok wajah terlalu keras karena dapat memperparah jerawat.',
                'category' => 'daily_habit',
                'priority' => 10,
                'created_at' => '2026-05-08 08:17:49',
                'updated_at' => '2026-05-08 08:17:49',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Jangan Memencet Jerawat',
                'description' => 'Memencet jerawat dapat menyebabkan infeksi, peradangan lebih parah, dan meninggalkan bekas luka permanen.',
                'category' => 'avoidance',
                'priority' => 9,
                'created_at' => '2026-05-08 08:17:49',
                'updated_at' => '2026-05-08 08:17:49',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Ganti Sarung Bantal Secara Rutin',
                'description' => 'Ganti sarung bantal setiap 2-3 hari untuk mengurangi penumpukan bakteri dan minyak yang dapat menyebabkan jerawat.',
                'category' => 'hygiene',
                'priority' => 7,
                'created_at' => '2026-05-08 08:17:49',
                'updated_at' => '2026-05-08 08:17:49',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Hindari Air Panas Saat Mencuci Muka',
                'description' => 'Gunakan air hangat atau dingin saat mencuci muka. Air panas dapat menghilangkan minyak alami kulit dan membuat kulit semakin kering.',
                'category' => 'avoidance',
                'priority' => 8,
                'created_at' => '2026-05-08 08:17:49',
                'updated_at' => '2026-05-08 08:17:49',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Gunakan Pelembab Setelah Mencuci Muka',
            'description' => 'Aplikasikan pelembab segera setelah mencuci muka (dalam keadaan masih lembab) untuk mengunci kelembaban.',
                'category' => 'daily_habit',
                'priority' => 10,
                'created_at' => '2026-05-08 08:17:49',
                'updated_at' => '2026-05-08 08:17:49',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Hindari Mencuci Muka Terlalu Sering',
                'description' => 'Mencuci muka lebih dari 2 kali sehari dapat memicu produksi minyak berlebih sebagai respons kulit terhadap kekeringan.',
                'category' => 'avoidance',
                'priority' => 8,
                'created_at' => '2026-05-08 08:17:49',
                'updated_at' => '2026-05-08 08:17:49',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Gunakan Produk Non-Comedogenic',
                'description' => 'Pilih produk berlabel "non-comedogenic" yang tidak menyumbat pori-pori dan memicu jerawat.',
                'category' => 'product_choice',
                'priority' => 9,
                'created_at' => '2026-05-08 08:17:49',
                'updated_at' => '2026-05-08 08:17:49',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Eksfoliasi Secara Teratur',
                'description' => 'Lakukan eksfoliasi 1-2 kali seminggu menggunakan BHA atau AHA untuk membersihkan pori-pori dari komedo.',
                'category' => 'daily_habit',
                'priority' => 8,
                'created_at' => '2026-05-08 08:17:49',
                'updated_at' => '2026-05-08 08:17:49',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Hindari Produk dengan Pewangi dan Alkohol',
                'description' => 'Pilih produk skincare yang bebas pewangi, alkohol, dan bahan kimia keras lainnya yang dapat memicu iritasi.',
                'category' => 'product_choice',
                'priority' => 10,
                'created_at' => '2026-05-08 08:17:49',
                'updated_at' => '2026-05-08 08:17:49',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Gunakan Sunscreen Setiap Hari',
                'description' => 'Paparan sinar matahari dapat memperparah hiperpigmentasi. Gunakan sunscreen minimal SPF 30 setiap hari, bahkan di dalam ruangan.',
                'category' => 'protection',
                'priority' => 10,
                'created_at' => '2026-05-08 08:17:49',
                'updated_at' => '2026-05-08 08:17:49',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Hindari Sinar Matahari Langsung',
                'description' => 'Hindari paparan sinar matahari langsung terutama pada jam 10 pagi hingga 4 sore. Gunakan topi atau payung jika harus keluar rumah.',
                'category' => 'avoidance',
                'priority' => 9,
                'created_at' => '2026-05-08 08:17:49',
                'updated_at' => '2026-05-08 08:17:49',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Minum Air Putih yang Cukup',
                'description' => 'Minum minimal 8 gelas air per hari untuk menjaga hidrasi kulit dari dalam dan membantu proses detoksifikasi.',
                'category' => 'lifestyle',
                'priority' => 7,
                'created_at' => '2026-05-08 08:17:49',
                'updated_at' => '2026-05-08 08:17:49',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Istirahat dan Tidur yang Cukup',
                'description' => 'Tidur 7-9 jam setiap malam untuk memberikan waktu bagi kulit melakukan regenerasi sel dan memperbaiki jaringan yang rusak.',
                'category' => 'lifestyle',
                'priority' => 8,
                'created_at' => '2026-05-08 08:17:49',
                'updated_at' => '2026-05-08 08:17:49',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Kurangi Konsumsi Makanan Manis dan Berlemak',
                'description' => 'Makanan tinggi gula dan lemak dapat memicu peradangan dan memperparah masalah kulit seperti jerawat.',
                'category' => 'lifestyle',
                'priority' => 6,
                'created_at' => '2026-05-08 08:17:49',
                'updated_at' => '2026-05-08 08:17:49',
            ),
        ));
        
        
    }
}