@extends('layouts.navbar')

@section('title', 'Riwayat Kesehatan')
@section('page_title', 'Riwayat Kesehatan')

@section('content')
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

        {{-- Cek apakah ada riwayat --}}
        @if($riwayat->isEmpty())
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                    <i class="fas fa-history text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Riwayat</h3>
                <p class="text-gray-600 mb-6">Anda belum melakukan pemeriksaan. Mulai deteksi diabetes sekarang!</p>
                <a href="{{ route('deteksi.create') }}" class="inline-flex items-center px-6 py-3 bg-green-700 text-white rounded-lg font-semibold hover:bg-green-800 transition-all shadow-md">
                    <i class="fas fa-clipboard-list mr-2"></i>
                    Lakukan Pemeriksaan
                </a>
            </div>
        @else
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
        @endif

    </div>
</div>

{{-- Hidden JSON Data --}}
<script id="riwayat-data" type="application/json">
{!! json_encode($riwayat->keyBy('id_riwayat_kesehatan')) !!}
</script>

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

    #contentDataInput,
    #contentHasilResiko {
        transition: opacity 0.3s ease-in-out;
    }

    .max-h-screen-90 {
        max-height: 90vh;
    }
    
    button:focus-visible,
    [role="button"]:focus-visible,
    [tabindex]:focus-visible {
        outline: 2px solid #15803d;
        outline-offset: 2px;
    }

    body {
        font-family: 'Inter', sans-serif;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: 'Poppins', sans-serif;
    }
</style>
@endpush

