<?php

namespace App\ML;

class MLService
{
    public function predict($data)
    {
        /**
         * Contoh model sederhana
         * Bisa kamu ganti dengan model asli (Python, PMML, ONNX, dsb)
         */

        $risk = 0;

        // Rule sederhana
        if ($data["usia"] >= 45) $risk += 2;
        if ($data["imt"] >= 30) $risk += 3;
        if ($data["keluarga_diabetes"] == 1) $risk += 3;
        if ($data["riwayat_hipertensi"] == 1) $risk += 2;
        if ($data["riwayat_obesitas"] == 1) $risk += 2;
        if ($data["olahraga"] == 0) $risk += 2;
        if ($data["pola_makan"] == 0) $risk += 3;

        // Tentukan hasil AI
        $hasil = [
            "diabetes" => $risk >= 8 ? 1 : 0,
            "score"    => min(100, $risk * 5)
        ];

        return $hasil;
    }
}
