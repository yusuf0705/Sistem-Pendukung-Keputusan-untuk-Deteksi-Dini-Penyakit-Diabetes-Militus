<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\DataKesehatanUser;
use App\Models\RiwayatKesehatan;
use App\Services\MLService;

class DeteksiController extends Controller
{
    protected $mlService;

    public function __construct(MLService $mlService)
    {
        $this->mlService = $mlService;
    }

    public function index()
    {
        $lastCheckup = RiwayatKesehatan::whereHas('dataKesehatanUser', function($query) {
                $query->where('id_user', Auth::id());
            })
            ->with('dataKesehatanUser')
            ->latest()
            ->first();

        $totalCheckups = RiwayatKesehatan::whereHas('dataKesehatanUser', function($query) {
                $query->where('id_user', Auth::id());
            })
            ->count();

        $normalCount = RiwayatKesehatan::whereHas('dataKesehatanUser', function($query) {
                $query->where('id_user', Auth::id());
            })
            ->where('tingkat_resiko', 'Rendah')
            ->count();

        $abnormalCount = RiwayatKesehatan::whereHas('dataKesehatanUser', function($query) {
                $query->where('id_user', Auth::id());
            })
            ->whereIn('tingkat_resiko', ['Sedang', 'Tinggi'])
            ->count();

        if ($lastCheckup) {
            $lastCheckup->result = $lastCheckup->status_diabetes . ' - Risiko ' . $lastCheckup->tingkat_resiko;
        }

        return view("user.deteksi.index", compact(
            'lastCheckup',
            'totalCheckups',
            'normalCount',
            'abnormalCount'
        ));
    }

    public function create()
    {
        return view("user.deteksi.form");
    }

