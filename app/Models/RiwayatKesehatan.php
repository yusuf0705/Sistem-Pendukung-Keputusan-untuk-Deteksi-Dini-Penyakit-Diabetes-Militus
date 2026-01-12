<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatKesehatan extends Model
{
    protected $table = 'riwayat_kesehatan';
    protected $primaryKey = 'id_riwayat_kesehatan';
    
    protected $fillable = [
        'id_data_kesehatan_user',
        // Data gaya hidup dan riwayat
        'keluarga_diabetes',
        'merokok',
        'minum_alkohol',
        'riwayat_hipertensi',
        'riwayat_obesitas',
        'olahraga',
        'pola_makan',
        // Gejala yang dialami (opsional)
        'sering_buang_air_kecil_malam',
        'sering_lapar',
        'pandangan_kabur',
        // Hasil analisis AI
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

    protected $casts = [
        'skor_resiko' => 'decimal:2',
    ];

    /**
     * Relasi ke tabel data_kesehatan_user
     */
    public function dataKesehatanUser()
    {
        return $this->belongsTo(DataKesehatanUser::class, 'id_data_kesehatan_user', 'id_data_kesehatan_user');
    }

    /**
     * Accessor untuk format nama
     */
    public function getNamaAttribute()
    {
        return $this->dataKesehatanUser?->nama ?? '-';
    }

    /**
     * Accessor untuk format usia
     */
    public function getUsiaAttribute()
    {
        return $this->dataKesehatanUser?->usia ?? '-';
    }

    /**
     * Accessor untuk format jenis kelamin
     */
    public function getJenisKelaminAttribute()
    {
        if (!$this->dataKesehatanUser) return '-';
        return $this->dataKesehatanUser->jenis_kelamin == 1 ? 'Laki-Laki' : 'Perempuan';
    }

    /**
     * Accessor untuk format berat badan
     */
    public function getBeratBadanAttribute()
    {
        return $this->dataKesehatanUser?->berat_badan ?? '-';
    }

    /**
     * Accessor untuk format tinggi badan
     */
    public function getTinggiBadanAttribute()
    {
        return $this->dataKesehatanUser?->tinggi_badan ?? '-';
    }

    /**
     * Accessor untuk format IMT
     */
    public function getImtAttribute()
    {
        return $this->dataKesehatanUser?->imt ?? '-';
    }

    /**
     * Scope untuk filter berdasarkan user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->whereHas('dataKesehatanUser', function($q) use ($userId) {
            $q->where('id_user', $userId);
        });
    }

    /**
     * Scope untuk filter berdasarkan tingkat risiko
     */
    public function scopeByRisikoLevel($query, $level)
    {
        return $query->where('tingkat_resiko', $level);
    }

    /**
     * Scope untuk data terbaru
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}