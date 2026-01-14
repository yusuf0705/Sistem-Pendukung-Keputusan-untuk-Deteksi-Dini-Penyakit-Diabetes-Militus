<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RiwayatKesehatan;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $user = Auth::user();
        
        // Ambil riwayat kesehatan user
        $riwayat = RiwayatKesehatan::whereHas('dataKesehatanUser', function($query) {
                $query->where('id_user', Auth::id());
            })
            ->with('dataKesehatanUser')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Hitung distribusi tingkat risiko
        $totalRiwayat = $riwayat->count();
        
        if ($totalRiwayat > 0) {
            $risikoRendah = $riwayat->where('tingkat_resiko', 'Rendah')->count();
            $risikoSedang = $riwayat->where('tingkat_resiko', 'Sedang')->count();
            $risikoTinggi = $riwayat->where('tingkat_resiko', 'Tinggi')->count();
            
            $persenRendah = round(($risikoRendah / $totalRiwayat) * 100);
            $persenSedang = round(($risikoSedang / $totalRiwayat) * 100);
            $persenTinggi = round(($risikoTinggi / $totalRiwayat) * 100);
        } else {
            // Default jika belum ada riwayat
            $persenRendah = 0;
            $persenSedang = 0;
            $persenTinggi = 0;
        }
        
        // Ambil data terakhir untuk card
        $lastCheckup = $riwayat->first();
        
        $statusDiabetes = $lastCheckup->status_diabetes ?? 'Normal';
        $tingkatResiko = $lastCheckup->tingkat_resiko ?? 'Rendah';
        $beratBadan = $lastCheckup->dataKesehatanUser->berat_badan ?? 65;
        $imt = $lastCheckup->dataKesehatanUser->imt ?? 23.5;
        
        // PENTING: Pass semua variabel ke view
        return view('user.dashboard', compact(
            'user',
            'statusDiabetes',
            'tingkatResiko',
            'beratBadan',
            'imt',
            'persenRendah',     
            'persenSedang',     
            'persenTinggi',     
            'totalRiwayat'      
        ));
    }
}