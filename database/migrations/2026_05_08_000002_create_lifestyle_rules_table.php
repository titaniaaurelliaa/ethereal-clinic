<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel lifestyle_rules menyimpan bobot gaya hidup (CF Pakar) untuk
     * setiap kategori kebiasaan pengguna. Digunakan untuk menggabungkan
     * faktor gaya hidup ke dalam hasil analisis kulit hybrid.
     */
    public function up(): void
    {
        Schema::create('lifestyle_rules', function (Blueprint $table) {
            $table->id();

            // Kategori gaya hidup: Tidur, Stres, Air, Diet, Sinar Matahari
            $table->string('kategori', 50);

            // Kunci pilihan internal (Low, Moderate, High)
            $table->string('pilihan', 30);

            // Label tampilan yang ditampilkan ke pengguna (Bahasa Indonesia)
            $table->string('label', 100);

            // CF Pakar: kontribusi gaya hidup terhadap risiko jerawat (0.0 – 1.0)
            $table->float('cf_pakar', 4, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lifestyle_rules');
    }
};
