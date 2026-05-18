<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Cuci Muka, Hindari Matahari, Pakai Sunscreen, dll
            $table->text('description'); // Penjelasan lengkap cara melakukan
            $table->string('category'); // daily_habit, avoidance, protection, lifestyle
            $table->string('icon')->nullable(); // Icon untuk UI
            $table->integer('priority')->default(0); // Prioritas rekomendasi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('treatments');
    }
};