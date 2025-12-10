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
        Schema::table('logbook', function (Blueprint $table) {
            $table->string('hasil_kegiatan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logbook', function (Blueprint $table) {
            // Reverting it to not null might fail if there are null values, 
            // but strict reverse would be to make it nullable(false).
            // For safety in dev, we can try to make it not null, but usually 
            // once nullable, it is fine to leave it or we'd need to fill nulls first.
            // Here we will try to revert it.
            $table->string('hasil_kegiatan')->nullable(false)->change();
        });
    }
};
