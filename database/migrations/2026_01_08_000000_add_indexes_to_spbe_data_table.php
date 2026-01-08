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
        Schema::table('spbe_data', function (Blueprint $table) {
            // Add indexes for frequently queried columns
            $table->index('kode', 'idx_spbe_data_kode');
            $table->index('tahun', 'idx_spbe_data_tahun');
            $table->index(['kode', 'tahun'], 'idx_spbe_data_kode_tahun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spbe_data', function (Blueprint $table) {
            $table->dropIndex('idx_spbe_data_kode');
            $table->dropIndex('idx_spbe_data_tahun');
            $table->dropIndex('idx_spbe_data_kode_tahun');
        });
    }
};
