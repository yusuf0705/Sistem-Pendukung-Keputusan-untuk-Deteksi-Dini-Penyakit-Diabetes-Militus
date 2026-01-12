@extends('layouts.navbar')

@section('title', 'Riwayat Kesehatan')
@section('page_title', 'Riwayat Kesehatan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50 py-8 px-4">
    <div class="max-w-7xl mx-auto">

        {{-- Header Section --}}
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-6">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">
                        📋 Riwayat Kesehatan Saya
                    </h1>
                    <p class="text-gray-600">
                        Pantau perkembangan kesehatan Anda secara berkala
                    </p>
                </div>
                @if(!$riwayat->isEmpty())
                <button type="button" onclick="previewReport()" 
                    class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-semibold hover:from-green-700 hover:to-green-800 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-file-alt mr-2"></i>
                    Unduh Laporan
                </button>
                @endif
            </div>
        </div>

        {{-- Cek apakah ada riwayat --}}
        @if($riwayat->isEmpty())
            <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-green-100 to-blue-100 rounded-full mb-6">
                    <i class="fas fa-history text-5xl text-green-600"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 mb-3">Belum Ada Riwayat</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Anda belum melakukan pemeriksaan diabetes. Mulai deteksi sekarang untuk memantau kesehatan Anda!
                </p>
                <a href="{{ route('deteksi.create') }}" 
                    class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-bold text-lg hover:from-green-700 hover:to-green-800 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-clipboard-list mr-2"></i>
                    Lakukan Pemeriksaan
                </a>
            </div>
        @else
            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                {{-- Total Pemeriksaan --}}
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm mb-1">Total Pemeriksaan</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $riwayat->count() }}</p>
                        </div>
                        <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-file-medical text-2xl text-blue-600"></i>
                        </div>
                    </div>
                </div>

                {{-- Rata-rata Skor Risiko --}}
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm mb-1">Rata-rata Skor Risiko</p>
                            <p class="text-3xl font-bold text-gray-800">
                                {{ round($riwayat->avg('skor_resiko')) }}
                                <span class="text-sm font-normal text-gray-600">%</span>
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-line text-2xl text-green-600"></i>
                        </div>
                    </div>
                </div>

                {{-- Pemeriksaan Terakhir --}}
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm mb-1">Pemeriksaan Terakhir</p>
                            <p class="text-lg font-bold text-gray-800">
                                {{ $riwayat->first()->created_at->format('d M Y') }}
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ $riwayat->first()->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-check text-2xl text-purple-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- History List --}}
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b-2 border-green-500">
                    📊 Riwayat Detail Pemeriksaan
                </h2>

                <div class="space-y-4">
                    @foreach ($riwayat as $index => $data)
                        <div class="history-item group relative bg-gradient-to-r from-gray-50 to-white rounded-xl p-6 border-2 border-gray-200 hover:border-green-500 hover:shadow-lg transition-all duration-300 cursor-pointer"
                             onclick="openDetailModal('{{ $data->id_riwayat_kesehatan }}')"
                             role="button" 
                             tabindex="0"
                             onkeypress="if(event.key === 'Enter') openDetailModal('{{ $data->id_riwayat_kesehatan }}')">
                            
                            {{-- Timeline Indicator --}}
                            <div class="absolute -left-4 top-1/2 transform -translate-y-1/2 w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-full border-4 border-white shadow-md group-hover:scale-110 transition-transform"></div>
                            
                            <div class="ml-6 grid grid-cols-1 lg:grid-cols-12 gap-4 items-center">
                                {{-- Date & Time --}}
                                <div class="lg:col-span-3">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-gradient-to-br from-green-100 to-green-200 rounded-lg p-3">
                                            <i class="fas fa-calendar-day text-green-700 text-xl"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-800">{{ $data->created_at->format('d M Y') }}</div>
                                            <div class="text-sm text-gray-500">{{ $data->created_at->format('H:i') }} WIB</div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Status Diabetes --}}
                                <div class="lg:col-span-2">
                                    <div class="text-center bg-gradient-to-br {{ $data->status_diabetes === 'Normal' ? 'from-green-50 to-green-100' : ($data->status_diabetes === 'Prediabetes' ? 'from-yellow-50 to-yellow-100' : 'from-red-50 to-red-100') }} rounded-lg p-4 shadow-sm">
                                        <div class="text-2xl font-bold {{ $data->status_diabetes === 'Normal' ? 'text-green-700' : ($data->status_diabetes === 'Prediabetes' ? 'text-yellow-700' : 'text-red-700') }}">
                                            {{ $data->status_diabetes }}
                                        </div>
                                        <div class="text-xs text-gray-600 mt-1 font-semibold">Status</div>
                                    </div>
                                </div>

                                {{-- Risk Level Badge --}}
                                <div class="lg:col-span-2 flex justify-center">
                                    @if ($data->tingkat_resiko === 'Rendah')
                                        <span class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-green-100 to-green-200 text-green-800 rounded-full text-sm font-bold shadow-sm">
                                            <i class="fas fa-check-circle"></i>
                                            Risiko Rendah
                                        </span>
                                    @elseif ($data->tingkat_resiko === 'Sedang')
                                        <span class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 rounded-full text-sm font-bold shadow-sm">
                                            <i class="fas fa-exclamation-circle"></i>
                                            Risiko Sedang
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-red-100 to-red-200 text-red-800 rounded-full text-sm font-bold shadow-sm">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            Risiko Tinggi
                                        </span>
                                    @endif
                                </div>

                                {{-- Quick Info --}}
                                <div class="lg:col-span-4">
                                    <div class="space-y-2">
                                        <div class="flex flex-wrap gap-2">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-xs font-semibold">
                                                <i class="fas fa-heartbeat"></i>
                                                {{ $data->status_diabetes }}
                                            </span>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-purple-50 text-purple-700 rounded-lg text-xs font-semibold">
                                                <i class="fas fa-chart-line"></i>
                                                Skor: {{ $data->skor_resiko }}%
                                            </span>
                                            @if($data->perlu_konsul === 'Ya')
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-xs font-semibold">
                                                    <i class="fas fa-user-md"></i>
                                                    Perlu Konsultasi
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-500 italic">
                                            Klik untuk melihat detail lengkap
                                        </p>
                                    </div>
                                </div>

                                {{-- Action Button --}}
                                <div class="lg:col-span-1 flex justify-end">
                                    <div class="w-10 h-10 bg-gray-100 group-hover:bg-green-100 rounded-full flex items-center justify-center transition-colors">
                                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-green-600 transition-colors"></i>
                                    </div>
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

