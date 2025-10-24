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
            
            // 🔧 Perbaikan di sini: tambahkan kolom referensi secara eksplisit
            $table->foreignId('id_data_kesehatan_user')
                  ->constrained('data_kesehatan_user', 'id_data_kesehatan_user')
                  ->onDelete('cascade');

            $table->boolean('keluarga_diabetes')->default(false);
            $table->boolean('merokok')->default(false);
            $table->boolean('minum_alkohol')->default(false);
            $table->boolean('riwayat_hipertensi')->default(false);
            $table->boolean('riwayat_obesitas')->default(false);
            $table->string('olahraga')->nullable();
            $table->string('pola_makan')->nullable();
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
