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
        Schema::create('sia_data', function (Blueprint $table) {
            $table->id();
            $table->string('instansi')->index();
            $table->unsignedInteger('id_kategori_instansi');
            $table->unsignedInteger('id_daerah');
            $table->unsignedTinyInteger('tingkat_kematangan')->nullable();

            // AS-IS data
            $table->unsignedInteger('proses_bisnis_as_is')->default(0);
            $table->unsignedInteger('layanan_as_is')->default(0);
            $table->unsignedInteger('data_info_as_is')->default(0);
            $table->unsignedInteger('aplikasi_as_is')->default(0);
            $table->unsignedInteger('infra_as_is')->default(0);
            $table->unsignedInteger('keamanan_as_is')->default(0);

            // TO-BE data
            $table->unsignedInteger('proses_bisnis_to_be')->default(0);
            $table->unsignedInteger('layanan_to_be')->default(0);
            $table->unsignedInteger('data_info_to_be')->default(0);
            $table->unsignedInteger('aplikasi_to_be')->default(0);
            $table->unsignedInteger('infra_to_be')->default(0);
            $table->unsignedInteger('keamanan_to_be')->default(0);

            // Status flags
            $table->boolean('peta_rencana')->default(false);
            $table->boolean('clearance')->default(false);
            $table->boolean('reviueval')->default(false);

            $table->timestamps();

            // Unique constraint to prevent duplicates
            $table->unique(['instansi', 'id_kategori_instansi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sia_data');
    }
};
