@extends('layouts.navbar')

@section('title', 'Riwayat Kesehatan')
@section('page_title', 'Riwayat Kesehatan')

@section('content')
@php
    $riwayat = collect([
        (object)[
            'id_riwayat_kesehatan' => 1,
            'id_data_kesehatan_user' => 101,
            'created_at' => now()->subDays(5),
            // Data dari data_kesehatan_user
            'nama' => 'John Doe',
            'usia' => 45,
            'jenis_kelamin' => 'Laki-laki',
            'berat_badan' => 78,
            'tinggi_badan' => 170,
            'imt' => 27.0,
            // Data dari riwayat_kesehatan
            'keluarga_diabetes' => 'Ya',
            'merokok' => 'Tidak',
            'minum_alkohol' => 'Tidak',
            'riwayat_hipertensi' => 'Tidak',
            'riwayat_obesitas' => 'Tidak',
            'olahraga' => 'Rutin',
            'pola_makan' => 'Sehat',
            // data_medis
            'gula_darah_sewaktu' => 120,
            'hba1c' => 5.5,
            'kolesterol' => 180,
            // Data hasil analisis AI
            'tingkat_resiko' => 'Rendah',
            'skor_resiko' => 25,
            'status_diabetes' => 'Normal',
            'penjelasan_resiko' => 'Kadar gula darah Anda dalam rentang normal. Gaya hidup sehat yang Anda jalani sangat baik untuk mencegah diabetes.',
            'rekomendasi_diet' => 'Pertahankan pola makan sehat dengan konsumsi sayur dan buah secara teratur. Batasi asupan gula dan karbohidrat sederhana.',
            'rekomendasi_olahraga' => 'Lanjutkan rutinitas olahraga minimal 150 menit per minggu. Kombinasikan kardio dan latihan kekuatan.',
            'perubahan_gaya_hidup' => 'Pertahankan berat badan ideal, hindari stres berlebihan, dan tidur cukup 7-8 jam per hari.',
            'tips_pencegahan' => 'Lakukan pemeriksaan gula darah rutin setiap 3-6 bulan. Monitor tekanan darah dan kolesterol.',
            'perlu_konsul' => 'Tidak',
            'pesan_konsultasi' => 'Kondisi Anda baik, lanjutkan gaya hidup sehat.'
        ],
        (object)[
            'id_riwayat_kesehatan' => 2,
            'id_data_kesehatan_user' => 102,
            'created_at' => now()->subDays(3),
            'nama' => 'John Doe',
            'usia' => 45,
            'jenis_kelamin' => 'Laki-laki',
            'berat_badan' => 82,
            'tinggi_badan' => 170,
            'imt' => 28.4,
            'keluarga_diabetes' => 'Ya',
            'merokok' => 'Ya',
            'minum_alkohol' => 'Kadang',
            'riwayat_hipertensi' => 'Ya',
            'riwayat_obesitas' => 'Ya',
            'olahraga' => 'Jarang',
            'pola_makan' => 'Kurang Sehat',
            'gula_darah_sewaktu' => 145,
            'hba1c' => 6.2,
            'kolesterol' => 220,
            'tingkat_resiko' => 'Tinggi',
            'skor_resiko' => 75,
            'status_diabetes' => 'Prediabetes',
            'penjelasan_resiko' => 'Kadar gula darah Anda menunjukkan kondisi prediabetes. Beberapa faktor risiko seperti riwayat keluarga, hipertensi, dan gaya hidup meningkatkan risiko diabetes.',
            'rekomendasi_diet' => 'Kurangi drastis konsumsi gula, makanan tinggi karbohidrat olahan, dan lemak jenuh. Perbanyak serat dari sayuran dan biji-bijian utuh.',
            'rekomendasi_olahraga' => 'Mulai rutin berolahraga minimal 30 menit setiap hari. Fokus pada aktivitas aerobik seperti jalan cepat, bersepeda, atau berenang.',
            'perubahan_gaya_hidup' => 'SEGERA hentikan kebiasaan merokok dan batasi konsumsi alkohol. Turunkan berat badan 5-10% untuk mengurangi risiko.',
            'tips_pencegahan' => 'Pantau gula darah setiap bulan. Kelola stres dengan baik. Konsumsi air putih minimal 8 gelas per hari.',
            'perlu_konsul' => 'Ya',
            'pesan_konsultasi' => 'Sangat disarankan konsultasi dengan dokter untuk pemeriksaan lebih lanjut dan program pencegahan diabetes.'
        ],
    ]);

    $riwayatJson = json_encode($riwayat->keyBy('id_riwayat_kesehatan'));
