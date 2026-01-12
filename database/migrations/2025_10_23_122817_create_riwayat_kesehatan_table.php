<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration untuk tabel riwayat_kesehatan.
     */
    public function up(): void
    {
        Schema::create('riwayat_kesehatan', function (Blueprint $table) {
            $table->id('id_riwayat_kesehatan');
            $table->foreignId('id_data_kesehatan_user')
                  ->constrained('data_kesehatan_user', 'id_data_kesehatan_user')
                  ->onDelete('cascade');
            
            // Data gaya hidup dan riwayat
            $table->string('keluarga_diabetes');
            $table->string('merokok');
            $table->string('minum_alkohol');
            $table->string('riwayat_hipertensi');
            $table->string('riwayat_obesitas');
            $table->string('olahraga');
            $table->string('pola_makan');
            
            // Gejala yang dialami (opsional)
            $table->string('sering_buang_air_kecil_malam')->nullable();
            $table->string('sering_lapar')->nullable();
            $table->string('pandangan_kabur')->nullable();
            
            // Hasil analisis AI
            $table->string('tingkat_resiko')->nullable();
            $table->decimal('skor_resiko', 5, 2)->nullable();
            $table->string('status_diabetes')->nullable();
            $table->text('penjelasan_resiko')->nullable();
            $table->text('rekomendasi_diet')->nullable();
            $table->text('rekomendasi_olahraga')->nullable();
            $table->text('perubahan_gaya_hidup')->nullable();
            $table->text('tips_pencegahan')->nullable();
            $table->string('perlu_konsul')->nullable();
            $table->text('pesan_konsultasi')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Hapus tabel jika rollback dijalankan.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_kesehatan');
    }
};