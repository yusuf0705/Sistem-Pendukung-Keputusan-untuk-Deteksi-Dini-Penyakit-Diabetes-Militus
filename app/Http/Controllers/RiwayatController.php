<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RiwayatKesehatan;

class RiwayatController extends Controller
{
    public function index()
    {
        // Ambil semua riwayat user yang sedang login
        $riwayat = RiwayatKesehatan::whereHas('dataKesehatanUser', function($query) {
                $query->where('id_user', Auth::id());
            })
            ->with('dataKesehatanUser')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($item) {
                // Gabungkan semua data untuk ditampilkan
                return (object)[
                    'id_riwayat_kesehatan' => $item->id_riwayat_kesehatan,
                    'id_data_kesehatan_user' => $item->id_data_kesehatan_user,
                    'created_at' => $item->created_at,
                    
                    // Data dari data_kesehatan_user
                    'nama' => $item->dataKesehatanUser->nama,
                    'usia' => $item->dataKesehatanUser->usia,
                    'jenis_kelamin' => $item->dataKesehatanUser->jenis_kelamin == 1 || $item->dataKesehatanUser->jenis_kelamin == 'Laki-laki' 
                        ? 'Laki-Laki' 
                        : 'Perempuan',
                    'berat_badan' => $item->dataKesehatanUser->berat_badan,
                    'tinggi_badan' => $item->dataKesehatanUser->tinggi_badan,
                    'imt' => $item->dataKesehatanUser->imt,
                    
                    // Data gaya hidup dari riwayat_kesehatan
                    'keluarga_diabetes' => $this->formatYaTidak($item->keluarga_diabetes),
                    'merokok' => $this->formatYaTidak($item->merokok),
                    'minum_alkohol' => $this->formatYaTidak($item->minum_alkohol),
                    'riwayat_hipertensi' => $this->formatYaTidak($item->riwayat_hipertensi),
                    'riwayat_obesitas' => $this->formatYaTidak($item->riwayat_obesitas),
                    'olahraga' => $this->formatOlahraga($item->olahraga),
                    'pola_makan' => $this->formatPolaMakan($item->pola_makan),
                    
                    // GEJALA YANG DIALAMI
                    'sering_buang_air_kecil_malam' => $this->formatGejala($item->sering_buang_air_kecil_malam),
                    'sering_lapar' => $this->formatGejala($item->sering_lapar),
                    'pandangan_kabur' => $this->formatGejala($item->pandangan_kabur),
                    
                    // Data hasil analisis AI
                    'tingkat_resiko' => $item->tingkat_resiko,
                    'skor_resiko' => $item->skor_resiko,
                    'status_diabetes' => $item->status_diabetes,
                    'penjelasan_resiko' => $item->penjelasan_resiko,
                    'rekomendasi_diet' => $item->rekomendasi_diet,
                    'rekomendasi_olahraga' => $item->rekomendasi_olahraga,
                    'perubahan_gaya_hidup' => $item->perubahan_gaya_hidup,
                    'tips_pencegahan' => $item->tips_pencegahan,
                    'perlu_konsul' => $item->perlu_konsul,
                    'pesan_konsultasi' => $item->pesan_konsultasi,
                ];
            });

