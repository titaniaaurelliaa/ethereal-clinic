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
        Schema::table('problem_treatment', function (Blueprint $table) {
            $table->foreign(['problem_id'])->references(['id'])->on('skin_problems')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['treatment_id'])->references(['id'])->on('treatments')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('problem_treatment', function (Blueprint $table) {
            $table->dropForeign('problem_treatment_problem_id_foreign');
            $table->dropForeign('problem_treatment_treatment_id_foreign');
        });
    }
};
