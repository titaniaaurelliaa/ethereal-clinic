<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel knowledge_bases menyimpan bobot medis (CF Pakar) untuk setiap
     * jenis objek jerawat berdasarkan tingkat keparahannya.
     * Digunakan oleh Certainty Factor engine untuk analisis kulit berbasis kamera.
     */
    public function up(): void
    {
        Schema::create('knowledge_bases', function (Blueprint $table) {
            $table->id();

            // Nama objek jerawat yang terdeteksi (misal: Jerawat, Komedo Hitam, Komedo Putih, dsb.)
            $table->string('nama_objek', 100);

            // Tingkat keparahan kondisi (Ringan, Sedang, Parah)
            $table->enum('tingkat_keparahan', ['Ringan', 'Sedang', 'Parah']);

            // Rentang jumlah objek minimum yang masuk pada tingkat keparahan ini
            $table->unsignedSmallInteger('min_objek');

            // Rentang jumlah objek maksimum (NULL = tidak terbatas / "> n")
            $table->unsignedSmallInteger('max_objek')->nullable();

            // CF Pakar: bobot keyakinan pakar (0.0 – 1.0)
            $table->float('cf_pakar', 4, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('knowledge_bases');
    }
};
