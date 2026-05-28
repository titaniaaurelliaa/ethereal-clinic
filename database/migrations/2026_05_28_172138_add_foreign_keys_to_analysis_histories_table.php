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
        Schema::table('analysis_histories', function (Blueprint $table) {
            $table->foreign(['result_problem_id'])->references(['id'])->on('skin_problems')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('analysis_histories', function (Blueprint $table) {
            $table->dropForeign('analysis_histories_result_problem_id_foreign');
            $table->dropForeign('analysis_histories_user_id_foreign');
        });
    }
};
