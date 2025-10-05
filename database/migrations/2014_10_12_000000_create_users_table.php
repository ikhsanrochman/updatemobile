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
            $table->id();
            $table->string('nama')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('role_id')->nullable()->constrained('roles');
            $table->string('no_sib')->nullable();
            $table->string('npr')->nullable();
            $table->date('berlaku')->nullable();
            $table->string('keahlian')->nullable();
            $table->string('foto_profil')->nullable();
            $table->string('username');
            $table->string('password');
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->boolean('kartu_dosis')->default(false);
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
