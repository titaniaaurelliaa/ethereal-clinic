<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Hapus tabel lama (Drop tabel pivot dulu untuk menghindari error Foreign Key, baru master)
        Schema::dropIfExists('problem_symptom');
        Schema::dropIfExists('symptoms');

        // 2. Buat tabel pivot baru untuk Penyakit <-> Produk(Obat)
        Schema::create('problem_product', function (Blueprint $table) {
            $table->foreignId('skin_problem_id')->constrained('skin_problems')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            
            // Jadikan gabungan keduanya sebagai Primary Key agar tidak ada data duplikat
            $table->primary(['skin_problem_id', 'product_id']);
        });

        // 3. Tambahkan Foreign Key di knowledge_bases
        Schema::table('knowledge_bases', function (Blueprint $table) {
            // Ditambahkan setelah kolom ID agar posisinya rapi di database
            $table->foreignId('skin_problem_id')->nullable()->after('id')
                  ->constrained('skin_problems')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan (Hapus) kolom knowledge_bases jika di-rollback
        Schema::table('knowledge_bases', function (Blueprint $table) {
            $table->dropForeign(['skin_problem_id']);
            $table->dropColumn('skin_problem_id');
        });

        // Hapus pivot baru
        Schema::dropIfExists('problem_product');

        // Recreate tabel lama jika di-rollback
        Schema::create('symptoms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('problem_symptom', function (Blueprint $table) {
            $table->foreignId('skin_problem_id')->constrained('skin_problems')->cascadeOnDelete();
            $table->foreignId('symptom_id')->constrained('symptoms')->cascadeOnDelete();
            $table->primary(['skin_problem_id', 'symptom_id']);
        });
    }
};