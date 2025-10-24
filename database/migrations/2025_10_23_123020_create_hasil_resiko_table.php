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
        Schema::create('hasil_resiko', function (Blueprint $table) {
            $table->id('id_hasil_resiko');

            // ✅ Perbaikan foreign key
            $table->foreignId('id_data_medis')
                  ->constrained('data_medis', 'id_data_medis')
                  ->onDelete('cascade');

            $table->string('tingkat_resiko');
            $table->float('skor_resiko');
            $table->string('status_diabetes');
            $table->timestamps();
        });
    }

    /**
     * Rollback migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_resiko');
    }
};
