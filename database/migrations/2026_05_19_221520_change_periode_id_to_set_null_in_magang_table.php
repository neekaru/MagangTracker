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
            AND TABLE_NAME = 'magang' 
            AND COLUMN_NAME = 'periode_id' 
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        if (!empty($foreignKeys)) {
            Schema::table('magang', function (Blueprint $table) {
                $table->dropForeign(['periode_id']);
            });
        }
        
        Schema::table('magang', function (Blueprint $table) {
            // Pastikan kolom nullable
            $table->foreignId('periode_id')->nullable()->change();
        });
        
        Schema::table('magang', function (Blueprint $table) {
            // Buat foreign key baru dengan set null
            $table->foreign('periode_id')
                ->references('id')
                ->on('periode_magang')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('magang', function (Blueprint $table) {
            // Drop foreign key
            $table->dropForeign(['periode_id']);
        });
        
        Schema::table('magang', function (Blueprint $table) {
            // Restore foreign key dengan cascade
            $table->foreign('periode_id')
                ->references('id')
                ->on('periode_magang')
                ->onDelete('cascade');
        });
    }
};
