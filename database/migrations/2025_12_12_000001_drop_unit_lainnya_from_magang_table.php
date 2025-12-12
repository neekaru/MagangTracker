<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('magang', function (Blueprint $table) {
            if (Schema::hasColumn('magang', 'unit_lainnya')) {
                $table->dropColumn('unit_lainnya');
            }
        });
    }

    public function down(): void
    {
        Schema::table('magang', function (Blueprint $table) {
            if (!Schema::hasColumn('magang', 'unit_lainnya')) {
                $table->text('unit_lainnya')->nullable()->after('unit_id');
            }
        });
    }
};

