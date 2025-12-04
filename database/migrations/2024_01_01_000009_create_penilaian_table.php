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
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('magang_id')->constrained('magang')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
            $table->foreignId('dinilai_oleh_id')->constrained('dosen')->onDelete('cascade');
            $table->integer('nilai_kedisplinan');
            $table->integer('nilai_tanggung_jawab');
            $table->integer('nilai_kemampuan_teknis');
            $table->integer('nilai_laporan_akhir');
            $table->integer('nilai_prestasi');
            $table->longText('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};
