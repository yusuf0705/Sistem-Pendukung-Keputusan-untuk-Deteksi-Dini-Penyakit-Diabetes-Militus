<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DatasetController extends Controller
{
    public function readDataset()
    {
        // Path file CSV
        $path = 'datasets/dataset_diabetes_dini.csv';

        // Cek file
        if (!Storage::exists($path)) {
            return 'File dataset tidak ditemukan!';
        }

        // Ambil isi CSV
        $csv = Storage::get($path);

        // Pecah per baris
        $rows = array_map('str_getcsv', explode("\n", $csv));

        // Hilangkan baris kosong
        $rows = array_filter($rows, fn($row) => count($row) > 1);

        // Ambil header
        $header = array_shift($rows);

        // Gabungkan header + data menjadi array associative
        $dataset = [];
        foreach ($rows as $row) {
            $dataset[] = array_combine($header, $row);
        }

        return response()->json($dataset);
    }
}
