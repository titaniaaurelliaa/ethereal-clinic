<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SymptomRulesTableSeeder extends Seeder
{

    /**
     * Seed tabel symptom_rules menggunakan teknik string matching dinamis.
     *
     * knowledge_base_id ditentukan secara otomatis dari tabel knowledge_bases
     * berdasarkan pencocokan nama_objek + tingkat_keparahan, sehingga tidak
     * bergantung pada ID statis yang bisa berubah.
     *
     * @return void
     */
    public function run()
    {
        // Ambil peta ID dari database untuk mencocokkan nama_objek + tingkat_keparahan secara akurat
        $kbMap = \DB::table('knowledge_bases')
            ->select('id', 'nama_objek', 'tingkat_keparahan')
            ->get()
            ->groupBy(['nama_objek', 'tingkat_keparahan']);

        $symptomData = [
            // --- KELOMPOK GEJALA: JERAWAT ---
            ['objek' => 'Jerawat', 'keparahan' => 'Ringan', 'tanya' => 'Muncul benjolan kecil berwarna kemerahan di permukaan kulit', 'cf' => 0.8],
            ['objek' => 'Jerawat', 'keparahan' => 'Ringan', 'tanya' => 'Pori-pori kulit tampak membesar dan terbuka di sekitar area kemerahan', 'cf' => 0.6],
            ['objek' => 'Jerawat', 'keparahan' => 'Sedang', 'tanya' => 'Menunjukkan adanya tanda peradangan aktif pada kulit wajah', 'cf' => 0.7],
            ['objek' => 'Jerawat', 'keparahan' => 'Sedang', 'tanya' => 'Benjolan merah dengan puncak berwarna putih atau kekuningan (mengandung nanah ringan)', 'cf' => 0.8],
            ['objek' => 'Jerawat', 'keparahan' => 'Parah', 'tanya' => 'Mengandung nanah yang banyak dan menyebar di beberapa area wajah', 'cf' => 0.8],

            // --- KELOMPOK GEJALA: KOMEDO HITAM ---
            ['objek' => 'Komedo Hitam', 'keparahan' => 'Ringan', 'tanya' => 'Terdapat bintik kecil berwarna hitam pada permukaan pori-pori kulit', 'cf' => 0.2],
            ['objek' => 'Komedo Hitam', 'keparahan' => 'Ringan', 'tanya' => 'Tidak disertai rasa nyeri atau tanda peradangan di sekitarnya', 'cf' => 0.6],
            ['objek' => 'Komedo Hitam', 'keparahan' => 'Sedang', 'tanya' => 'Umumnya muncul berkerumun pada area hidung, dahi, dan dagu', 'cf' => 0.3],

            // --- KELOMPOK GEJALA: KOMEDO PUTIH ---
            ['objek' => 'Komedo Putih', 'keparahan' => 'Ringan', 'tanya' => 'Muncul benjolan kecil berwarna putih atau sewarna dengan kulit (tersumbat)', 'cf' => 0.8],
            ['objek' => 'Komedo Putih', 'keparahan' => 'Ringan', 'tanya' => 'Pori-pori tersumbat namun kondisinya tertutup oleh lapisan kulit tipis', 'cf' => 0.6],
            ['objek' => 'Komedo Putih', 'keparahan' => 'Sedang', 'tanya' => 'Tidak menimbulkan rasa gatal ataupun rasa nyeri saat disentuh', 'cf' => 0.5],
            ['objek' => 'Komedo Putih', 'keparahan' => 'Sedang', 'tanya' => 'Umumnya muncul di area wajah yang cenderung berminyak tinggi', 'cf' => 0.3],

            // --- KELOMPOK GEJALA: BEKAS JERAWAT ---
            ['objek' => 'Bekas Jerawat', 'keparahan' => 'Sedang', 'tanya' => 'Meninggalkan noda kecokelatan atau kemerahan setelah jerawat kempes', 'cf' => 0.6],
            ['objek' => 'Bekas Jerawat', 'keparahan' => 'Sedang', 'tanya' => 'Permukaan tekstur kulit terasa tidak rata saat diraba', 'cf' => 0.5],

            // --- KELOMPOK GEJALA: KISTA (CYSTIC ACNE) ---
            ['objek' => 'Kista', 'keparahan' => 'Ringan', 'tanya' => 'Benjolan berukuran besar, keras, dan tertanam jauh di bawah jaringan kulit', 'cf' => 0.8],
            ['objek' => 'Kista', 'keparahan' => 'Sedang', 'tanya' => 'Terasa sangat nyeri, berdenyut, dan meradang hebat meskipun tidak disentuh', 'cf' => 0.6],
            ['objek' => 'Kista', 'keparahan' => 'Sedang', 'tanya' => 'Benjolan besar berisi cairan atau nanah di bawah permukaan kulit wajah', 'cf' => 0.8],
            ['objek' => 'Kista', 'keparahan' => 'Parah', 'tanya' => 'Nyeri hebat, peradangan meluas, dan ukuran jerawat relatif besar serta lunak (karena akumulasi infeksi)', 'cf' => 0.6],
        ];

        $inserts = [];
        foreach ($symptomData as $data) {
            // Ambil ID secara dinamis dari map database
            $kbId = $kbMap[$data['objek']][$data['keparahan']][0]->id ?? null;

            if ($kbId) {
                $inserts[] = [
                    'knowledge_base_id' => $kbId,
                    'pertanyaan'        => $data['tanya'],
                    'cf_pakar'          => $data['cf'],
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ];
            }
        }

        \DB::table('symptom_rules')->delete();
        \DB::table('symptom_rules')->insert($inserts);
    }
}