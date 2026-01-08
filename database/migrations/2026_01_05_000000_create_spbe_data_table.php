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
        Schema::create('spbe_data', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->index();
            $table->string('tahun');
            $table->string('nama_instansi');
            $table->string('kategori')->nullable();
            $table->string('daerah')->nullable();
            $table->json('nilai')->nullable();
            $table->decimal('indeks', 12, 10)->nullable();
            $table->timestamps();

            $table->unique(['kode', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spbe_data');
    }
};
