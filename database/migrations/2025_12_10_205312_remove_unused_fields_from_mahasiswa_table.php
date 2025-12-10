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
        Schema::table('mahasiswa', function (Blueprint $table) {
            // Drop unused date fields - tanggal magang should be in 'magang' table
            $table->dropColumn(['tanggal_mulai', 'tanggal_selesai']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            // Restore columns if rollback is needed
            $table->date('tanggal_mulai')->nullable()->after('nama_lengkap');
            $table->date('tanggal_selesai')->nullable()->after('tanggal_mulai');
        });
    }
};