@endphp

<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-blue-50 py-8 px-4 sm:px-6 lg:px-8 font-inter">
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Header Section --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-700">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2 font-poppins">Riwayat Kesehatan Saya</h1>
                    <p class="text-gray-700">Pantau perkembangan kesehatan Anda secara berkala</p>
                </div>
                <div class="flex gap-2">
                    <button type="button" onclick="downloadReport()" class="px-4 py-3 bg-green-700 text-white rounded-lg hover:bg-green-800 transition-all shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 min-h-[48px] min-w-[48px] flex items-center justify-center font-medium">
                        <span class="sr-only">Unduh Laporan</span>
                        <i class="fas fa-download mr-2" aria-hidden="true"></i>
                        <span>Unduh Laporan</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900 flex items-center font-poppins">
                    <span class="bg-green-700 text-white rounded-lg p-2 mr-3" aria-hidden="true">
                        <i class="fas fa-history"></i>
                    </span>
                    Riwayat Detail Pemeriksaan
                </h2>
            </div>

            <div id="historyContainer" class="space-y-4">
                @foreach ($riwayat as $index => $data)
                    <div class="history-item group relative bg-gradient-to-r from-gray-50 to-white rounded-xl p-4 border-2 border-gray-200 hover:border-green-700 transition-all hover:shadow-md cursor-pointer focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                         data-id="{{ $data->id_riwayat_kesehatan }}"
                         role="button" 
                         tabindex="0"
                         aria-label="Lihat detail riwayat kesehatan tanggal {{ $data->created_at->format('d M Y') }}, status {{ $data->status_diabetes }}, tingkat risiko {{ $data->tingkat_resiko }}">
                        {{-- Timeline Dot --}}
                        <div class="absolute -left-3 top-1/2 transform -translate-y-1/2 w-6 h-6 bg-green-700 rounded-full border-4 border-white shadow-md group-hover:scale-110 transition-transform" aria-hidden="true"></div>
                        
                        <div class="ml-6 grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            {{-- Date & Time --}}
                            <div class="md:col-span-3">
                                <div class="flex items-center gap-3">
                                    <div class="bg-green-700 bg-opacity-10 rounded-lg p-3" aria-hidden="true">
                                        <i class="fas fa-calendar-day text-green-700 text-xl"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ $data->created_at->format('d M Y') }}</div>
                                        <div class="text-sm text-gray-700">{{ $data->created_at->format('H:i') }} WIB</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Blood Sugar Level --}}
                            <div class="md:col-span-2">
                                <div class="text-center bg-white rounded-lg p-3 shadow-sm">
                                    <div class="text-2xl font-bold {{ $data->status_diabetes === 'Normal' ? 'text-green-700' : 'text-red-700' }} font-poppins">
                                        {{ $data->gula_darah_sewaktu }}
                                    </div>
                                    <div class="text-xs text-gray-700 mt-1">mg/dL</div>
                                </div>
                            </div>

                            {{-- Risk Level Badge --}}
                            <div class="md:col-span-2 flex justify-center">
                                @if ($data->tingkat_resiko === 'Rendah')
                                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-semibold shadow-sm font-poppins">
                                        <i class="fas fa-check-circle" aria-hidden="true"></i>
                                        Resiko Rendah
                                    </span>
                                @elseif ($data->tingkat_resiko === 'Sedang')
                                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold shadow-sm font-poppins">
                                        <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
                                        Resiko Sedang
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-red-100 text-red-800 rounded-full text-sm font-semibold shadow-sm font-poppins">
                                        <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
                                        Resiko Tinggi
                                    </span>
                                @endif
                            </div>

                            {{-- Quick Info --}}
                            <div class="md:col-span-4">
                                <div class="flex flex-wrap gap-2">
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-50 text-blue-800 rounded text-xs font-medium">
                                        <i class="fas fa-heartbeat" aria-hidden="true"></i>
                                        {{ $data->status_diabetes }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-purple-50 text-purple-800 rounded text-xs font-medium">
                                        <i class="fas fa-chart-line" aria-hidden="true"></i>
                                        Skor: {{ $data->skor_resiko }}%
                                    </span>
                                    @if($data->perlu_konsul === 'Ya')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-red-50 text-red-800 rounded text-xs font-medium">
                                            <i class="fas fa-user-md" aria-hidden="true"></i>
                                            Perlu Konsultasi
                                        </span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-700 mt-2">
                                    Klik atau tekan Enter untuk lihat detail lengkap
                                </div>
                            </div>

                            {{-- Action Button --}}
                            <div class="md:col-span-1 flex justify-end">
                                <button type="button" class="text-gray-600 hover:text-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 rounded-full p-2 min-h-[44px] min-w-[44px] flex items-center justify-center" aria-label="Buka detail">
                                    <i class="fas fa-chevron-right" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

{{-- Modal Detail dengan Tab --}}
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4 hidden" aria-hidden="true" aria-labelledby="modalTitle" aria-describedby="modalDesc">
    <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-screen-90 overflow-hidden flex flex-col font-inter">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-700 to-green-600 text-white p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 id="modalTitle" class="text-2xl font-bold flex items-center gap-2 font-poppins">
                        <i class="fas fa-file-medical-alt" aria-hidden="true"></i>
                        Detail Riwayat Kesehatan
                    </h3>
                    <p id="modalDesc" class="text-green-100 text-sm mt-1">Detail lengkap hasil analisis kesehatan</p>
                    <p class="text-green-100 text-sm mt-1" id="modalDate">-</p>
                </div>
                <button type="button" onclick="closeDetailModal()" class="text-white hover:text-green-200 transition-colors focus:outline-none focus:ring-2 focus:ring-white rounded-full p-2 min-h-[44px] min-w-[44px] flex items-center justify-center" aria-label="Tutup modal">
                    <i class="fas fa-times text-2xl" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        {{-- Tab Navigation --}}
        <div class="bg-gray-100 border-b border-gray-200" role="tablist" aria-label="Detail riwayat kesehatan">
            <div class="flex">
                <button type="button" onclick="switchTab('dataInput')" id="tabDataInput" class="flex-1 px-6 py-4 font-semibold text-gray-900 hover:bg-white transition-all border-b-2 border-transparent focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-inset min-h-[60px] font-poppins" role="tab" aria-selected="true" aria-controls="contentDataInput">
                    <i class="fas fa-clipboard-list mr-2" aria-hidden="true"></i>
                    Data Input
                </button>
                <button type="button" onclick="switchTab('hasilResiko')" id="tabHasilResiko" class="flex-1 px-6 py-4 font-semibold text-gray-900 hover:bg-white transition-all border-b-2 border-transparent focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-inset min-h-[60px] font-poppins" role="tab" aria-selected="false" aria-controls="contentHasilResiko">
                    <i class="fas fa-chart-pie mr-2" aria-hidden="true"></i>
                    Hasil & Rekomendasi
                </button>
            </div>
        </div>

        {{-- Tab Content --}}
        <div class="flex-1 overflow-y-auto p-6" style="max-height: calc(90vh - 250px);">
            {{-- Tab 1: Data Input --}}
            <div id="contentDataInput" class="space-y-6" role="tabpanel" aria-labelledby="tabDataInput">
                {{-- Data Pribadi --}}
                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-5 border-l-4 border-blue-600">
                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2 font-poppins">
                        <i class="fas fa-user-circle text-blue-700" aria-hidden="true"></i>
                        Data Pribadi
                    </h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <div class="text-xs text-gray-700 mb-1">Nama</div>
                            <div class="font-semibold text-gray-900" id="modalNama">-</div>
                        </div>
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <div class="text-xs text-gray-700 mb-1">Usia</div>
                            <div class="font-semibold text-gray-900" id="modalUsia">-</div>
                        </div>
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <div class="text-xs text-gray-700 mb-1">Jenis Kelamin</div>
                            <div class="font-semibold text-gray-900" id="modalJenisKelamin">-</div>
                        </div>
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <div class="text-xs text-gray-700 mb-1">Berat Badan</div>
                            <div class="font-semibold text-gray-900"><span id="modalBeratBadan">-</span> kg</div>
                        </div>
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <div class="text-xs text-gray-700 mb-1">Tinggi Badan</div>
                            <div class="font-semibold text-gray-900"><span id="modalTinggiBadan">-</span> cm</div>
                        </div>
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <div class="text-xs text-gray-700 mb-1">IMT</div>
                            <div class="font-semibold text-gray-900" id="modalIMT">-</div>
                        </div>
                    </div>
                </div>

                {{-- Riwayat Penyakit --}}
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-5 border-l-4 border-purple-600">
                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2 font-poppins">
                        <i class="fas fa-notes-medical text-purple-700" aria-hidden="true"></i>
                        Riwayat Penyakit & Keluarga
                    </h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <div class="text-xs text-gray-700 mb-1">Keluarga Diabetes</div>
                            <div class="font-semibold text-gray-900" id="modalKeluargaDiabetes">-</div>
                        </div>
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <div class="text-xs text-gray-700 mb-1">Riwayat Hipertensi</div>
                            <div class="font-semibold text-gray-900" id="modalHipertensi">-</div>
                        </div>
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <div class="text-xs text-gray-700 mb-1">Riwayat Obesitas</div>
                            <div class="font-semibold text-gray-900" id="modalObesitas">-</div>
                        </div>
                    </div>
                </div>

                {{-- Gaya Hidup --}}
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-5 border-l-4 border-green-600">
                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2 font-poppins">
                        <i class="fas fa-walking text-green-700" aria-hidden="true"></i>
                        Gaya Hidup
                    </h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <div class="text-xs text-gray-700 mb-1 flex items-center gap-1">
                                <i class="fas fa-running text-blue-600" aria-hidden="true"></i>
                                Olahraga
                            </div>
                            <div class="font-semibold text-gray-900" id="modalOlahraga">-</div>
                        </div>
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <div class="text-xs text-gray-700 mb-1 flex items-center gap-1">
                                <i class="fas fa-utensils text-green-600" aria-hidden="true"></i>
                                Pola Makan
                            </div>
                            <div class="font-semibold text-gray-900" id="modalPolaMakan">-</div>
                        </div>
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <div class="text-xs text-gray-700 mb-1 flex items-center gap-1">
                                <i class="fas fa-smoking text-red-600" aria-hidden="true"></i>
                                Merokok
                            </div>
                            <div class="font-semibold text-gray-900" id="modalMerokok">-</div>
                        </div>
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <div class="text-xs text-gray-700 mb-1 flex items-center gap-1">
                                <i class="fas fa-wine-bottle text-purple-600" aria-hidden="true"></i>
                                Alkohol
                            </div>
                            <div class="font-semibold text-gray-900" id="modalAlkohol">-</div>
                        </div>
                    </div>
                </div>

                {{-- Data Medis --}}
                <div class="bg-gradient-to-r from-red-50 to-orange-50 rounded-xl p-5 border-l-4 border-red-600">
                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2 font-poppins">
                        <i class="fas fa-heartbeat text-red-700" aria-hidden="true"></i>
                        Data Medis
                    </h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <div class="text-xs text-gray-700 mb-1">Gula Darah Sewaktu</div>
                            <div class="font-semibold text-lg text-gray-900 font-poppins"><span id="modalGulaDarah">-</span> <span class="text-xs text-gray-700">mg/dL</span></div>
                        </div>
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <div class="text-xs text-gray-700 mb-1">HbA1c</div>
                            <div class="font-semibold text-lg text-gray-900 font-poppins"><span id="modalHbA1c">-</span> <span class="text-xs text-gray-700">%</span></div>
                        </div>
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <div class="text-xs text-gray-700 mb-1">Kolesterol</div>
                            <div class="font-semibold text-lg text-gray-900 font-poppins"><span id="modalKolesterol">-</span> <span class="text-xs text-gray-700">mg/dL</span></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab 2: Hasil & Rekomendasi --}}
            <div id="contentHasilResiko" class="space-y-6 hidden" role="tabpanel" aria-labelledby="tabHasilResiko">
                {{-- Status Diabetes & Skor Resiko --}}
                <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-xl p-5 border-l-4 border-green-700">
                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2 font-poppins">
                        <i class="fas fa-chart-line text-green-700" aria-hidden="true"></i>
                        Hasil Analisis
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-white rounded-lg p-4 shadow-md text-center">
                            <div class="text-sm text-gray-700 mb-2">Status Diabetes</div>
                            <div class="text-2xl font-bold font-poppins" id="modalStatusDiabetes">-</div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-md text-center">
                            <div class="text-sm text-gray-700 mb-2">Tingkat Resiko</div>
                            <div id="modalTingkatResikoBadge"></div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-md text-center">
                            <div class="text-sm text-gray-700 mb-2">Skor Resiko</div>
                            <div class="text-3xl font-bold text-green-700 font-poppins"><span id="modalSkorResiko">-</span>%</div>
                        </div>
                    </div>
                </div>

                {{-- Penjelasan Resiko --}}
                <div class="bg-blue-50 rounded-xl p-5 border-l-4 border-blue-600">
                    <h4 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2 font-poppins">
                        <i class="fas fa-info-circle text-blue-700" aria-hidden="true"></i>
                        Penjelasan Kondisi
                    </h4>
                    <p class="text-gray-800 leading-relaxed" id="modalPenjelasanResiko">-</p>
                </div>

                {{-- Rekomendasi Diet --}}
                <div class="bg-green-50 rounded-xl p-5 border-l-4 border-green-600">
                    <h4 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2 font-poppins">
                        <i class="fas fa-apple-alt text-green-700" aria-hidden="true"></i>
                        Rekomendasi Diet
                    </h4>
                    <p class="text-gray-800 leading-relaxed" id="modalRekomendasiDiet">-</p>
                </div>

                {{-- Rekomendasi Olahraga --}}
                <div class="bg-orange-50 rounded-xl p-5 border-l-4 border-orange-600">
                    <h4 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2 font-poppins">
                        <i class="fas fa-dumbbell text-orange-700" aria-hidden="true"></i>
                        Rekomendasi Olahraga
                    </h4>
                    <p class="text-gray-800 leading-relaxed" id="modalRekomendasiOlahraga">-</p>
                </div>

                {{-- Perubahan Gaya Hidup --}}
                <div class="bg-purple-50 rounded-xl p-5 border-l-4 border-purple-600">
                    <h4 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2 font-poppins">
                        <i class="fas fa-heart text-purple-700" aria-hidden="true"></i>
                        Perubahan Gaya Hidup
                    </h4>
                    <p class="text-gray-800 leading-relaxed" id="modalPerubahanGayaHidup">-</p>
                </div>

                {{-- Tips Pencegahan --}}
                <div class="bg-yellow-50 rounded-xl p-5 border-l-4 border-yellow-600">
                    <h4 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2 font-poppins">
                        <i class="fas fa-lightbulb text-yellow-700" aria-hidden="true"></i>
                        Tips Pencegahan
                    </h4>
                    <p class="text-gray-800 leading-relaxed" id="modalTipsPencegahan">-</p>
                </div>

                {{-- Konsultasi Medis --}}
                <div id="modalKonsultasiSection" class="bg-red-50 rounded-xl p-5 border-l-4 border-red-600 hidden">
                    <h4 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2 font-poppins">
                        <i class="fas fa-user-md text-red-700" aria-hidden="true"></i>
                        Rekomendasi Konsultasi
                    </h4>
                    <div class="flex items-start gap-3">
                        <div class="shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation text-red-700" aria-hidden="true"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-800 leading-relaxed" id="modalPesanKonsultasi">-</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Actions --}}
        <div class="bg-gray-50 p-4 border-t border-gray-200 flex gap-3">
            <button type="button" onclick="closeDetailModal()" class="flex-1 px-4 py-3 bg-gray-300 hover:bg-gray-400 text-gray-900 rounded-lg font-medium transition-all focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 min-h-[48px] font-medium">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Tutup
            </button>
            <button type="button" onclick="printReport()" class="flex-1 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-all focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 min-h-[48px] font-medium">
                <i class="fas fa-print mr-2" aria-hidden="true"></i>Cetak
            </button>
            <button type="button" onclick="downloadDetailReport()" class="flex-1 px-4 py-3 bg-green-700 hover:bg-green-800 text-white rounded-lg font-medium transition-all focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 min-h-[48px] font-medium">
                <i class="fas fa-download mr-2" aria-hidden="true"></i>Unduh PDF
            </button>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Import fonts */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap');
    
    .font-poppins {
        font-family: 'Poppins', sans-serif;
    }
    
    .font-inter {
        font-family: 'Inter', sans-serif;
    }
