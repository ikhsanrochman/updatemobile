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
        Schema::create('pemantauan_dosis_pendose', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('npr')->nullable();
            $table->string('jenis_alat_pemantauan');
            $table->double('hasil_pengukuran');
            $table->date('tanggal_pengukuran');
            $table->boolean('kartu_dosis')->default(false);
            $table->timestamps();

            // Optional: Add unique constraint to prevent duplicate entries
            $table->unique(['project_id', 'user_id', 'tanggal_pengukuran'], 'pemantauan_pendose_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemantauan_dosis_pendose');
    }
}; 