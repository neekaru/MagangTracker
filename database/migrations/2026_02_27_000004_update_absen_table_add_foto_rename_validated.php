<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * Perubahan pada tabel absen:
     * 1. Tambah kolom `foto_bukti` (string, nullable)
     * 2. Rename FK: validated_by -> validasi_by
     */
    public function up(): void
    {
        // --- 1. Tambah kolom foto_bukti ---
        Schema::table('absen', function (Blueprint $table) {
            if (!Schema::hasColumn('absen', 'foto_bukti')) {
                $table->string('foto_bukti')->nullable()->after('keterangan');
            }
        });

        // --- 2. Rename FK validated_by -> validasi_by (dalam blok terpisah) ---
        Schema::table('absen', function (Blueprint $table) {
            if (Schema::hasColumn('absen', 'validated_by')) {
                $table->dropForeign(['validated_by']);
                $table->renameColumn('validated_by', 'validasi_by');
            }
        });

        Schema::table('absen', function (Blueprint $table) {
            if (Schema::hasColumn('absen', 'validasi_by')) {
                $table->foreign('validasi_by')
                    ->references('id')
                    ->on('dosen')
                    ->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absen', function (Blueprint $table) {
            // Balikkan rename
            if (Schema::hasColumn('absen', 'validasi_by')) {
                $table->dropForeign(['validasi_by']);
                $table->renameColumn('validasi_by', 'validated_by');
            }
        });

        Schema::table('absen', function (Blueprint $table) {
            if (Schema::hasColumn('absen', 'validated_by')) {
                $table->foreign('validated_by')
                    ->references('id')
                    ->on('dosen')
                    ->nullOnDelete();
            }
        });

        Schema::table('absen', function (Blueprint $table) {
            // Hapus kolom foto_bukti
            if (Schema::hasColumn('absen', 'foto_bukti')) {
                $table->dropColumn('foto_bukti');
            }
        });
    }
};
