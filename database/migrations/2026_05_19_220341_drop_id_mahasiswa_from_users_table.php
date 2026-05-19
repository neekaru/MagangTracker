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
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'id_mahasiswa')) {
                $table->dropForeign(['id_mahasiswa']);
                $table->dropColumn('id_mahasiswa');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'id_mahasiswa')) {
                $table->unsignedBigInteger('id_mahasiswa')->nullable();
                $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa')->onDelete('set null');
            }
        });
    }
};