{{-- Modal Detail --}}
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl shadow-2xl max-w-5xl w-full max-h-[90vh] overflow-hidden flex flex-col animate-slideIn">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold flex items-center gap-2">
                        <i class="fas fa-file-medical-alt"></i>
                        Detail Riwayat Kesehatan
                    </h3>
                    <p class="text-green-100 text-sm mt-1" id="modalDate">-</p>
                </div>
                <button onclick="closeDetailModal()" 
                    class="text-white hover:text-green-200 transition-colors p-2 hover:bg-white hover:bg-opacity-10 rounded-lg">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
        </div>

        {{-- Tab Navigation --}}
        <div class="bg-gray-50 border-b border-gray-200">
            <div class="flex">
                <button onclick="switchTab('dataInput')" id="tabDataInput" 
                    class="flex-1 px-6 py-4 font-semibold transition-all border-b-2">
                    <i class="fas fa-clipboard-list mr-2"></i>
                    Data Input
                </button>
                <button onclick="switchTab('hasilResiko')" id="tabHasilResiko" 
                    class="flex-1 px-6 py-4 font-semibold transition-all border-b-2">
                    <i class="fas fa-chart-pie mr-2"></i>
                    Hasil & Rekomendasi
                </button>
            </div>
        </div>

        {{-- Tab Content --}}
        <div class="flex-1 overflow-y-auto p-6">
            {{-- Tab 1: Data Input --}}
            <div id="contentDataInput" class="space-y-6">
                {{-- Data Pribadi --}}
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-6 border-l-4 border-blue-500">
                    <h4 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-user-circle text-blue-600"></i>
                        Data Pribadi
                    </h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="text-xs text-gray-600 mb-1 font-semibold">Nama</div>
                            <div class="font-bold text-gray-800" id="modalNama">-</div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="text-xs text-gray-600 mb-1 font-semibold">Usia</div>
                            <div class="font-bold text-gray-800" id="modalUsia">-</div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="text-xs text-gray-600 mb-1 font-semibold">Jenis Kelamin</div>
                            <div class="font-bold text-gray-800" id="modalJenisKelamin">-</div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="text-xs text-gray-600 mb-1 font-semibold">Berat Badan</div>
                            <div class="font-bold text-gray-800"><span id="modalBeratBadan">-</span> kg</div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="text-xs text-gray-600 mb-1 font-semibold">Tinggi Badan</div>
                            <div class="font-bold text-gray-800"><span id="modalTinggiBadan">-</span> cm</div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="text-xs text-gray-600 mb-1 font-semibold">IMT</div>
                            <div class="font-bold text-gray-800" id="modalIMT">-</div>
                        </div>
                    </div>
                </div>

                {{-- Riwayat Penyakit --}}
                <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl p-6 border-l-4 border-purple-500">
                    <h4 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-notes-medical text-purple-600"></i>
                        Riwayat Penyakit
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="text-xs text-gray-600 mb-1 font-semibold">Keluarga Diabetes</div>
                            <div class="font-bold text-gray-800" id="modalKeluargaDiabetes">-</div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="text-xs text-gray-600 mb-1 font-semibold">Riwayat Hipertensi</div>
                            <div class="font-bold text-gray-800" id="modalHipertensi">-</div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="text-xs text-gray-600 mb-1 font-semibold">Riwayat Obesitas</div>
                            <div class="font-bold text-gray-800" id="modalObesitas">-</div>
                        </div>
                    </div>
                </div>

                {{-- Gaya Hidup --}}
                <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-xl p-6 border-l-4 border-green-500">
                    <h4 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-running text-green-600"></i>
                        Gaya Hidup
                    </h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="text-xs text-gray-600 mb-1 font-semibold flex items-center gap-1">
                                <i class="fas fa-dumbbell text-blue-600"></i>
                                Olahraga
                            </div>
                            <div class="font-bold text-gray-800" id="modalOlahraga">-</div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="text-xs text-gray-600 mb-1 font-semibold flex items-center gap-1">
                                <i class="fas fa-utensils text-green-600"></i>
                                Pola Makan
                            </div>
                            <div class="font-bold text-gray-800" id="modalPolaMakan">-</div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="text-xs text-gray-600 mb-1 font-semibold flex items-center gap-1">
                                <i class="fas fa-smoking text-red-600"></i>
                                Merokok
                            </div>
                            <div class="font-bold text-gray-800" id="modalMerokok">-</div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="text-xs text-gray-600 mb-1 font-semibold flex items-center gap-1">
                                <i class="fas fa-wine-bottle text-purple-600"></i>
                                Alkohol
                            </div>
                            <div class="font-bold text-gray-800" id="modalAlkohol">-</div>
                        </div>
                    </div>
                </div>

                {{-- Gejala --}}
                <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-xl p-6 border-l-4 border-orange-500">
                    <h4 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-notes-medical text-orange-600"></i>
                        Gejala yang Dialami
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="text-xs text-gray-600 mb-1 font-semibold flex items-center gap-1">
                                <i class="fas fa-toilet text-blue-600"></i>
                                Sering BAK Malam
                            </div>
                            <div class="font-bold text-gray-800" id="modalSeringBAK">-</div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="text-xs text-gray-600 mb-1 font-semibold flex items-center gap-1">
                                <i class="fas fa-utensils text-orange-600"></i>
                                Sering Lapar
                            </div>
                            <div class="font-bold text-gray-800" id="modalSeringLapar">-</div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="text-xs text-gray-600 mb-1 font-semibold flex items-center gap-1">
                                <i class="fas fa-eye text-purple-600"></i>
                                Pandangan Kabur
                            </div>
                            <div class="font-bold text-gray-800" id="modalPandanganKabur">-</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab 2: Hasil & Rekomendasi --}}
            <div id="contentHasilResiko" class="space-y-6 hidden">
                {{-- Hasil Analisis --}}
                <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-xl p-6 border-l-4 border-green-600">
                    <h4 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-chart-line text-green-600"></i>
                        Hasil Analisis
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-white rounded-xl p-5 shadow-md text-center">
                            <div class="text-sm text-gray-600 mb-2 font-semibold">Status Diabetes</div>
                            <div class="text-2xl font-bold" id="modalStatusDiabetes">-</div>
                        </div>
                        <div class="bg-white rounded-xl p-5 shadow-md text-center">
                            <div class="text-sm text-gray-600 mb-2 font-semibold">Tingkat Risiko</div>
                            <div id="modalTingkatResikoBadge"></div>
                        </div>
                        <div class="bg-white rounded-xl p-5 shadow-md text-center">
                            <div class="text-sm text-gray-600 mb-2 font-semibold">Skor Risiko</div>
                            <div class="text-3xl font-bold text-green-700"><span id="modalSkorResiko">-</span>%</div>
                        </div>
                    </div>
                </div>

                {{-- Rekomendasi Sections --}}
                <div class="bg-blue-50 rounded-xl p-6 border-l-4 border-blue-500">
                    <h4 class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-info-circle text-blue-600"></i>
                        Penjelasan Kondisi
                    </h4>
                    <p class="text-gray-700 leading-relaxed" id="modalPenjelasanResiko">-</p>
                </div>

                <div class="bg-green-50 rounded-xl p-6 border-l-4 border-green-500">
                    <h4 class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-apple-alt text-green-600"></i>
                        Rekomendasi Diet
                    </h4>
                    <p class="text-gray-700 leading-relaxed" id="modalRekomendasiDiet">-</p>
                </div>

                <div class="bg-orange-50 rounded-xl p-6 border-l-4 border-orange-500">
                    <h4 class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-dumbbell text-orange-600"></i>
                        Rekomendasi Olahraga
                    </h4>
                    <p class="text-gray-700 leading-relaxed" id="modalRekomendasiOlahraga">-</p>
                </div>

                <div class="bg-purple-50 rounded-xl p-6 border-l-4 border-purple-500">
                    <h4 class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-heart text-purple-600"></i>
                        Perubahan Gaya Hidup
                    </h4>
                    <p class="text-gray-700 leading-relaxed" id="modalPerubahanGayaHidup">-</p>
                </div>

                <div class="bg-yellow-50 rounded-xl p-6 border-l-4 border-yellow-500">
                    <h4 class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-lightbulb text-yellow-600"></i>
                        Tips Pencegahan
                    </h4>
                    <p class="text-gray-700 leading-relaxed" id="modalTipsPencegahan">-</p>
                </div>

                <div id="modalKonsultasiSection" class="bg-red-50 rounded-xl p-6 border-l-4 border-red-500 hidden">
                    <h4 class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-user-md text-red-600"></i>
                        Rekomendasi Konsultasi
                    </h4>
                    <div class="flex items-start gap-3">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-exclamation text-red-600 text-xl"></i>
                        </div>
                        <p class="text-gray-700 leading-relaxed" id="modalPesanKonsultasi">-</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Actions --}}
        <div class="bg-gray-50 p-6 border-t border-gray-200 flex gap-3">
            <button onclick="closeDetailModal()" 
                class="flex-1 px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-semibold transition-all">
                <i class="fas fa-times mr-2"></i>Tutup
            </button>
            <button onclick="printReport()" 
                class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-all shadow-md">
                <i class="fas fa-print mr-2"></i>Cetak
            </button>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    .animate-slideIn {
        animation: slideIn 0.3s ease-out;
    }

    .animate-spin {
        animation: spin 1s linear infinite;
    }

    .overflow-y-auto::-webkit-scrollbar {
        width: 8px;
    }

    .overflow-y-auto::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #16a34a;
        border-radius: 10px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #15803d;
    }

    #tabDataInput.active,
    #tabHasilResiko.active {
        background-color: white;
        border-bottom-color: #16a34a;
        color: #16a34a;
    }