    public function cekDiabetes(Request $request)
    {
        $validated = $request->validate(
            [
                "usia" => "required|numeric|min:1|max:120",
                "jenis_kelamin" => "required|numeric|in:0,1",
                "berat_badan" => "required|numeric|min:1",
                "tinggi_badan" => "required|numeric|min:1",
                "imt" => "required|numeric",
                "keluarga_diabetes" => "required|numeric|in:0,1",
                "merokok" => "required|numeric|in:0,1",
                "minum_alkohol" => "required|numeric|in:0,1",
                "riwayat_hipertensi" => "required|numeric|in:0,1",
                "riwayat_obesitas" => "required|numeric|in:0,1",
                "olahraga" => "required|numeric|in:0,1,2",
                "pola_makan" => "required|numeric|in:0,1,2",
                "sering_buang_air_kecil_malam" => "nullable|numeric|in:0,1",
                "sering_lapar" => "nullable|numeric|in:0,1",
                "pandangan_kabur" => "nullable|numeric|in:0,1",
            ],
            [
                "*.required" => "Semua field wajib diisi!",
                "*.numeric"  => "Input tidak valid",
                "*.min" => "Nilai terlalu kecil",
                "*.max" => "Nilai terlalu besar",
                "*.in" => "Pilihan tidak valid",
            ]
        );

        // Hitung skor risiko manual (untuk fallback)
        $skor = $this->hitungSkorManual($validated);
        $kategoriManual = $this->getKategoriFromSkor($skor);

        // Prediksi menggunakan ML API
        try {
            $mlData = [
                'usia' => (int) $validated['usia'],
                'jenis_kelamin' => $validated['jenis_kelamin'] == 1 ? 'Laki-laki' : 'Perempuan',
                'berat_badan' => (float) $validated['berat_badan'],
                'tinggi_badan' => (float) $validated['tinggi_badan'],
                'imt' => (float) $validated['imt'],
                'keluarga_diabetes' => (int) $validated['keluarga_diabetes'],
                'merokok' => (int) $validated['merokok'],
                'minum_alkohol' => (int) $validated['minum_alkohol'],
                'riwayat_hipertensi' => (int) $validated['riwayat_hipertensi'],
                'riwayat_obesitas' => (int) $validated['riwayat_obesitas'],
                'olahraga' => $this->mapOlahragaForML($validated['olahraga']),
                'pola_makan' => $this->mapPolaMakanForML($validated['pola_makan']),
                'sering_buang_air_kecil_malam' => (int) ($validated['sering_buang_air_kecil_malam'] ?? 0),
                'sering_lapar' => (int) ($validated['sering_lapar'] ?? 0),
                'pandangan_kabur' => (int) ($validated['pandangan_kabur'] ?? 0),
            ];

            $mlResult = $this->mlService->predict($mlData);

            if ($mlResult['success']) {
                $prediction = $mlResult['data'];
                
                $kategori = $prediction['risk_level'];
                $probabilitas = $prediction['probability']['diabetes'];
                $prediksiDiabetes = $prediction['prediction'];
                $confidence = $prediction['confidence'];
                
                $explanation = $this->mlService->explain($mlData);
                $riskFactors = $explanation['data']['identified_risk_factors'] ?? [];
                $recommendation = $explanation['data']['recommendation'] ?? '';
                
            } else {
                Log::warning('ML API failed, using manual calculation', [
                    'error' => $mlResult['error'] ?? 'Unknown error'
                ]);
                
                $kategori = $kategoriManual;
                $probabilitas = $skor / 20;
                $prediksiDiabetes = $skor >= 12 ? 1 : 0;
                $confidence = 0.5;
                $riskFactors = [];
                $recommendation = '';
            }

        } catch (\Exception $e) {
            Log::error('ML Service Error: ' . $e->getMessage());
            
            $kategori = $kategoriManual;
            $probabilitas = $skor / 20;
            $prediksiDiabetes = $skor >= 12 ? 1 : 0;
            $confidence = 0.5;
            $riskFactors = [];
            $recommendation = '';
        }

        // Simpan ke database
        try {
            // 1. Simpan data kesehatan user
            $dataKesehatan = DataKesehatanUser::create([
                'id_user' => Auth::id(),
                'nama' => Auth::user()->name,
                'usia' => $validated['usia'],
                'jenis_kelamin' => $validated['jenis_kelamin'] == 1 ? 'Laki-laki' : 'Perempuan',
                'berat_badan' => $validated['berat_badan'],
                'tinggi_badan' => $validated['tinggi_badan'],
                'imt' => $validated['imt'],
            ]);

            // 2. Generate analisis lengkap
            $analisis = $this->generateAnalisis(
                $validated, 
                $skor, 
                $kategori, 
                $prediksiDiabetes,
                $probabilitas,
                $riskFactors,
                $recommendation
            );

            // 3. Simpan riwayat kesehatan lengkap (DENGAN GEJALA)
            $riwayatKesehatan = RiwayatKesehatan::create([
                'id_data_kesehatan_user' => $dataKesehatan->id_data_kesehatan_user,
                
                // Data input gaya hidup
                'keluarga_diabetes' => $validated['keluarga_diabetes'] == 1 ? 'Ya' : 'Tidak',
                'merokok' => $validated['merokok'] == 1 ? 'Ya' : 'Tidak',
                'minum_alkohol' => $validated['minum_alkohol'] == 1 ? 'Ya' : 'Tidak',
                'riwayat_hipertensi' => $validated['riwayat_hipertensi'] == 1 ? 'Ya' : 'Tidak',
                'riwayat_obesitas' => $validated['riwayat_obesitas'] == 1 ? 'Ya' : 'Tidak',
                'olahraga' => $this->mapOlahraga($validated['olahraga']),
                'pola_makan' => $this->mapPolaMakan($validated['pola_makan']),
                
                // ✅ TAMBAHAN: Data gejala (opsional)
                'sering_buang_air_kecil_malam' => isset($validated['sering_buang_air_kecil_malam']) 
                    ? ($validated['sering_buang_air_kecil_malam'] == 1 ? 'Ya' : 'Tidak') 
                    : null,
                'sering_lapar' => isset($validated['sering_lapar']) 
                    ? ($validated['sering_lapar'] == 1 ? 'Ya' : 'Tidak') 
                    : null,
                'pandangan_kabur' => isset($validated['pandangan_kabur']) 
                    ? ($validated['pandangan_kabur'] == 1 ? 'Ya' : 'Tidak') 
                    : null,
                
                // Hasil analisis AI
                'tingkat_resiko' => $kategori,
                'skor_resiko' => round($probabilitas * 100, 2),
                'status_diabetes' => $analisis['status_diabetes'],
                'penjelasan_resiko' => $analisis['penjelasan_resiko'],
                'rekomendasi_diet' => $analisis['rekomendasi_diet'],
                'rekomendasi_olahraga' => $analisis['rekomendasi_olahraga'],
                'perubahan_gaya_hidup' => $analisis['perubahan_gaya_hidup'],
                'tips_pencegahan' => $analisis['tips_pencegahan'],
                'perlu_konsul' => $analisis['perlu_konsul'],
                'pesan_konsultasi' => $analisis['pesan_konsultasi'],
            ]);

            $hasil = [
                'id_riwayat' => $riwayatKesehatan->id_riwayat_kesehatan,
                'kategori' => $kategori,
                'skor' => $skor,
                'score' => round($probabilitas * 100, 2),
                'diabetes' => $prediksiDiabetes,
                'confidence' => round($confidence * 100, 2),
                'risk_factors' => $riskFactors,
                'recommendation' => $recommendation,
                'analisis' => $analisis,
            ];
            
        } catch (\Exception $e) {
            Log::error('Error saving health data: ' . $e->getMessage());
            
            return back()
                ->with('error', 'Gagal menyimpan data kesehatan. Silakan coba lagi.')
                ->withInput();
        }

        return view("user.deteksi.hasil", compact("hasil"));
    }

