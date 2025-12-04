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
        Schema::create('absen', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal');
            $table->time('jam');
            $table->enum('status_kehadiran', ['Hadir', 'Izin', 'Sakit']);
            $table->foreignId('id_unit_bisnis')->constrained('unit_bisnis')->onDelete('cascade');
            $table->longText('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absen');
    }
};
