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
        Schema::create('perizinan_sumber_radiasi_pengion', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('tipe');
            $table->string('no_seri')->unique();
            $table->string('aktivitas');
            $table->date('tanggal_aktivitas');
            $table->string('kv_ma')->nullable(); // Assuming kv-ma can be null
            $table->string('no_ktun')->unique();
            $table->date('tanggal_berlaku');
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perizinan_sumber_radiasi_pengion');
    }
};
