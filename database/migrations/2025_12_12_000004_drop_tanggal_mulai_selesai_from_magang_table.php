<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('magang', function (Blueprint $table) {
            $drops = [];
            if (Schema::hasColumn('magang', 'tanggal_mulai')) {
                $drops[] = 'tanggal_mulai';
            }
            if (Schema::hasColumn('magang', 'tanggal_selesai')) {
                $drops[] = 'tanggal_selesai';
            }
            if (!empty($drops)) {
                $table->dropColumn($drops);
            }
        });
    }

    public function down(): void
    {
        Schema::table('magang', function (Blueprint $table) {
            if (!Schema::hasColumn('magang', 'tanggal_mulai')) {
                $table->dateTime('tanggal_mulai')->after('pembimbing_lapangan');
            }
            if (!Schema::hasColumn('magang', 'tanggal_selesai')) {
                $table->dateTime('tanggal_selesai')->after('tanggal_mulai');
            }
        });
    }
};

