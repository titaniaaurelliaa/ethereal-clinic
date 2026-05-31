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
        Schema::create('symptom_rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('knowledge_base_id')->index('symptom_rules_knowledge_base_id_foreign');
            $table->string('pertanyaan');
            $table->double('cf_gejala', null, 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('symptom_rules');
    }
};