        return view('user.riwayat_kesehatan.index', compact('riwayat'));
    }

    /**
     * ✅ TAMBAHKAN METHOD INI - untuk fetch data riwayat via AJAX
     */
    public function getRiwayatData()
    {
        $riwayat = RiwayatKesehatan::whereHas('dataKesehatanUser', function($query) {
                $query->where('id_user', Auth::id());
            })
            ->with('dataKesehatanUser')
            ->orderBy('created_at', 'desc')
            ->get()
            ->mapWithKeys(function($item) {
                return [
                    $item->id_riwayat_kesehatan => [
                        'id_riwayat_kesehatan' => $item->id_riwayat_kesehatan,
                        'id_data_kesehatan_user' => $item->id_data_kesehatan_user,
                        'created_at' => $item->created_at->toIso8601String(), // Format untuk JavaScript
                        
                        // Data dari data_kesehatan_user
                        'nama' => $item->dataKesehatanUser->nama,
                        'usia' => $item->dataKesehatanUser->usia,
                        'jenis_kelamin' => $item->dataKesehatanUser->jenis_kelamin == 1 || $item->dataKesehatanUser->jenis_kelamin == 'Laki-laki' 
                            ? 'Laki-Laki' 
                            : 'Perempuan',
                        'berat_badan' => $item->dataKesehatanUser->berat_badan,
                        'tinggi_badan' => $item->dataKesehatanUser->tinggi_badan,
                        'imt' => $item->dataKesehatanUser->imt,
                        
                        // Data gaya hidup
                        'keluarga_diabetes' => $this->formatYaTidak($item->keluarga_diabetes),
                        'merokok' => $this->formatYaTidak($item->merokok),
                        'minum_alkohol' => $this->formatYaTidak($item->minum_alkohol),
                        'riwayat_hipertensi' => $this->formatYaTidak($item->riwayat_hipertensi),
                        'riwayat_obesitas' => $this->formatYaTidak($item->riwayat_obesitas),
                        'olahraga' => $this->formatOlahraga($item->olahraga),
                        'pola_makan' => $this->formatPolaMakan($item->pola_makan),
                        
                        // Gejala
                        'sering_buang_air_kecil_malam' => $this->formatGejala($item->sering_buang_air_kecil_malam),
                        'sering_lapar' => $this->formatGejala($item->sering_lapar),
                        'pandangan_kabur' => $this->formatGejala($item->pandangan_kabur),
                        
                        // Hasil analisis AI
                        'tingkat_resiko' => $item->tingkat_resiko,
                        'skor_resiko' => $item->skor_resiko,
                        'status_diabetes' => $item->status_diabetes,
                        'penjelasan_resiko' => $item->penjelasan_resiko,
                        'rekomendasi_diet' => $item->rekomendasi_diet,
                        'rekomendasi_olahraga' => $item->rekomendasi_olahraga,
                        'perubahan_gaya_hidup' => $item->perubahan_gaya_hidup,
                        'tips_pencegahan' => $item->tips_pencegahan,
                        'perlu_konsul' => $item->perlu_konsul,
                        'pesan_konsultasi' => $item->pesan_konsultasi,
                    ]
                ];
            });

        return response()->json($riwayat);
    }

    /**
     * Format field Ya/Tidak
     * Menangani nilai yang sudah string "Ya"/"Tidak" atau masih 1/0
     */
    private function formatYaTidak($value)
    {
        // Jika null atau empty string
        if ($value === null || $value === '') {
            return 'Tidak Diisi';
        }
        
        // Jika sudah berupa string "Ya" atau "Tidak" (dari database)
        if ($value === 'Ya' || $value === 'Tidak') {
            return $value;
        }
        
        // Jika masih berupa 1/0 (fallback)
        return $value == 1 ? 'Ya' : 'Tidak';
    }

    /**
     * Format field gejala (opsional)
     * Menangani nilai yang sudah string "Ya"/"Tidak" atau masih 1/0 atau NULL
     */
    private function formatGejala($value)
    {
        // Jika null atau empty string (gejala tidak diisi)
        if ($value === null || $value === '') {
            return 'Tidak Diisi';
        }
        
        // Jika sudah berupa string "Ya" atau "Tidak" (dari database)
        if ($value === 'Ya' || $value === 'Tidak') {
            return $value;
        }
        
        // Jika masih berupa 1/0 (fallback)
        return $value == 1 ? 'Ya' : 'Tidak';
    }

    /**
     * Format olahraga
     * Menangani nilai yang sudah string atau masih angka 0/1/2
     */
    private function formatOlahraga($value)
    {
        // Jika null atau empty
        if ($value === null || $value === '') {
            return 'Tidak Diisi';
        }
        
        // Jika sudah berupa string (dari database)
        if (is_string($value) && !is_numeric($value)) {
            return $value;
        }
        
        // Map dari angka ke string
        $options = [
            '0' => 'Tidak Pernah',
            '1' => 'Kadang-kadang',
            '2' => 'Rutin',
        ];
        
        return $options[(string)$value] ?? 'Tidak Diisi';
    }

    /**
     * Format pola makan
     * Menangani nilai yang sudah string atau masih angka 0/1/2
     */
    private function formatPolaMakan($value)
    {
        // Jika null atau empty
        if ($value === null || $value === '') {
            return 'Tidak Diisi';
        }
        
        // Jika sudah berupa string (dari database)
        if (is_string($value) && !is_numeric($value)) {
            return $value;
        }
        
        // Map dari angka ke string
        $options = [
            '0' => 'Tidak Sehat',
            '1' => 'Cukup Sehat',
            '2' => 'Sangat Sehat',
        ];
        
        return $options[(string)$value] ?? 'Tidak Diisi';
    }
}