</style>
@endpush

@push('scripts')
<script>
    let riwayatData = {};
    
    document.addEventListener('DOMContentLoaded', function() {
        const scriptTag = document.getElementById('riwayat-data');
        if (scriptTag) {
            try {
                riwayatData = JSON.parse(scriptTag.textContent);
            } catch (e) {
                console.error('Error parsing JSON:', e);
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDetailModal();
            }
        });
    });

    function switchTab(tabName) {
        document.getElementById('contentDataInput').classList.add('hidden');
        document.getElementById('contentHasilResiko').classList.add('hidden');
        
        document.getElementById('tabDataInput').classList.remove('active');
        document.getElementById('tabHasilResiko').classList.remove('active');
        
        if (tabName === 'dataInput') {
            document.getElementById('contentDataInput').classList.remove('hidden');
            document.getElementById('tabDataInput').classList.add('active');
        } else {
            document.getElementById('contentHasilResiko').classList.remove('hidden');
            document.getElementById('tabHasilResiko').classList.add('active');
        }
    }

    function openDetailModal(id) {
        const data = riwayatData[id];
        if (!data) {
            alert('Data tidak ditemukan!');
            return;
        }

        console.log('Data riwayat:', data); // Debug: lihat data yang dimuat

        document.getElementById('modalDate').textContent = formatDate(data.created_at);

        // TAB 1: DATA INPUT
        document.getElementById('modalNama').textContent = data.nama || 'Tidak Diisi';
        document.getElementById('modalUsia').textContent = (data.usia || 'Tidak Diisi') + (data.usia ? ' tahun' : '');
        document.getElementById('modalJenisKelamin').textContent = data.jenis_kelamin || 'Tidak Diisi';
        document.getElementById('modalBeratBadan').textContent = data.berat_badan || 'Tidak Diisi';
        document.getElementById('modalTinggiBadan').textContent = data.tinggi_badan || 'Tidak Diisi';
        document.getElementById('modalIMT').textContent = data.imt || 'Tidak Diisi';

        document.getElementById('modalKeluargaDiabetes').textContent = data.keluarga_diabetes || 'Tidak Diisi';
        document.getElementById('modalHipertensi').textContent = data.riwayat_hipertensi || 'Tidak Diisi';
        document.getElementById('modalObesitas').textContent = data.riwayat_obesitas || 'Tidak Diisi';

        document.getElementById('modalOlahraga').textContent = data.olahraga || 'Tidak Diisi';
        document.getElementById('modalPolaMakan').textContent = data.pola_makan || 'Tidak Diisi';
        document.getElementById('modalMerokok').textContent = data.merokok || 'Tidak Diisi';
        document.getElementById('modalAlkohol').textContent = data.minum_alkohol || 'Tidak Diisi';

        // Gejala - dengan pengecekan
        console.log('Gejala data:', {
            bak: data.sering_buang_air_kecil_malam,
            lapar: data.sering_lapar,
            kabur: data.pandangan_kabur
        });
        
        document.getElementById('modalSeringBAK').textContent = data.sering_buang_air_kecil_malam || 'Tidak Diisi';
        document.getElementById('modalSeringLapar').textContent = data.sering_lapar || 'Tidak Diisi';
        document.getElementById('modalPandanganKabur').textContent = data.pandangan_kabur || 'Tidak Diisi';

        // TAB 2: HASIL & REKOMENDASI
        const statusEl = document.getElementById('modalStatusDiabetes');
        statusEl.textContent = data.status_diabetes || '-';
        
        if (data.status_diabetes === 'Normal') {
            statusEl.className = 'text-2xl font-bold text-green-700';
        } else if (data.status_diabetes === 'Prediabetes') {
            statusEl.className = 'text-2xl font-bold text-yellow-700';
        } else {
            statusEl.className = 'text-2xl font-bold text-red-700';
        }

        let resikoBadgeHtml = '';
        if (data.tingkat_resiko === 'Rendah') {
            resikoBadgeHtml = '<span class="inline-flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-green-100 to-green-200 text-green-800 rounded-full text-lg font-bold"><i class="fas fa-check-circle"></i>Rendah</span>';
        } else if (data.tingkat_resiko === 'Sedang') {
            resikoBadgeHtml = '<span class="inline-flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 rounded-full text-lg font-bold"><i class="fas fa-exclamation-circle"></i>Sedang</span>';
        } else {
            resikoBadgeHtml = '<span class="inline-flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-red-100 to-red-200 text-red-800 rounded-full text-lg font-bold"><i class="fas fa-exclamation-triangle"></i>Tinggi</span>';
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
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeDetailModal() {
        const modal = document.getElementById('detailModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
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

    function previewReport() {
        const allData = Object.values(riwayatData);
        
        if (allData.length === 0) {
            alert('Tidak ada data untuk diunduh!');
            return;
        }

        downloadReport(); // Call existing HTML preview function
    }

    function formatDateSimple(dateStr) {
        const date = new Date(dateStr);
        return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
    }

    function downloadReport() {
        const allData = Object.values(riwayatData);
        
        if (allData.length === 0) {
            alert('Tidak ada data untuk diunduh!');
            return;
        }

        let html = `
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Riwayat Kesehatan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; padding: 30px; color: #333; background: #f9fafb; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 40px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 40px; padding-bottom: 20px; border-bottom: 3px solid #16a34a; }
        .header h1 { color: #16a34a; font-size: 32px; margin-bottom: 10px; }
        .header p { color: #666; font-size: 14px; }
        .summary { background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); padding: 25px; border-radius: 12px; margin-bottom: 30px; }
        .summary h2 { color: #15803d; margin-bottom: 20px; font-size: 22px; }
        .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .stat-card { background: white; padding: 20px; border-radius: 10px; text-align: center; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .stat-label { font-size: 12px; color: #666; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
        .stat-value { font-size: 28px; font-weight: bold; color: #16a34a; }
        .history-item { background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 12px; padding: 25px; margin-bottom: 25px; page-break-inside: avoid; }
        .history-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #e5e7eb; }
        .history-date { font-size: 16px; font-weight: bold; color: #16a34a; }
        .badge { padding: 8px 16px; border-radius: 25px; font-size: 13px; font-weight: bold; }
        .badge-rendah { background: #dcfce7; color: #166534; }
        .badge-sedang { background: #fef3c7; color: #92400e; }
        .badge-tinggi { background: #fee2e2; color: #991b1b; }
        .data-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin: 20px 0; }
        .data-item { background: white; padding: 15px; border-radius: 8px; border-left: 3px solid #16a34a; }
        .data-label { font-size: 11px; color: #666; margin-bottom: 5px; font-weight: 600; }
        .data-value { font-weight: bold; color: #333; font-size: 15px; }
        .recommendations { background: #fffbeb; padding: 20px; border-radius: 10px; margin-top: 20px; border-left: 4px solid #f59e0b; }
        .recommendations h4 { color: #92400e; margin-bottom: 12px; font-size: 15px; }
        .recommendations p { margin: 8px 0; font-size: 13px; line-height: 1.8; color: #666; }
        .footer { margin-top: 50px; padding-top: 25px; border-top: 2px solid #e5e7eb; text-align: center; color: #666; font-size: 12px; }
        @media print { body { padding: 0; background: white; } .container { box-shadow: none; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Laporan Riwayat Kesehatan</h1>
            <p>Sistem Deteksi Dini Diabetes</p>
            <p style="margin-top: 10px; font-weight: bold;">Tanggal Cetak: ${new Date().toLocaleDateString('id-ID', { 
                day: '2-digit', 
                month: 'long', 
                year: 'numeric' 
            })}</p>
        </div>

        <div class="summary">
            <h2>📈 Ringkasan Pemeriksaan</h2>
            <div class="stats">
                <div class="stat-card">
                    <div class="stat-label">Total Pemeriksaan</div>
                    <div class="stat-value">${allData.length}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Rata-rata IMT</div>
                    <div class="stat-value">${(allData.reduce((sum, d) => sum + parseFloat(d.imt), 0) / allData.length).toFixed(1)}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Rata-rata Skor Risiko</div>
                    <div class="stat-value">${Math.round(allData.reduce((sum, d) => sum + parseFloat(d.skor_resiko), 0) / allData.length)}<span style="font-size: 14px; color: #666;">%</span></div>
                </div>
            </div>
        </div>

        <h2 style="color: #16a34a; margin-bottom: 25px; font-size: 24px;">📋 Detail Riwayat Pemeriksaan</h2>
        
        ${allData.map(data => `
            <div class="history-item">
                <div class="history-header">
                    <div class="history-date">📅 ${formatDate(data.created_at)}</div>
                    <span class="badge badge-${data.tingkat_resiko.toLowerCase()}">Risiko ${data.tingkat_resiko}</span>
                </div>

                <div class="data-grid">
                    <div class="data-item">
                        <div class="data-label">Status</div>
                        <div class="data-value">${data.status_diabetes}</div>
                    </div>
                    <div class="data-item">
                        <div class="data-label">IMT</div>
                        <div class="data-value">${data.imt}</div>
                    </div>
                    <div class="data-item">
                        <div class="data-label">Skor Risiko</div>
                        <div class="data-value">${data.skor_resiko}%</div>
                    </div>
                    <div class="data-item">
                        <div class="data-label">Tingkat Risiko</div>
                        <div class="data-value">${data.tingkat_resiko}</div>
                    </div>
                </div>

                <div class="recommendations">
                    <h4>💡 Rekomendasi Kesehatan</h4>
                    <p><strong>Diet:</strong> ${data.rekomendasi_diet}</p>
                    <p><strong>Olahraga:</strong> ${data.rekomendasi_olahraga}</p>
                    ${data.perlu_konsul === 'Ya' ? '<p style="color: #991b1b; font-weight: bold; margin-top: 10px;">⚠️ Disarankan untuk berkonsultasi dengan dokter</p>' : ''}
                </div>
            </div>
        `).join('')}

        <div class="footer">
            <p><strong>⚠️ Penting:</strong> Laporan ini bersifat informatif dan tidak menggantikan diagnosis medis profesional.</p>
            <p style="margin-top: 8px;">Untuk informasi lebih lanjut, silakan berkonsultasi dengan tenaga kesehatan.</p>
        </div>
    </div>
</body>
</html>
        `;

        const printWindow = window.open('', '_blank');
        printWindow.document.write(html);
        printWindow.document.close();
        
        setTimeout(() => {
            printWindow.print();
        }, 500);
    }

    function printReport() {
        window.print();
    }
</script>
@endpush