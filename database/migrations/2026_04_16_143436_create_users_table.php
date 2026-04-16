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
        Schema::create('users', function (Blueprint $table) {
            // ===== DARI MIGRATION DEFAULT =====
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            
            // ===== DARI MIGRATION BUATAN SENDIRI =====
            $table->enum('skin_type', ['normal', 'dry', 'oily', 'combination', 'sensitive'])->nullable();
            
            // ===== TAMBAHAN DARI DEFAULT (role) =====
            // Default role adalah 'pasien'
            $table->enum('role', ['admin', 'pasien'])->default('pasien');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};