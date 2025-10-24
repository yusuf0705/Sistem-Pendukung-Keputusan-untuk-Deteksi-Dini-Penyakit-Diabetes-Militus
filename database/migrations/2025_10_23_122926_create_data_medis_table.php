<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('data_medis', function (Blueprint $table) {
            $table->id('id_data_medis');

            // ✅ Perbaikan foreign key
            $table->foreignId('id_riwayat_kesehatan')
                  ->constrained('riwayat_kesehatan', 'id_riwayat_kesehatan')
                  ->onDelete('cascade');

            $table->float('gula_darah_puasa')->nullable();
            $table->float('gula_darah_sewaktu')->nullable();
            $table->float('hba1c')->nullable();
            $table->float('kolestrol')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Rollback migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_medis');
    }
};
