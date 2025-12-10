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
        $request->validate([
            "usia" => "required|numeric",
            "jenis_kelamin" => "required|numeric",
            "riwayat_keluarga" => "required|numeric",
            "merokok" => "required|numeric",
            "alkohol" => "required|numeric",
            "obesitas" => "required|numeric",
            "olahraga" => "required|numeric",
        ]);

        $ml = new MLService();

        $input = $request->only([
            "usia", 
            "jenis_kelamin",
            "riwayat_keluarga",
            "merokok",
            "alkohol",
            "obesitas",
            "olahraga"
        ]);

        $hasil = $ml->predict($input);

        return view("user.deteksi.hasil", compact("hasil"));
    }
}
