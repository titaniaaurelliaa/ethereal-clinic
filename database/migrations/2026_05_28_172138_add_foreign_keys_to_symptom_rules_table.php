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
        Schema::table('symptom_rules', function (Blueprint $table) {
            $table->foreign(['knowledge_base_id'])->references(['id'])->on('knowledge_bases')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('symptom_rules', function (Blueprint $table) {
            $table->dropForeign('symptom_rules_knowledge_base_id_foreign');
        });
    }
};
