<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analysis_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->json('analysis_data'); // Data gejala yang dipilih + bobot CF
            $table->foreignId('result_problem_id')->constrained('skin_problems')->onDelete('cascade');
            $table->decimal('confidence_score', 5, 2); // Nilai Certainty Factor
            $table->json('recommended_ingredients'); // Rekomendasi bahan aktif
            $table->json('recommended_products'); // Rekomendasi produk
            $table->json('recommended_treatments')->nullable(); // Rekomendasi perawatan
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analysis_histories');
    }
};