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
        Schema::table('magang', function (Blueprint $table) {
            // Drop foreign key constraint lama
            $table->dropForeign(['dosen_pembimbing_id']);
            
            // Ubah kolom jadi nullable
            $table->foreignId('dosen_pembimbing_id')->nullable()->change();
            
            // Buat foreign key baru dengan onDelete set null
            $table->foreign('dosen_pembimbing_id')
                ->references('id')
                ->on('dosen')
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
            $table->dropForeign(['dosen_pembimbing_id']);
            
            // Ubah kolom jadi not nullable
            $table->foreignId('dosen_pembimbing_id')->nullable(false)->change();
            
            // Restore foreign key dengan cascade
            $table->foreign('dosen_pembimbing_id')
                ->references('id')
                ->on('dosen')
                ->onDelete('cascade');
        });
    }
};
