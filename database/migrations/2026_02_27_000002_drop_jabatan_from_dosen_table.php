<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Menghapus kolom 'jabatan' dari tabel dosen jika ada.
     */
    public function up(): void
    {
        if (Schema::hasColumn('dosen', 'jabatan')) {
            Schema::table('dosen', function (Blueprint $table) {
                $table->dropColumn('jabatan');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('dosen', 'jabatan')) {
            Schema::table('dosen', function (Blueprint $table) {
                $table->string('jabatan')->nullable()->after('nama_lengkap');
            });
        }
    }
};