    private function hitungSkorManual($data)
    {
        $skor = 0;
        if ($data["usia"] >= 45) $skor += 2;
        if ($data["imt"] >= 30) $skor += 3;
        elseif ($data["imt"] >= 25) $skor += 2;
        if ($data["keluarga_diabetes"] == 1) $skor += 3;
        if ($data["merokok"] == 1) $skor += 2;
        if ($data["minum_alkohol"] == 1) $skor += 1;
        if ($data["riwayat_hipertensi"] == 1) $skor += 3;
        if ($data["riwayat_obesitas"] == 1) $skor += 2;
        if ($data["olahraga"] == 0) $skor += 2;
        if ($data["pola_makan"] == 0) $skor += 3;
        return $skor;
    }

    private function getKategoriFromSkor($skor)
    {
        if ($skor >= 12) return "Tinggi";
        elseif ($skor >= 6) return "Sedang";
        else return "Rendah";
    }

    private function generateAnalisis($data, $skor, $kategori, $prediksiDiabetes, $probabilitas, $riskFactors, $recommendation)
    {
        $statusDiabetes = $prediksiDiabetes == 1 ? 'Prediabetes' : 'Normal';
        $perluKonsul = $kategori === 'Tinggi' ? 'Ya' : 'Tidak';

        return [
            'status_diabetes' => $statusDiabetes,
            'penjelasan_resiko' => $this->generatePenjelasan($kategori, $skor, $probabilitas, $riskFactors),
            'rekomendasi_diet' => $this->generateRekomendasiDiet($kategori),
            'rekomendasi_olahraga' => $this->generateRekomendasiOlahraga($kategori),
            'perubahan_gaya_hidup' => $this->generatePerubahanGayaHidup($kategori),
            'tips_pencegahan' => $this->generateTipsPencegahan($kategori),
            'perlu_konsul' => $perluKonsul,
            'pesan_konsultasi' => $this->generatePesanKonsultasi($perluKonsul, $kategori),
        ];
    }

    private function mapOlahragaForML($value)
    {
        return [0 => 'Jarang', 1 => 'Kadang', 2 => 'Rutin'][$value] ?? 'Jarang';
    }

    private function mapPolaMakanForML($value)
    {
        return [0 => 'Tidak Sehat', 1 => 'Cukup Sehat', 2 => 'Sehat'][$value] ?? 'Tidak Sehat';
    }

    private function mapOlahraga($value)
    {
        return [0 => 'Tidak Pernah', 1 => 'Kadang-kadang', 2 => 'Rutin'][$value] ?? 'Tidak Pernah';
    }

    private function mapPolaMakan($value)
    {
        return [0 => 'Tidak Sehat', 1 => 'Cukup Sehat', 2 => 'Sangat Sehat'][$value] ?? 'Tidak Sehat';
    }

    private function generatePenjelasan($kategori, $skor, $probabilitas, $riskFactors)
    {
        $probPersen = round($probabilitas * 100, 1);
        $penjelasan = "Hasil analisis AI menunjukkan probabilitas diabetes Anda sebesar {$probPersen}% dengan skor risiko {$skor}. ";
        
        if ($kategori === 'Rendah') {
            $penjelasan .= "Kadar gula darah Anda dalam rentang normal. Gaya hidup sehat yang Anda jalani sangat baik untuk mencegah diabetes. Pertahankan pola hidup sehat Anda.";
        } elseif ($kategori === 'Sedang') {
            $penjelasan .= "Anda memiliki beberapa faktor risiko diabetes. ";
            if (!empty($riskFactors)) {
                $penjelasan .= "Faktor risiko yang teridentifikasi: " . implode(", ", $riskFactors) . ". ";
            }
            $penjelasan .= "Penting untuk mulai melakukan perubahan gaya hidup untuk mencegah perkembangan ke diabetes tipe 2.";
        } else {
            $penjelasan .= "Ini menunjukkan risiko TINGGI diabetes. ";
            if (!empty($riskFactors)) {
                $penjelasan .= "Faktor risiko yang teridentifikasi: " . implode(", ", $riskFactors) . ". ";
            }
            $penjelasan .= "Beberapa faktor risiko memerlukan perhatian serius dan konsultasi medis segera.";
        }
        
        return $penjelasan;
    }

