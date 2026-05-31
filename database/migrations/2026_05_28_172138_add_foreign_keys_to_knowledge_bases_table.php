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
        Schema::table('knowledge_bases', function (Blueprint $table) {
            $table->foreign(['skin_problem_id'])->references(['id'])->on('skin_problems')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('knowledge_bases', function (Blueprint $table) {
            $table->dropForeign('knowledge_bases_skin_problem_id_foreign');
        });
    }
};
