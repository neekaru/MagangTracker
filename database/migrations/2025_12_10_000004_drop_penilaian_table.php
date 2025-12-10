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
        Schema::dropIfExists('penilaian');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate table if needed (optional)
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('magang_id')->constrained('magang')->onDelete('cascade');
            $table->integer('nilai_akhir');
            $table->text('catatan')->nullable();
            $table->foreignId('dinilai_oleh')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }
};
