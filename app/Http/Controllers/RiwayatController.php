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
                    'jenis_kelamin' => $item->dataKesehatanUser->jenis_kelamin,
                    'berat_badan' => $item->dataKesehatanUser->berat_badan,
                    'tinggi_badan' => $item->dataKesehatanUser->tinggi_badan,
                    'imt' => $item->dataKesehatanUser->imt,
                    // Data dari riwayat_kesehatan
                    'keluarga_diabetes' => $item->keluarga_diabetes,
                    'merokok' => $item->merokok,
                    'minum_alkohol' => $item->minum_alkohol,
                    'riwayat_hipertensi' => $item->riwayat_hipertensi,
                    'riwayat_obesitas' => $item->riwayat_obesitas,
                    'olahraga' => $item->olahraga,
                    'pola_makan' => $item->pola_makan,
                    // Data medis
                    'gula_darah_sewaktu' => $item->gula_darah_sewaktu ?? 0,
                    'hba1c' => $item->hba1c ?? 0,
                    'kolesterol' => $item->kolesterol ?? 0,
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

        // PENTING: Pastikan view path-nya benar
        return view('user.riwayat_kesehatan.index', compact('riwayat'));
    }
}