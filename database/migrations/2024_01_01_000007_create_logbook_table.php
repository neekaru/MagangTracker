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
        Schema::create('logbook', function (Blueprint $table) {
            $table->id();
            $table->foreignId('magang_id')->constrained('magang')->onDelete('cascade');
            $table->dateTime('tanggal_logbook');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->longText('deskripsi_kegiatan');
            $table->string('hasil_kegiatan');
            $table->string('foto_kegiatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbook');
    }
};
