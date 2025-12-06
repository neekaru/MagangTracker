<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('unit_bisnis', function (Blueprint $table) {
            $table->foreignId('id_periode')->nullable()->constrained('periode_magang')->nullOnDelete()->after('nama_unit_bisnis');
        });
    }

    public function down(): void
    {
        Schema::table('unit_bisnis', function (Blueprint $table) {
            $table->dropForeign(['id_periode']);
            $table->dropColumn('id_periode');
        });
    }
};
