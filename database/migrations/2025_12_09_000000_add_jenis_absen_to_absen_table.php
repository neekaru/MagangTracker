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
        Schema::table('absen', function (Blueprint $table) {
            $table->enum('jenis_absen', ['masuk', 'pulang'])->default('masuk')->after('magang_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absen', function (Blueprint $table) {
            $table->dropColumn('jenis_absen');
        });
    }
};
