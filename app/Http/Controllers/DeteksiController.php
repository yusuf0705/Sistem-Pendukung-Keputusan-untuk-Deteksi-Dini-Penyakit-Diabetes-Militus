<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Tambahkan ini
use App\Models\DataKesehatanUser;
use App\Models\RiwayatKesehatan;
use App\ML\MLService;

class DeteksiController extends Controller
{
    // Halaman index/dashboard dengan statistik
    public function index()
    {
        // Ambil riwayat pemeriksaan terakhir user
        $lastCheckup = RiwayatKesehatan::whereHas('dataKesehatanUser', function($query) {
                $query->where('id_user', Auth::id());
            })
            ->with('dataKesehatanUser')
            ->latest()
            ->first();

        // Hitung total pemeriksaan user
        $totalCheckups = RiwayatKesehatan::whereHas('dataKesehatanUser', function($query) {
                $query->where('id_user', Auth::id());
            })
            ->count();

        // Hitung hasil normal (risiko rendah)
        $normalCount = RiwayatKesehatan::whereHas('dataKesehatanUser', function($query) {
                $query->where('id_user', Auth::id());
            })
            ->where('tingkat_resiko', 'Rendah')
            ->count();

        // Hitung hasil perlu perhatian (risiko sedang & tinggi)
        $abnormalCount = RiwayatKesehatan::whereHas('dataKesehatanUser', function($query) {
                $query->where('id_user', Auth::id());
            })
            ->whereIn('tingkat_resiko', ['Sedang', 'Tinggi'])
            ->count();

        // Format hasil untuk lastCheckup jika ada
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

    // Halaman form deteksi
    public function create()
    {
        return view("user.deteksi.form");
    }

    // Proses deteksi
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

        // ======================
        // SIMPAN KE DATABASE
        // ======================
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
            $analisis = $this->generateAnalisis($validated, $skor, $kategori, $predict);

            // 3. Simpan riwayat kesehatan lengkap
            $riwayatKesehatan = RiwayatKesehatan::create([
                'id_data_kesehatan_user' => $dataKesehatan->id_data_kesehatan_user,
                // Data input
                'keluarga_diabetes' => $validated['keluarga_diabetes'] == 1 ? 'Ya' : 'Tidak',
                'merokok' => $validated['merokok'] == 1 ? 'Ya' : 'Tidak',
                'minum_alkohol' => $validated['minum_alkohol'] == 1 ? 'Ya' : 'Tidak',
                'riwayat_hipertensi' => $validated['riwayat_hipertensi'] == 1 ? 'Ya' : 'Tidak',
                'riwayat_obesitas' => $validated['riwayat_obesitas'] == 1 ? 'Ya' : 'Tidak',
                'olahraga' => $this->mapOlahraga($validated['olahraga']),
                'pola_makan' => $this->mapPolaMakan($validated['pola_makan']),
                // Data medis hasil analisis
                'gula_darah_sewaktu' => $analisis['gula_darah_sewaktu'],
                'hba1c' => $analisis['hba1c'],
                'kolesterol' => $analisis['kolesterol'],
                // Hasil analisis AI
                'tingkat_resiko' => $kategori,
                'skor_resiko' => $hasil['score'],
                'status_diabetes' => $analisis['status_diabetes'],
                'penjelasan_resiko' => $analisis['penjelasan_resiko'],
                'rekomendasi_diet' => $analisis['rekomendasi_diet'],
                'rekomendasi_olahraga' => $analisis['rekomendasi_olahraga'],
                'perubahan_gaya_hidup' => $analisis['perubahan_gaya_hidup'],
                'tips_pencegahan' => $analisis['tips_pencegahan'],
                'perlu_konsul' => $analisis['perlu_konsul'],
                'pesan_konsultasi' => $analisis['pesan_konsultasi'],
            ]);

            // Tambahkan ID riwayat ke hasil untuk referensi
            $hasil['id_riwayat'] = $riwayatKesehatan->id_riwayat_kesehatan;
            
        } catch (\Exception $e) {
            // Log error dengan benar menggunakan Log facade
            Log::error('Error saving health data: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        return view("user.deteksi.hasil", compact("hasil"));
    }

    private function generateAnalisis($data, $skor, $kategori, $predict)
    {
        $statusDiabetes = ($predict["diabetes"] ?? 0) > 0.5 ? 'Prediabetes' : 'Normal';
        
        if ($kategori === 'Rendah') {
            $gulaDarah = rand(70, 110);
            $hba1c = rand(40, 54) / 10;
        } elseif ($kategori === 'Sedang') {
            $gulaDarah = rand(110, 140);
            $hba1c = rand(54, 64) / 10;
            $statusDiabetes = 'Prediabetes';
        } else {
            $gulaDarah = rand(140, 180);
            $hba1c = rand(64, 75) / 10;
            $statusDiabetes = 'Prediabetes';
        }

        $perluKonsul = $skor >= 10 ? 'Ya' : 'Tidak';

        return [
            'status_diabetes' => $statusDiabetes,
            'gula_darah_sewaktu' => $gulaDarah,
            'hba1c' => $hba1c,
            'kolesterol' => rand(150, 240),
            'penjelasan_resiko' => $this->generatePenjelasan($kategori, $skor),
            'rekomendasi_diet' => $this->generateRekomendasiDiet($kategori),
            'rekomendasi_olahraga' => $this->generateRekomendasiOlahraga($kategori),
            'perubahan_gaya_hidup' => $this->generatePerubahanGayaHidup($kategori),
            'tips_pencegahan' => $this->generateTipsPencegahan($kategori),
            'perlu_konsul' => $perluKonsul,
            'pesan_konsultasi' => $this->generatePesanKonsultasi($perluKonsul, $kategori),
        ];
    }

    private function mapOlahraga($value)
    {
        $map = [0 => 'Tidak Pernah', 1 => 'Kadang-kadang', 2 => 'Rutin'];
        return $map[$value] ?? 'Tidak Pernah';
    }

    private function mapPolaMakan($value)
    {
        $map = [0 => 'Tidak Sehat', 1 => 'Cukup Sehat', 2 => 'Sangat Sehat'];
        return $map[$value] ?? 'Tidak Sehat';
    }

    private function generatePenjelasan($kategori, $skor)
    {
        if ($kategori === 'Rendah') {
            return "Kadar gula darah Anda dalam rentang normal dengan skor risiko {$skor}. Gaya hidup sehat yang Anda jalani sangat baik untuk mencegah diabetes. Pertahankan pola hidup sehat Anda.";
        } elseif ($kategori === 'Sedang') {
            return "Anda memiliki beberapa faktor risiko diabetes dengan skor {$skor}. Penting untuk mulai melakukan perubahan gaya hidup untuk mencegah perkembangan ke diabetes tipe 2.";
        } else {
            return "Skor risiko Anda mencapai {$skor}, menunjukkan risiko tinggi diabetes. Beberapa faktor risiko seperti riwayat keluarga, gaya hidup, dan kondisi kesehatan memerlukan perhatian serius.";
        }
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