<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * Perubahan pada tabel magang:
     * 1. Hapus kolom `target_book_mingguan` dan `tugas_description`
     * 2. Rename FK: id_mahasiswa -> mahasiswa_id
     * 3. Rename FK: id_dosen -> dosen_pembimbing_id
     * 4. Rename FK: unit_id -> unit_bisnis_id
     */
    public function up(): void
    {
        Schema::table('magang', function (Blueprint $table) {
            // --- 1. Hapus kolom yang tidak diperlukan ---
            if (Schema::hasColumn('magang', 'target_book_mingguan')) {
                $table->dropColumn('target_book_mingguan');
            }
            if (Schema::hasColumn('magang', 'tugas_description')) {
                $table->dropColumn('tugas_description');
            }
        });

        Schema::table('magang', function (Blueprint $table) {
            // --- 2. Rename FK id_mahasiswa -> mahasiswa_id ---
            if (Schema::hasColumn('magang', 'id_mahasiswa')) {
                // Drop constraint lama, rename kolom, buat constraint baru
                $table->dropForeign(['id_mahasiswa']);
                $table->renameColumn('id_mahasiswa', 'mahasiswa_id');
            }
        });

        Schema::table('magang', function (Blueprint $table) {
            if (Schema::hasColumn('magang', 'mahasiswa_id')) {
                $table->foreign('mahasiswa_id')->references('id')->on('mahasiswa')->onDelete('cascade');
            }
        });

        Schema::table('magang', function (Blueprint $table) {
            // --- 3. Rename FK id_dosen -> dosen_pembimbing_id ---
            if (Schema::hasColumn('magang', 'id_dosen')) {
                $table->dropForeign(['id_dosen']);
                $table->renameColumn('id_dosen', 'dosen_pembimbing_id');
            }
        });

        Schema::table('magang', function (Blueprint $table) {
            if (Schema::hasColumn('magang', 'dosen_pembimbing_id')) {
                $table->foreign('dosen_pembimbing_id')->references('id')->on('dosen')->onDelete('cascade');
            }
        });

        Schema::table('magang', function (Blueprint $table) {
            // --- 4. Rename FK unit_id -> unit_bisnis_id ---
            if (Schema::hasColumn('magang', 'unit_id')) {
                $table->dropForeign(['unit_id']);
                $table->renameColumn('unit_id', 'unit_bisnis_id');
            }
        });

        Schema::table('magang', function (Blueprint $table) {
            if (Schema::hasColumn('magang', 'unit_bisnis_id')) {
                $table->foreign('unit_bisnis_id')->references('id')->on('unit_bisnis')->onDelete('cascade');
            }
        });

        // --- 5. Pastikan kolom Pembimbing_lapangan ada (string) ---
        Schema::table('magang', function (Blueprint $table) {
            if (!Schema::hasColumn('magang', 'pembimbing_lapangan')) {
                $table->string('pembimbing_lapangan')->nullable()->after('dosen_pembimbing_id');
            }
        });

        // --- 6. Pastikan kolom periode_id ada ---
        Schema::table('magang', function (Blueprint $table) {
            if (!Schema::hasColumn('magang', 'periode_id')) {
                $table->foreignId('periode_id')
                    ->nullable()
                    ->after('unit_bisnis_id')
                    ->constrained('periode_magang')
                    ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('magang', function (Blueprint $table) {
            // Balikkan rename FK
            if (Schema::hasColumn('magang', 'mahasiswa_id')) {
                $table->dropForeign(['mahasiswa_id']);
                $table->renameColumn('mahasiswa_id', 'id_mahasiswa');
            }
            if (Schema::hasColumn('magang', 'dosen_pembimbing_id')) {
                $table->dropForeign(['dosen_pembimbing_id']);
                $table->renameColumn('dosen_pembimbing_id', 'id_dosen');
            }
            if (Schema::hasColumn('magang', 'unit_bisnis_id')) {
                $table->dropForeign(['unit_bisnis_id']);
                $table->renameColumn('unit_bisnis_id', 'unit_id');
            }
        });

        Schema::table('magang', function (Blueprint $table) {
            // Buat kembali constraint lama
            $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('id_dosen')->references('id')->on('dosen')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('unit_bisnis')->onDelete('cascade');
        });

        Schema::table('magang', function (Blueprint $table) {
            // Tambah kembali kolom yang dihapus
            if (!Schema::hasColumn('magang', 'target_book_mingguan')) {
                $table->integer('target_book_mingguan')->default(5);
            }
            if (!Schema::hasColumn('magang', 'tugas_description')) {
                $table->longText('tugas_description')->nullable();
            }
        });
    }
};
