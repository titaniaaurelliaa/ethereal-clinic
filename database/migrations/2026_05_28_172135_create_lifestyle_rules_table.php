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
        Schema::create('lifestyle_rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kategori', 50);
            $table->string('pilihan', 30);
            $table->string('label', 100);
            $table->double('cf_pakar', 4, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lifestyle_rules');
    }
};
