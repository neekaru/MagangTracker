<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dosen', function (Blueprint $table) {
            if (!Schema::hasColumn('dosen', 'nidn')) {
                $table->string('nidn')->nullable()->after('nama_lengkap');
            }
        });

        if (Schema::hasColumn('dosen', 'nip')) {
            DB::table('dosen')
                ->whereNull('nidn')
                ->update(['nidn' => DB::raw('nip')]);

            Schema::table('dosen', function (Blueprint $table) {
                $table->dropColumn('nip');
            });
        }
    }

    public function down(): void
    {
        Schema::table('dosen', function (Blueprint $table) {
            if (!Schema::hasColumn('dosen', 'nip')) {
                $table->string('nip')->nullable()->after('nama_lengkap');
            }
        });

        if (Schema::hasColumn('dosen', 'nidn')) {
            DB::table('dosen')
                ->whereNull('nip')
                ->update(['nip' => DB::raw('nidn')]);

            Schema::table('dosen', function (Blueprint $table) {
                $table->dropColumn('nidn');
            });
        }
    }
};

