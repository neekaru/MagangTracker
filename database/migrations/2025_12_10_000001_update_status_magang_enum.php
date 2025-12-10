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
        // Update existing records before changing enum
        // Convert 'Pending' to 'Aktif'
        DB::table('magang')
            ->where('status_magang', 'Pending')
            ->update(['status_magang' => 'Aktif']);

        // Convert 'dibatalkan' to 'Nonaktif'
        DB::table('magang')
            ->where('status_magang', 'dibatalkan')
            ->update(['status_magang' => 'Nonaktif']);

        // Convert 'selesai' to 'Selesai' (capitalize)
        DB::table('magang')
            ->where('status_magang', 'selesai')
            ->update(['status_magang' => 'Selesai']);

        // For SQLite, we need to recreate the table with new enum values
        // For MySQL/PostgreSQL, we would use ALTER TABLE MODIFY

        // Check if using SQLite
        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            // SQLite approach: recreate table
            Schema::table('magang', function (Blueprint $table) {
                $table->dropColumn('status_magang');
            });

            Schema::table('magang', function (Blueprint $table) {
                $table->enum('status_magang', ['Aktif', 'Nonaktif', 'Selesai'])
                    ->default('Aktif')
                    ->after('tanggal_selesai');
            });
        } else {
            // MySQL/PostgreSQL approach
            DB::statement("ALTER TABLE magang MODIFY COLUMN status_magang ENUM('Aktif', 'Nonaktif', 'Selesai') DEFAULT 'Aktif'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum values
        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            Schema::table('magang', function (Blueprint $table) {
                $table->dropColumn('status_magang');
            });

            Schema::table('magang', function (Blueprint $table) {
                $table->enum('status_magang', ['Pending', 'Aktif', 'Nonaktif', 'selesai', 'dibatalkan'])
                    ->default('Pending')
                    ->after('tanggal_selesai');
            });
        } else {
            DB::statement("ALTER TABLE magang MODIFY COLUMN status_magang ENUM('Pending', 'Aktif', 'Nonaktif', 'selesai', 'dibatalkan') DEFAULT 'Pending'");
        }
    }
};
