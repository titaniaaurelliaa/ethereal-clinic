<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel symptom_rules menyimpan pertanyaan anamnesis kontekstual (Subjective)
     * yang diajukan kepada pengguna setelah AI mendeteksi objek kulit tertentu di Step 1.
     *
     * Setiap rule terikat pada satu entri knowledge_bases (objek terdeteksi + tingkat keparahan)
     * sehingga pertanyaan bersifat dinamis dan kontekstual, bukan statis.
     *
     * Tabel ini berjalan BERDAMPINGAN dengan lifestyle_rules dan knowledge_bases —
     * tidak ada perubahan struktur pada tabel yang sudah ada.
     */
    public function up(): void
    {
        Schema::create('symptom_rules', function (Blueprint $table) {
            $table->id();

            // Foreign key ke tabel knowledge_bases (parent: nama objek + keparahan)
            // Cascade delete: jika knowledge_base dihapus, rule turunannya ikut terhapus.
            $table->foreignId('knowledge_base_id')
                  ->constrained('knowledge_bases')
                  ->onDelete('cascade');

            // Teks pertanyaan anamnesis yang ditampilkan ke pengguna
            // Contoh: "Apakah benjolan terasa nyeri atau panas?"
            $table->string('pertanyaan');

            // CF Gejala: bobot keyakinan pakar terhadap gejala subjektif ini (0.0 – 1.0)
            // Digunakan oleh Certainty Factor engine untuk menggabungkan skor anamnesis.
            $table->double('cf_gejala');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('symptom_rules');
    }
};
