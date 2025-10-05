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
        Schema::create('pemantauan_dosis_tld', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->double('dosis');
            $table->date('tanggal_pemantauan');
            $table->timestamps();

            // Optional: Add unique constraint to prevent duplicate entries for the same user, project and date
            $table->unique(['project_id', 'user_id', 'tanggal_pemantauan'], 'pemantauan_tld_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemantauan_dosis_tld');
    }
};