    private function generateRekomendasiDiet($kategori)
    {
        if ($kategori === 'Rendah') {
            return "Pertahankan pola makan sehat dengan konsumsi sayur dan buah secara teratur. Batasi asupan gula dan karbohidrat sederhana. Minum air putih minimal 8 gelas per hari.";
        } elseif ($kategori === 'Sedang') {
            return "Kurangi konsumsi gula, makanan tinggi karbohidrat olahan. Perbanyak serat dari sayuran, buah-buahan, dan biji-bijian utuh. Pilih protein tanpa lemak seperti ikan, ayam tanpa kulit, dan kacang-kacangan.";
        } else {
            return "Kurangi drastis konsumsi gula, makanan tinggi karbohidrat olahan, dan lemak jenuh. Perbanyak serat dari sayuran hijau dan biji-bijian utuh. Konsultasikan dengan ahli gizi untuk program diet khusus diabetes.";
        }
    }

    private function generateRekomendasiOlahraga($kategori)
    {
        if ($kategori === 'Rendah') {
            return "Lanjutkan rutinitas olahraga minimal 150 menit per minggu. Kombinasikan kardio (jalan cepat, jogging) dengan latihan kekuatan 2-3 kali seminggu.";
        } elseif ($kategori === 'Sedang') {
            return "Mulai rutin berolahraga minimal 30 menit setiap hari. Fokus pada aktivitas aerobik seperti jalan cepat, bersepeda, atau berenang. Tambahkan latihan kekuatan 2 kali seminggu.";
        } else {
            return "SEGERA mulai rutin berolahraga minimal 30-45 menit setiap hari. Mulai dengan aktivitas ringan seperti jalan kaki, lalu tingkatkan intensitas secara bertahap. Konsultasikan program olahraga dengan dokter.";
        }
    }

    private function generatePerubahanGayaHidup($kategori)
    {
        if ($kategori === 'Rendah') {
            return "Pertahankan berat badan ideal, hindari stres berlebihan, dan tidur cukup 7-8 jam per hari. Lakukan pemeriksaan kesehatan rutin setiap 6-12 bulan.";
        } elseif ($kategori === 'Sedang') {
            return "Turunkan berat badan 5-10% jika kelebihan berat badan. Kelola stres dengan baik melalui meditasi atau yoga. Tidur cukup dan teratur. Batasi konsumsi alkohol dan hindari merokok.";
        } else {
            return "SEGERA hentikan kebiasaan merokok dan batasi konsumsi alkohol. Turunkan berat badan 7-10% untuk mengurangi risiko. Kelola stres dan tidur minimal 7 jam per hari. Pantau gula darah secara teratur.";
        }
    }

    private function generateTipsPencegahan($kategori)
    {
        if ($kategori === 'Rendah') {
            return "Lakukan pemeriksaan gula darah rutin setiap 6-12 bulan. Monitor tekanan darah dan kolesterol. Jaga berat badan ideal dan tetap aktif secara fisik.";
        } elseif ($kategori === 'Sedang') {
            return "Pantau gula darah setiap 3-6 bulan. Periksa tekanan darah dan kolesterol secara rutin. Konsumsi air putih minimal 8 gelas per hari. Hindari makanan cepat saji dan minuman manis.";
        } else {
            return "Pantau gula darah setiap bulan atau sesuai anjuran dokter. Periksa HbA1c setiap 3 bulan. Monitor tekanan darah dan kolesterol. Catat asupan makanan harian dan aktivitas fisik.";
        }
    }

    private function generatePesanKonsultasi($perlu, $kategori)
    {
        if ($perlu === 'Ya') {
            return "Sangat disarankan konsultasi dengan dokter untuk pemeriksaan lebih lanjut dan program pencegahan diabetes. Bawa hasil analisis ini saat konsultasi.";
        } else {
            return "Kondisi Anda baik, lanjutkan gaya hidup sehat. Tetap lakukan pemeriksaan kesehatan rutin untuk monitoring.";
        }
    }
}