<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absen', function (Blueprint $table) {
            if (Schema::hasColumn('absen', 'id_unit_bisnis')) {
                $table->dropConstrainedForeignId('id_unit_bisnis');
            }
        });
    }

    public function down(): void
    {
        Schema::table('absen', function (Blueprint $table) {
            if (!Schema::hasColumn('absen', 'id_unit_bisnis')) {
                $table->foreignId('id_unit_bisnis')
                    ->constrained('unit_bisnis')
                    ->onDelete('cascade')
                    ->after('status_kehadiran');
            }
        });
    }
};

