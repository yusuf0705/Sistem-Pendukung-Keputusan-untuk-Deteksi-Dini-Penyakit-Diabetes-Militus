<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ML\MLService;

class DeteksiController extends Controller
{
    public function index()
    {
        return view("user.deteksi.index");
    }

    public function create()
    {
        return view("user.deteksi.form");
    }

    public function cekDiabetes(Request $request)
    {
        // VALIDASI INPUT
        $validated = $request->validate([
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
        ]);

        // ============================================
        // 🔥 PERHITUNGAN SKOR RISIKO MANUAL
        // ============================================

        $skor = 0;

        // Usia
        if ($validated["usia"] >= 45) $skor += 2;

        // IMT
        if ($validated["imt"] >= 30) {
            $skor += 3;
        } elseif ($validated["imt"] >= 25) {
            $skor += 2;
        }

        // Riwayat keluarga
        if ($validated["keluarga_diabetes"] == 1) $skor += 3;

        // Merokok
        if ($validated["merokok"] == 1) $skor += 2;

        // Alkohol
        if ($validated["minum_alkohol"] == 1) $skor += 1;

        // Hipertensi
        if ($validated["riwayat_hipertensi"] == 1) $skor += 3;

        // Obesitas
        if ($validated["riwayat_obesitas"] == 1) $skor += 2;

        // Olahraga (0 = jarang)
        if ($validated["olahraga"] == 0) $skor += 2;

        // Pola makan (0 = buruk)
        if ($validated["pola_makan"] == 0) $skor += 3;

        // ============================================
        // 🔥 TENTUKAN KATEGORI
        // ============================================
        if ($skor >= 12) {
            $kategori = "Tinggi";
        } elseif ($skor >= 6) {
            $kategori = "Sedang";
        } else {
            $kategori = "Rendah";
        }

        // ============================================
        // 🔥 AI / MACHINE LEARNING PREDICTION
        // ============================================
        $ml = new MLService();
        $predict = $ml->predict($validated);

        // ============================================
        // 🔥 GABUNGKAN SEMUA DATA UNTUK VIEW
        // ============================================
        $hasil = [
            "skor"      => $skor,
            "kategori"  => $kategori,
            "diabetes"  => $predict["diabetes"] ?? 0,
            "score"     => ($skor * 5) > 100 ? 100 : ($skor * 5), // buat persen 0–100%
            "rekomendasi_gaya_hidup" => "Rutin olahraga minimal 3–4 kali seminggu.",
            "rekomendasi_pola_makan" => "Kurangi gula & gorengan, perbanyak serat.",
            "pesan_konsultasi"       => "Jika nilai risiko tinggi, segera konsultasi ke dokter.",
        ];

        // Kirim ke view
        return view("user.deteksi.hasil", compact("hasil"));
    }
}
