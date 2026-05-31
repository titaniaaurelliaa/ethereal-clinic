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
        Schema::create('problem_product', function (Blueprint $table) {
            $table->unsignedBigInteger('skin_problem_id');
            $table->unsignedBigInteger('product_id')->index('problem_product_product_id_foreign');

            $table->primary(['skin_problem_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('problem_product');
    }
};
