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
        Schema::create('analysis_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('analysis_histories_user_id_foreign');
            $table->json('analysis_data');
            $table->unsignedBigInteger('result_problem_id')->index('analysis_histories_result_problem_id_foreign');
            $table->decimal('confidence_score', 5);
            $table->json('recommended_ingredients');
            $table->json('recommended_products');
            $table->json('recommended_treatments')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analysis_histories');
    }
};
