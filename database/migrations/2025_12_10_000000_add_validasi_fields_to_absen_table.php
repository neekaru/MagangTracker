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
            $table->enum('status_validasi', ['pending', 'approved', 'rejected'])
                ->default('pending')
                ->after('status_kehadiran');
            $table->foreignId('validated_by')
                ->nullable()
                ->after('status_validasi')
                ->constrained('dosen')
                ->nullOnDelete();
            $table->timestamp('validated_at')->nullable()->after('validated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absen', function (Blueprint $table) {
            $table->dropForeign(['validated_by']);
            $table->dropColumn(['status_validasi', 'validated_by', 'validated_at']);
        });
    }
};
