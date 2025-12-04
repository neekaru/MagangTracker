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
        Schema::create('magang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_mahasiswa')->constrained('mahasiswa')->onDelete('cascade');
            $table->foreignId('unit_id')->constrained('unit_bisnis')->onDelete('cascade');
            $table->text('unit_lainnya')->nullable();
            $table->foreignId('periode_id')->constrained('periode_magang')->onDelete('cascade');
            $table->foreignId('id_dosen')->constrained('dosen')->onDelete('cascade');
            $table->string('pembimbing_lapangan');
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
            $table->enum('status_magang', ['Aktif', 'Nonaktif', 'selesai', 'dibatalkan'])->default('Nonaktif');
            $table->integer('target_book_mingguan');
            $table->longText('tugas_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magang');
    }
};
