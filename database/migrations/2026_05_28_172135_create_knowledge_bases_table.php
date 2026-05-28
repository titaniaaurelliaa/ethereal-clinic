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
        Schema::create('knowledge_bases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('skin_problem_id')->nullable()->index('knowledge_bases_skin_problem_id_foreign');
            $table->string('nama_objek', 100);
            $table->enum('tingkat_keparahan', ['Ringan', 'Sedang', 'Parah']);
            $table->unsignedSmallInteger('min_objek');
            $table->unsignedSmallInteger('max_objek')->nullable();
            $table->double('cf_pakar', 4, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge_bases');
    }
};