@push('scripts')
<script>
    // Data riwayat dari server
    let riwayatData = {};
    
    document.addEventListener('DOMContentLoaded', function() {
        // Parse JSON data
        const scriptTag = document.getElementById('riwayat-data');
        if (scriptTag) {
            try {
                riwayatData = JSON.parse(scriptTag.textContent);
                console.log('Data loaded:', riwayatData);
            } catch (e) {
                console.error('Error parsing JSON:', e);
            }
        }

        // Event listeners untuk history items
        const historyItems = document.querySelectorAll('.history-item');
        historyItems.forEach(item => {
            item.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                openDetailModal(id);
            });

            item.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    const id = this.getAttribute('data-id');
                    openDetailModal(id);
                }
            });
        });

        // Close modal dengan ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeDetailModal();
            }
        });

        // Close modal dengan click outside
        const modal = document.getElementById('detailModal');
        if (modal) {
            modal.addEventListener('click', function(event) {
                if (event.target === this) {
                    closeDetailModal();
                }
            });
        }
    });

    function switchTab(tabName) {
        document.getElementById('contentDataInput').classList.add('hidden');
        document.getElementById('contentHasilResiko').classList.add('hidden');
        
        document.getElementById('tabDataInput').classList.remove('bg-white', 'border-green-700', 'text-green-700');
        document.getElementById('tabDataInput').setAttribute('aria-selected', 'false');
        document.getElementById('tabHasilResiko').classList.remove('bg-white', 'border-green-700', 'text-green-700');
        document.getElementById('tabHasilResiko').setAttribute('aria-selected', 'false');
        
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

    function openDetailModal(id) {
        const data = riwayatData[id];
        if (!data) {
            console.error('Data tidak ditemukan untuk ID:', id);
            alert('Data tidak ditemukan!');
            return;
        }

        console.log('Opening modal with data:', data);

        // Set tanggal
        document.getElementById('modalDate').textContent = formatDate(data.created_at);

        // TAB 1: DATA INPUT
        document.getElementById('modalNama').textContent = data.nama || '-';
        document.getElementById('modalUsia').textContent = (data.usia || '-') + ' tahun';
        document.getElementById('modalJenisKelamin').textContent = data.jenis_kelamin || '-';
        document.getElementById('modalBeratBadan').textContent = data.berat_badan || '-';
        document.getElementById('modalTinggiBadan').textContent = data.tinggi_badan || '-';
        document.getElementById('modalIMT').textContent = data.imt || '-';

        document.getElementById('modalKeluargaDiabetes').textContent = data.keluarga_diabetes || '-';
        document.getElementById('modalHipertensi').textContent = data.riwayat_hipertensi || '-';
        document.getElementById('modalObesitas').textContent = data.riwayat_obesitas || '-';

        document.getElementById('modalOlahraga').textContent = data.olahraga || '-';
        document.getElementById('modalPolaMakan').textContent = data.pola_makan || '-';
        document.getElementById('modalMerokok').textContent = data.merokok || '-';
        document.getElementById('modalAlkohol').textContent = data.minum_alkohol || '-';

        // TAB 2: HASIL & REKOMENDASI
        document.getElementById('modalStatusDiabetes').textContent = data.status_diabetes || '-';
        
        const statusEl = document.getElementById('modalStatusDiabetes');
        if (data.status_diabetes === 'Normal') {
            statusEl.className = 'text-2xl font-bold text-green-700 font-poppins';
        } else if (data.status_diabetes === 'Prediabetes') {
            statusEl.className = 'text-2xl font-bold text-yellow-700 font-poppins';
        } else {
            statusEl.className = 'text-2xl font-bold text-red-700 font-poppins';
        }

        let resikoBadgeHtml = '';
        if (data.tingkat_resiko === 'Rendah') {
            resikoBadgeHtml = '<span class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 text-green-800 rounded-full text-lg font-bold font-poppins"><i class="fas fa-check-circle"></i>Rendah</span>';
        } else if (data.tingkat_resiko === 'Sedang') {
            resikoBadgeHtml = '<span class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-lg font-bold font-poppins"><i class="fas fa-exclamation-circle"></i>Sedang</span>';
        } else {
            resikoBadgeHtml = '<span class="inline-flex items-center gap-2 px-4 py-2 bg-red-100 text-red-800 rounded-full text-lg font-bold font-poppins"><i class="fas fa-exclamation-triangle"></i>Tinggi</span>';
        }
        document.getElementById('modalTingkatResikoBadge').innerHTML = resikoBadgeHtml;

        document.getElementById('modalSkorResiko').textContent = data.skor_resiko || '-';

        document.getElementById('modalPenjelasanResiko').textContent = data.penjelasan_resiko || '-';
        document.getElementById('modalRekomendasiDiet').textContent = data.rekomendasi_diet || '-';
        document.getElementById('modalRekomendasiOlahraga').textContent = data.rekomendasi_olahraga || '-';
        document.getElementById('modalPerubahanGayaHidup').textContent = data.perubahan_gaya_hidup || '-';
        document.getElementById('modalTipsPencegahan').textContent = data.tips_pencegahan || '-';
        document.getElementById('modalPesanKonsultasi').textContent = data.pesan_konsultasi || '-';

        const konsultasiSection = document.getElementById('modalKonsultasiSection');
        if (data.perlu_konsul === 'Ya') {
            konsultasiSection.classList.remove('hidden');
        } else {
            konsultasiSection.classList.add('hidden');
        }

        switchTab('dataInput');
        const modal = document.getElementById('detailModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex', 'animate-fadeIn');
        modal.setAttribute('aria-hidden', 'false');
    }

    function closeDetailModal() {
        const modal = document.getElementById('detailModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex', 'animate-fadeIn');
        modal.setAttribute('aria-hidden', 'true');
    }

    function formatDate(dateStr) {
        const date = new Date(dateStr);
        const options = {
            day: '2-digit',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        return date.toLocaleDateString('id-ID', options) + ' WIB';
    }

    function downloadReport() {
        // Ambil semua data riwayat
        const allData = Object.values(riwayatData);
        
        if (allData.length === 0) {
            alert('Tidak ada data untuk diunduh!');
            return;
        }

        // Buat HTML untuk laporan
        let html = `
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Riwayat Kesehatan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #15803d;
        }
        .header h1 {
            color: #15803d;
            margin: 0;
        }
        .header p {
            color: #666;
            margin: 10px 0;
        }
        .summary {
            background: #f0fdf4;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            border-left: 4px solid #15803d;
        }
        .summary h2 {
            color: #15803d;
            margin-top: 0;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 15px;
        }
        .summary-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }
        .summary-item .label {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }
        .summary-item .value {
            font-size: 24px;
            font-weight: bold;
            color: #15803d;
        }
        .history-list {
            margin-top: 30px;
        }
        .history-item {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f3f4f6;
        }
        .history-date {
            font-size: 16px;
            font-weight: bold;
            color: #15803d;
        }
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-rendah {
            background: #dcfce7;
            color: #166534;
        }
        .badge-sedang {
            background: #fef3c7;
            color: #92400e;
        }
        .badge-tinggi {
            background: #fee2e2;
            color: #991b1b;
        }
        .data-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin: 15px 0;
        }
        .data-item {
            background: #f9fafb;
            padding: 10px;
            border-radius: 6px;
        }
        .data-item .label {
            font-size: 11px;
            color: #666;
            margin-bottom: 3px;
        }
        .data-item .value {
            font-weight: bold;
            color: #333;
        }
        .recommendations {
            background: #fffbeb;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            border-left: 4px solid #f59e0b;
        }
        .recommendations h4 {
            color: #92400e;
            margin: 0 0 10px 0;
            font-size: 14px;
        }
        .recommendations p {
            margin: 5px 0;
            font-size: 13px;
            line-height: 1.6;
        }
        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin: 30px 0;
            border: 2px solid #e5e7eb;
        }
        .chart-container h2 {
            color: #15803d;
            margin-top: 0;
        }
        .chart {
            width: 100%;
            height: 250px;
            position: relative;
            margin-top: 20px;
        }
        .bar-chart {
            display: flex;
            align-items: flex-end;
            height: 200px;
            gap: 10px;
            padding: 20px 0;
        }
        .bar {
            flex: 1;
            background: linear-gradient(to top, #15803d, #22c55e);
            border-radius: 8px 8px 0 0;
            position: relative;
            min-height: 20px;
        }
        .bar-label {
            position: absolute;
            bottom: -25px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 11px;
            color: #666;
        }
        .bar-value {
            position: absolute;
            top: -20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            color: #15803d;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        @media print {
            body { margin: 20px; }
            .history-item { page-break-inside: avoid; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📊 Laporan Riwayat Kesehatan</h1>
        <p>Sistem Deteksi Dini Diabetes</p>
        <p>Tanggal Cetak: ${new Date().toLocaleDateString('id-ID', { 
            day: '2-digit', 
            month: 'long', 
            year: 'numeric' 
        })}</p>
    </div>

    <div class="summary">
        <h2>📈 Ringkasan Pemeriksaan</h2>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="label">Total Pemeriksaan</div>
                <div class="value">${allData.length}</div>
            </div>
            <div class="summary-item">
                <div class="label">Rata-rata Gula Darah</div>
                <div class="value">${Math.round(allData.reduce((sum, d) => sum + parseFloat(d.gula_darah_sewaktu), 0) / allData.length)} mg/dL</div>
            </div>
            <div class="summary-item">
                <div class="label">Rata-rata Skor Risiko</div>
                <div class="value">${Math.round(allData.reduce((sum, d) => sum + parseFloat(d.skor_resiko), 0) / allData.length)}%</div>
            </div>
        </div>
    </div>

    <div class="chart-container">
        <h2>📉 Grafik Perkembangan Gula Darah</h2>
        <div class="bar-chart">
            ${allData.slice(0, 10).reverse().map((d, i) => {
                const maxValue = Math.max(...allData.map(x => parseFloat(x.gula_darah_sewaktu)));
                const height = (parseFloat(d.gula_darah_sewaktu) / maxValue) * 100;
                return `
                    <div class="bar" style="height: ${height}%">
                        <div class="bar-value">${d.gula_darah_sewaktu}</div>
                        <div class="bar-label">${new Date(d.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short' })}</div>
                    </div>
                `;
            }).join('')}
        </div>
    </div>

    <div class="history-list">
        <h2 style="color: #15803d; margin-bottom: 20px;">📋 Detail Riwayat Pemeriksaan</h2>
        ${allData.map(data => `
            <div class="history-item">
                <div class="history-header">
                    <div class="history-date">
                        📅 ${formatDate(data.created_at)}
                    </div>
                    <span class="badge badge-${data.tingkat_resiko.toLowerCase()}">
                        Risiko ${data.tingkat_resiko}
                    </span>
                </div>

                <div class="data-grid">
                    <div class="data-item">
                        <div class="label">Status</div>
                        <div class="value">${data.status_diabetes}</div>
                    </div>
                    <div class="data-item">
                        <div class="label">Gula Darah</div>
                        <div class="value">${data.gula_darah_sewaktu} mg/dL</div>
                    </div>
                    <div class="data-item">
                        <div class="label">Skor Risiko</div>
                        <div class="value">${data.skor_resiko}%</div>
                    </div>
                    <div class="data-item">
                        <div class="label">IMT</div>
                        <div class="value">${data.imt}</div>
                    </div>
                </div>

                <div class="recommendations">
                    <h4>💡 Rekomendasi</h4>
                    <p><strong>Diet:</strong> ${data.rekomendasi_diet}</p>
                    <p><strong>Olahraga:</strong> ${data.rekomendasi_olahraga}</p>
                    ${data.perlu_konsul === 'Ya' ? '<p style="color: #991b1b;"><strong>⚠️ Perlu Konsultasi Dokter</strong></p>' : ''}
                </div>
            </div>
        `).join('')}
    </div>

    <div class="footer">
        <p><strong>Catatan:</strong> Laporan ini bersifat informatif dan tidak menggantikan konsultasi medis profesional.</p>
        <p>Untuk informasi lebih lanjut, silakan berkonsultasi dengan tenaga kesehatan.</p>
    </div>
</body>
</html>
        `;

        // Buka window baru dan print
        const printWindow = window.open('', '_blank');
        printWindow.document.write(html);
        printWindow.document.close();
        
        // Tunggu sebentar untuk load, lalu print dan download
        setTimeout(() => {
            printWindow.print();
            
            // Optional: Auto download as PDF (works in some browsers)
            // printWindow.document.title = 'Laporan_Kesehatan_' + new Date().toISOString().split('T')[0];
        }, 500);
    }

    function downloadDetailReport() {
        alert('Fitur Unduh Detail Riwayat (PDF) akan segera tersedia!\n\nLaporan akan berisi:\n- Data input lengkap\n- Hasil analisis AI\n- Rekomendasi kesehatan');
    }

    function printReport() {
        alert('Fitur Cetak Laporan akan segera tersedia!\n\nAnda dapat mencetak detail riwayat kesehatan ini.');
    }
</script>
@endpush