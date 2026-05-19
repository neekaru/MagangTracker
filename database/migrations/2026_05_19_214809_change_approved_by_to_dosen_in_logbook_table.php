<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cek apakah FK constraint ada sebelum drop
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'logbook' 
            AND COLUMN_NAME = 'approved_by' 
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        if (!empty($foreignKeys)) {
            Schema::table('logbook', function (Blueprint $table) {
                $table->dropForeign(['approved_by']);
            });
        }

        // Migrasi data: ubah approved_by dari users.id ke dosen.id
        DB::statement('
            UPDATE logbook l
            INNER JOIN users u ON l.approved_by = u.id
            INNER JOIN dosen d ON u.id = d.user_id
            SET l.approved_by = d.id
            WHERE l.approved_by IS NOT NULL
        ');

        Schema::table('logbook', function (Blueprint $table) {
            // Buat foreign key baru ke dosen
            $table->foreign('approved_by')
                ->references('id')
                ->on('dosen')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logbook', function (Blueprint $table) {
            // Drop foreign key
            $table->dropForeign(['approved_by']);
        });

        // Migrasi data balik: ubah approved_by dari dosen.id ke users.id
        DB::statement('
            UPDATE logbook l
            INNER JOIN dosen d ON l.approved_by = d.id
            INNER JOIN users u ON d.user_id = u.id
            SET l.approved_by = u.id
            WHERE l.approved_by IS NOT NULL
        ');

        Schema::table('logbook', function (Blueprint $table) {
            // Restore foreign key ke users
            $table->foreign('approved_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }
};
