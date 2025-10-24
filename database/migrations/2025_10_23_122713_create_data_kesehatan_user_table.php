<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration untuk tabel data_kesehatan_user.
     */
    public function up(): void
    {
        Schema::create('data_kesehatan_user', function (Blueprint $table) {
            $table->id('id_data_kesehatan_user');
            
            // 🔧 Perbaikan di sini:
            // Menentukan kolom referensi foreign key secara eksplisit (users.id_user)
            $table->foreignId('id_user')
                  ->constrained('users', 'id_user')
                  ->onDelete('cascade');
            
            $table->string('nama');
            $table->integer('usia');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->float('berat_badan');
            $table->float('tinggi_badan');
            $table->float('imt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse migration (hapus tabel jika rollback).
     */
    public function down(): void
    {
        Schema::dropIfExists('data_kesehatan_user');
    }
};
