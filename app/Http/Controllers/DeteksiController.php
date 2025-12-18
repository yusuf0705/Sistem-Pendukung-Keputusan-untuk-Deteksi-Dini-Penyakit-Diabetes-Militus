<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ML\MLService;

class DeteksiController extends Controller
{
    public function create()
    {
        return view("user.deteksi.form");
    }

    public function cekDiabetes(Request $request)
    {
        $validated = $request->validate(
            [
                "usia" => "required|numeric",
                "jenis_kelamin" => "required|numeric",
                "berat_badan" => "required|numeric",
                "tinggi_badan" => "required|numeric",
                "imt" => "required|numeric",
                "keluarga_diabetes" => "required|numeric",
                "merokok" => "required|numeric",
                "minum_alkohol" => "required|numeric",
                "riwayat_hipertensi" => "required|numeric",
                "riwayat_obesitas" => "required|numeric",
                "olahraga" => "required|numeric",
                "pola_makan" => "required|numeric",
            ],
            [
                "*.required" => "Semua field wajib diisi!",
                "*.numeric"  => "Input tidak valid",
            ]
        );

        // ======================
        // HITUNG SKOR RISIKO
        // ======================
        $skor = 0;

        if ($validated["usia"] >= 45) $skor += 2;
        if ($validated["imt"] >= 30) $skor += 3;
        elseif ($validated["imt"] >= 25) $skor += 2;

        if ($validated["keluarga_diabetes"] == 1) $skor += 3;
        if ($validated["merokok"] == 1) $skor += 2;
        if ($validated["minum_alkohol"] == 1) $skor += 1;
        if ($validated["riwayat_hipertensi"] == 1) $skor += 3;
        if ($validated["riwayat_obesitas"] == 1) $skor += 2;
        if ($validated["olahraga"] == 0) $skor += 2;
        if ($validated["pola_makan"] == 0) $skor += 3;

        if ($skor >= 12) $kategori = "Tinggi";
        elseif ($skor >= 6) $kategori = "Sedang";
        else $kategori = "Rendah";

        // ======================
        // PREDIKSI AI
        // ======================
        $ml = new MLService();
        $predict = $ml->predict($validated);

        $hasil = [
            "skor" => $skor,
            "kategori" => $kategori,
            "diabetes" => $predict["diabetes"] ?? 0,
            "score" => min($skor * 5, 100),
        ];

        return view("user.deteksi.hasil", compact("hasil"));
    }
}
