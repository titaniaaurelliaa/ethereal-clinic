<?php
// database/seeders/ProductSeeder.php

namespace Database\Seeders;

use App\Models\ProductModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // ==================== PRODUK TOPIKAL (KRIM/GEL) ====================
            [
                'name' => 'Evalen Gel',
                'brand' => 'Evalen',
                'category' => 'cream',
                'description' => 'Gel yang mengandung Adapalene 0,1% untuk pengobatan jerawat ringan hingga sedang. Adapalene adalah retinoid topikal yang bekerja dengan mengatur regenerasi sel kulit dan mengurangi peradangan pada jerawat.',
                'how_to_use' => 'Cuci tangan terlebih dahulu. Oleskan tipis-tipis pada area yang berjerawat setiap malam sebelum tidur. Hindari area mata, bibir, dan luka terbuka. Gunakan tabir surya di pagi hari karena kulit menjadi lebih sensitif terhadap sinar matahari.',
                'image_path' => 'images/product/evalen-gel.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Aklief Cream',
                'brand' => 'Galderma',
                'category' => 'cream',
                'description' => 'Krim yang mengandung Trifarotene 50mcg/g, retinoid generasi ke-4 untuk pengobatan jerawat di wajah dan tubuh. Trifarotene bekerja lebih selektif pada reseptor kulit sehingga efek samping iritasi lebih minimal.',
                'how_to_use' => 'Oleskan tipis-tipis pada area yang berjerawat satu kali sehari di malam hari. Gunakan pelembab yang sesuai dan tabir surya di pagi hari. Hasil optimal biasanya terlihat setelah 12 minggu pemakaian rutin.',
                'image_path' => 'images/product/aklief-cream.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ==================== PRODUK ORAL (KAPSUL/TABLET) ====================
            [
                'name' => 'Doxycycline Capsules',
                'brand' => 'Generik',
                'category' => 'obat',
                'description' => 'Kapsul Doxycycline 100mg, antibiotik golongan tetrasiklin untuk pengobatan jerawat sedang hingga berat. Doxycycline bekerja dengan menghambat pertumbuhan bakteri penyebab jerawat (Propionibacterium acnes) dan memiliki efek anti-inflamasi.',
                'how_to_use' => 'Konsumsi sesuai resep dokter (biasanya 1-2 kali sehari). Minum dengan segelas air penuh, jangan berbaring setelah minum untuk mencegah iritasi kerongkongan. Hindari konsumsi susu atau produk olahan susu 2 jam sebelum/sesudah minum obat.',
                'image_path' => 'images/product/doxycycline.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Isotretinoin Capsules',
                'brand' => 'Generik (Roaccutane)',
                'category' => 'obat',
                'description' => 'Kapsul Isotretinoin (10mg / 20mg), obat oral golongan retinoid untuk jerawat batu (nodulocystic acne) yang parah dan tidak merespon pengobatan lain. Isotretinoin adalah terapi lini terakhir dengan efek samping signifikan.',
                'how_to_use' => 'HARUS DENGAN RESEP DAN PENGAWASAN DOKTER SPESIALIS KULIT. Dosis disesuaikan dengan berat badan (biasanya 0.5-1mg/kgBB/hari). Konsumsi bersama makanan berlemak untuk absorbsi optimal. Harus melakukan kontrasepsi wajib bagi wanita usia subur.',
                'image_path' => 'images/product/isotretinoin.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ==================== PRODUK PEMBERSIH (CLEANSER) ====================
            [
                'name' => 'Senka Perfect Whip Acne Care',
                'brand' => 'Shiseido',
                'category' => 'cleanser',
                'description' => 'Pembersih wajah yang mengandung Salicylic Acid (Asam Salisilat) untuk mengatasi jerawat hingga ke pori-pori. Membantu membunuh bakteri penyebab jerawat dan mencegah timbulnya jerawat baru tanpa membuat kulit kering.',
                'how_to_use' => 'Basahi wajah dan tangan. Tuang secukupnya, tambah sedikit air, lalu busakan dengan gerakan memutar. Pijat lembut ke seluruh wajah, bilas hingga bersih dengan air. Gunakan pagi dan malam.',
                'image_path' => 'images/product/senka-acne-care.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Salicylic Acid 2% Face Wash',
                'brand' => 'The Ordinary',
                'category' => 'cleanser',
                'description' => 'Pembersih wajah dengan Salicylic Acid 2% konsentrasi tinggi untuk eksfoliasi kimiawi. Efektif untuk mengatasi jerawat, komedo, dan tekstur kulit tidak rata.',
                'how_to_use' => 'Gunakan 1-2 kali sehari. Busakan di telapak tangan, pijat lembut ke wajah selama 30-60 detik, lalu bilas. Gunakan tabir surya di pagi hari.',
                'image_path' => 'images/product/salicylic-acid-foam.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Neutrogena Oil-Free Acne Wash',
                'brand' => 'Neutrogena',
                'category' => 'cleanser',
                'description' => 'Pembersih wajah bebas minyak dengan Salicylic Acid 2% untuk mengobati dan mencegah jerawat. Formula yang lembut namun efektif membersihkan pori-pori tanpa mengiritasi kulit.',
                'how_to_use' => 'Gunakan 1-2 kali sehari. Basahi wajah, pijat lembut, lalu bilas hingga bersih. Hindari area mata.',
                'image_path' => 'images/product/neutrogena-acne-wash.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ==================== PRODUK TAMBAHAN (VARIASI DOSIS) ====================
            [
                'name' => 'Adapalene 0.1% Gel',
                'brand' => 'Differin',
                'category' => 'cream',
                'description' => 'Gel Adapalene 0.1% untuk pengobatan jerawat. Differin adalah salah satu merek paling dikenal untuk Adapalene, efektif untuk mengurangi jerawat dan komedo.',
                'how_to_use' => 'Oleskan tipis-tipis pada area berjerawat setiap malam. Mulai dengan pemakaian 2-3 kali seminggu untuk adaptasi, tingkatkan menjadi setiap malam jika kulit toleran.',
                'image_path' => 'images/product/differin-gel.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Isotretinoin 10mg',
                'brand' => 'Zenatane',
                'category' => 'obat',
                'description' => 'Isotretinoin dosis 10mg untuk terapi jerawat batu parah. Obat ini sangat efektif namun memiliki efek samping serius sehingga memerlukan monitoring ketat oleh dokter.',
                'how_to_use' => 'Minum sesuai resep dokter setelah makan. Perlu pemeriksaan darah rutin selama terapi. WANITA: HARUS MENGGUNAAN KONTRASEPSI EFEKTIF selama dan 1 bulan setelah terapi.',
                'image_path' => 'images/product/isotretinoin-10mg.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Doxycycline Hyclate 100mg',
                'brand' => 'Vibramycin',
                'category' => 'obat',
                'description' => 'Doxycycline Hyclate 100mg untuk infeksi bakteri termasuk jerawat. Bekerja dengan menghambat sintesis protein bakteri.',
                'how_to_use' => 'Minum 1-2 kapsul per hari sesuai resep. Jangan dikonsumsi bersama antasida atau suplemen zat besi.',
                'image_path' => 'images/product/vibramycin.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('products')->insert($products);
    }
}