<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('symptom_rules', function (Blueprint $table) {
            // Rename kolom cf_gejala menjadi cf_pakar
            $table->renameColumn('cf_gejala', 'cf_pakar');
        });
    }

    public function down(): void
    {
        Schema::table('symptom_rules', function (Blueprint $table) {
            $table->renameColumn('cf_pakar', 'cf_gejala');
        });
    }
};