</style>
@endpush

@push('scripts')
<script id="riwayat-data" type="application/json">
{!! json_encode($riwayat->keyBy('id_riwayat_kesehatan'), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}
</script>

<script>
    // Data untuk modal - ambil dari JSON script tag
    const riwayatDataScript = document.getElementById('riwayat-data');
    const riwayatData = JSON.parse(riwayatDataScript.textContent);

    // Tab switching
    function switchTab(tabName) {
        // Hide all content
        document.getElementById('contentDataInput').classList.add('hidden');
        document.getElementById('contentHasilResiko').classList.add('hidden');
        
        // Remove active class from all tabs
        document.getElementById('tabDataInput').classList.remove('bg-white', 'border-green-700', 'text-green-700');
        document.getElementById('tabDataInput').setAttribute('aria-selected', 'false');
        document.getElementById('tabHasilResiko').classList.remove('bg-white', 'border-green-700', 'text-green-700');
        document.getElementById('tabHasilResiko').setAttribute('aria-selected', 'false');
        
        // Show selected content and activate tab
        if (tabName === 'dataInput') {
            document.getElementById('contentDataInput').classList.remove('hidden');
            document.getElementById('tabDataInput').classList.add('bg-white', 'border-green-700', 'text-green-700');
            document.getElementById('tabDataInput').setAttribute('aria-selected', 'true');
        } else {
            document.getElementById('contentHasilResiko').classList.remove('hidden');
            document.getElementById('tabHasilResiko').classList.add('bg-white', 'border-green-700', 'text-green-700');
            document.getElementById('tabHasilResiko').setAttribute('aria-selected', 'true');
        }
    }

    // Modal Functions
    function openDetailModal(id) {
        const data = riwayatData[id];
        if (!data) {
            console.error('Data tidak ditemukan untuk ID:', id);
            return;
        }

        // Set tanggal
        document.getElementById('modalDate').textContent = formatDate(data.created_at);

        // TAB 1: DATA INPUT
        // Data Pribadi
        document.getElementById('modalNama').textContent = data.nama;
        document.getElementById('modalUsia').textContent = data.usia + ' tahun';
        document.getElementById('modalJenisKelamin').textContent = data.jenis_kelamin;
        document.getElementById('modalBeratBadan').textContent = data.berat_badan;
        document.getElementById('modalTinggiBadan').textContent = data.tinggi_badan;
        document.getElementById('modalIMT').textContent = data.imt;

        // Riwayat Penyakit
        document.getElementById('modalKeluargaDiabetes').textContent = data.keluarga_diabetes;
        document.getElementById('modalHipertensi').textContent = data.riwayat_hipertensi;
        document.getElementById('modalObesitas').textContent = data.riwayat_obesitas;

        // Gaya Hidup
        document.getElementById('modalOlahraga').textContent = data.olahraga;
        document.getElementById('modalPolaMakan').textContent = data.pola_makan;
        document.getElementById('modalMerokok').textContent = data.merokok;
        document.getElementById('modalAlkohol').textContent = data.minum_alkohol;

        // Data Medis
        document.getElementById('modalGulaDarah').textContent = data.gula_darah_sewaktu;
        document.getElementById('modalHbA1c').textContent = data.hba1c;
        document.getElementById('modalKolesterol').textContent = data.kolesterol;

        // TAB 2: HASIL & REKOMENDASI
        // Status & Skor
        document.getElementById('modalStatusDiabetes').textContent = data.status_diabetes;
        
        // Status color coding
        const statusEl = document.getElementById('modalStatusDiabetes');
        if (data.status_diabetes === 'Normal') {
            statusEl.className = 'text-2xl font-bold text-green-700 font-poppins';
        } else if (data.status_diabetes === 'Prediabetes') {
            statusEl.className = 'text-2xl font-bold text-yellow-700 font-poppins';
        } else {
            statusEl.className = 'text-2xl font-bold text-red-700 font-poppins';
        }

        // Tingkat Resiko Badge
        let resikoBadgeHtml = '';
        if (data.tingkat_resiko === 'Rendah') {
            resikoBadgeHtml = '<span class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 text-green-800 rounded-full text-lg font-bold font-poppins"><i class="fas fa-check-circle" aria-hidden="true"></i>Rendah</span>';
        } else if (data.tingkat_resiko === 'Sedang') {
            resikoBadgeHtml = '<span class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-lg font-bold font-poppins"><i class="fas fa-exclamation-circle" aria-hidden="true"></i>Sedang</span>';
        } else {
            resikoBadgeHtml = '<span class="inline-flex items-center gap-2 px-4 py-2 bg-red-100 text-red-800 rounded-full text-lg font-bold font-poppins"><i class="fas fa-exclamation-triangle" aria-hidden="true"></i>Tinggi</span>';
        }
        document.getElementById('modalTingkatResikoBadge').innerHTML = resikoBadgeHtml;

        document.getElementById('modalSkorResiko').textContent = data.skor_resiko;

        // Penjelasan & Rekomendasi
        document.getElementById('modalPenjelasanResiko').textContent = data.penjelasan_resiko;
        document.getElementById('modalRekomendasiDiet').textContent = data.rekomendasi_diet;
        document.getElementById('modalRekomendasiOlahraga').textContent = data.rekomendasi_olahraga;
        document.getElementById('modalPerubahanGayaHidup').textContent = data.perubahan_gaya_hidup;
        document.getElementById('modalTipsPencegahan').textContent = data.tips_pencegahan;
        document.getElementById('modalPesanKonsultasi').textContent = data.pesan_konsultasi;

        // Show/hide konsultasi section
        const konsultasiSection = document.getElementById('modalKonsultasiSection');
        if (data.perlu_konsul === 'Ya') {
            konsultasiSection.classList.remove('hidden');
        } else {
            konsultasiSection.classList.add('hidden');
        }

        // Tampilkan modal dengan tab pertama aktif
        switchTab('dataInput');
        const modal = document.getElementById('detailModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.classList.add('animate-fadeIn');
        modal.setAttribute('aria-hidden', 'false');
        
        // Focus trap untuk aksesibilitas
        const firstFocusableElement = modal.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
        if (firstFocusableElement) firstFocusableElement.focus();
    }

    function closeDetailModal() {
        const modal = document.getElementById('detailModal');
        modal.classList.remove('animate-fadeIn');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modal.setAttribute('aria-hidden', 'true');
        
        // Kembalikan fokus ke elemen yang membuka modal
        const lastFocusedElement = document.activeElement;
        if (lastFocusedElement && lastFocusedElement.classList.contains('history-item')) {
            lastFocusedElement.focus();
        }
    }

    // Format tanggal
    function formatDate(dateStr) {
        const date = new Date(dateStr);
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        }) + ' WIB';
    }

    // Download & Print Functions
    function downloadReport() {
        alert('Fitur Unduh Laporan Lengkap akan segera tersedia!\n\nLaporan akan berisi:\n- Ringkasan semua riwayat pemeriksaan\n- Grafik perkembangan kesehatan\n- Analisis tren gula darah');
    }

    function downloadDetailReport() {
        alert('Fitur Unduh Detail Riwayat (PDF) akan segera tersedia!\n\nLaporan akan berisi:\n- Data input lengkap\n- Hasil analisis AI\n- Rekomendasi kesehatan');
    }

    function printReport() {
        alert('Fitur Cetak Laporan akan segera tersedia!\n\nAnda dapat mencetak detail riwayat kesehatan ini.');
    }

    // Event Listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Click handler untuk history items
        const historyItems = document.querySelectorAll('.history-item');
        historyItems.forEach(item => {
            item.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                openDetailModal(parseInt(id));
            });

            // Keyboard support
            item.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    const id = this.getAttribute('data-id');
                    openDetailModal(parseInt(id));
                }
            });
        });

        // Close modal on ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeDetailModal();
            }
        });

        // Close modal on outside click
        const modal = document.getElementById('detailModal');
        if (modal) {
            modal.addEventListener('click', function(event) {
                if (event.target === this) {
                    closeDetailModal();
                }
            });
        }
        
        // Keyboard navigation untuk tab
        const tabs = document.querySelectorAll('[role="tab"]');
        tabs.forEach(tab => {
            tab.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    const tabName = this.getAttribute('aria-controls').replace('content', '').toLowerCase();
                    switchTab(tabName);
                }
            });
        });
    });
</script>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out;
    }

    /* Custom scrollbar */
    .overflow-y-auto::-webkit-scrollbar {
        width: 8px;
    }

    .overflow-y-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #15803d;
        border-radius: 10px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #166534;
    }

    /* Smooth transitions */
    #contentDataInput,
    #contentHasilResiko {
        transition: opacity 0.3s ease-in-out;
    }

    /* Max height utility */
    .max-h-screen-90 {
        max-height: 90vh;
    }
    
    /* Focus styles untuk aksesibilitas */
    button:focus-visible,
    [role="button"]:focus-visible,
    [tabindex]:focus-visible {
        outline: 2px solid #15803d;
        outline-offset: 2px;
    }

    /* Font family defaults */
    body {
        font-family: 'Inter', sans-serif;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: 'Poppins', sans-serif;
    }
</style>
@endpush