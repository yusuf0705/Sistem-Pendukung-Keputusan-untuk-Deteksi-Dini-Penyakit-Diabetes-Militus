<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatKesehatan extends Model
{
    protected $table = 'riwayat_kesehatan';
    protected $primaryKey = 'id_riwayat_kesehatan';
    
    protected $fillable = [
        'id_data_kesehatan_user',
        'keluarga_diabetes',
        'merokok',
        'minum_alkohol',
        'riwayat_hipertensi',
        'riwayat_obesitas',
        'olahraga',
        'pola_makan',
        // Data medis
        'gula_darah_sewaktu',
        'hba1c',
        'kolesterol',
        // Hasil analisis
        'tingkat_resiko',
        'skor_resiko',
        'status_diabetes',
        'penjelasan_resiko',
        'rekomendasi_diet',
        'rekomendasi_olahraga',
        'perubahan_gaya_hidup',
        'tips_pencegahan',
        'perlu_konsul',
        'pesan_konsultasi',
    ];

    public function dataKesehatanUser()
    {
        return $this->belongsTo(DataKesehatanUser::class, 'id_data_kesehatan_user');
    }
}