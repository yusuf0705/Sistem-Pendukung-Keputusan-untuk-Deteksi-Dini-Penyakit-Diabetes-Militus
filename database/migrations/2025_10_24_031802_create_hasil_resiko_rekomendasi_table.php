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
        Schema::create('hasil_resiko_rekomendasi', function (Blueprint $table) {
            $table->id('id_rekomendasi');

            // ✅ perbaikan foreign key
            $table->foreignId('id_hasil_resiko')
                  ->constrained('hasil_resiko', 'id_hasil_resiko')
                  ->onDelete('cascade');

            $table->text('penjelasan_resiko')->nullable();
            $table->text('rekomendasi_diet')->nullable();
            $table->text('rekomendasi_olahraga')->nullable();
            $table->text('perubahan_gaya_hidup')->nullable();
            $table->text('tips_pencegahan')->nullable();
            $table->boolean('perlu_konsul')->default(false);
            $table->text('pesan_konsultasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Rollback migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_resiko_rekomendasi');
    }
};
