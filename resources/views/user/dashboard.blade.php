@extends('layouts.navbar')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-blue-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="bg-white rounded-2xl shadow-xl p-8 border-l-4 border-green-600">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">👋 Halo, {{ $user->name }}</h1>
                    <p class="text-gray-600">Pantau risiko diabetes Anda secara real-time</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg font-semibold">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Aktif
                    </div>
                </div>
            </div>
        </div>

        {{-- Analisis AI Card --}}
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl shadow-xl p-6 text-white">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h2 class="text-2xl font-bold mb-2">🤖 Analisis AI Terkini</h2>
                    <p class="text-blue-100">Terakhir diperbarui: {{ now()->format('d F Y') }}</p>
                </div>
                <button onclick="downloadReport()" class="bg-white text-blue-700 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-all shadow-md flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Unduh Laporan Lengkap
                </button>
            </div>
        </div>

        {{-- Grid Dashboard Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Status Diabetes --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-{{ $tingkatResiko == 'Rendah' ? 'green' : ($tingkatResiko == 'Sedang' ? 'yellow' : 'red') }}-500">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Status Diabetes</h3>
                    <div class="bg-{{ $tingkatResiko == 'Rendah' ? 'green' : ($tingkatResiko == 'Sedang' ? 'yellow' : 'red') }}-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-{{ $tingkatResiko == 'Rendah' ? 'green' : ($tingkatResiko == 'Sedang' ? 'yellow' : 'red') }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-{{ $tingkatResiko == 'Rendah' ? 'green' : ($tingkatResiko == 'Sedang' ? 'yellow' : 'red') }}-600 mb-2">{{ $statusDiabetes }}</div>
                    <div class="inline-flex items-center px-3 py-1 bg-{{ $tingkatResiko == 'Rendah' ? 'green' : ($tingkatResiko == 'Sedang' ? 'yellow' : 'red') }}-100 text-{{ $tingkatResiko == 'Rendah' ? 'green' : ($tingkatResiko == 'Sedang' ? 'yellow' : 'red') }}-800 rounded-full text-sm font-semibold">
                        Risiko {{ $tingkatResiko }}
                    </div>
                </div>
            </div>

            {{-- Berat Badan --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Berat Badan</h3>
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">{{ $beratBadan }} kg</div>
                    <div class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                        @if($imt < 18.5)
                            Kurus
                        @elseif($imt < 25)
                            Ideal
                        @elseif($imt < 30)
                            Kelebihan
                        @else
                            Obesitas
                        @endif
                    </div>
                </div>
            </div>

            {{-- BMI --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">BMI (IMT)</h3>
                    <div class="bg-purple-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-purple-600 mb-2">{{ number_format($imt, 1) }}</div>
                    <div class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold">
                        @if($imt < 18.5)
                            Kurus
                        @elseif($imt < 25)
                            Ideal
                        @elseif($imt < 30)
                            Kelebihan
                        @else
                            Obesitas
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafik Risiko Diabetes --}}
        <div class="bg-white rounded-2xl shadow-xl p-5 max-w-md mx-auto">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                </svg>
                Distribusi Tingkat Risiko Diabetes
            </h3>
            @if($totalRiwayat > 0)
            <div id="chartContainer"
                 data-total="{{ $totalRiwayat }}"
                 data-rendah="{{ $persenRendah }}"
                 data-sedang="{{ $persenSedang }}"
                 data-tinggi="{{ $persenTinggi }}"
                 style="height: 180px;">
                <canvas id="risikoChart"></canvas>
            </div>
            <div class="mt-3 grid grid-cols-3 gap-2 text-center text-xs">
                <div>
                    <div class="w-3 h-3 bg-green-500 rounded-full mx-auto mb-1"></div>
                    <div class="font-semibold">Rendah</div>
                    <div class="text-gray-600">{{ $persenRendah }}%</div>
                </div>
                <div>
                    <div class="w-3 h-3 bg-yellow-500 rounded-full mx-auto mb-1"></div>
                    <div class="font-semibold">Sedang</div>
                    <div class="text-gray-600">{{ $persenSedang }}%</div>
                </div>
                <div>
                    <div class="w-3 h-3 bg-red-500 rounded-full mx-auto mb-1"></div>
                    <div class="font-semibold">Tinggi</div>
                    <div class="text-gray-600">{{ $persenTinggi }}%</div>
                </div>
            </div>
            @else
            <div class="text-center py-8" id="emptyState">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <p class="text-gray-500 font-semibold mb-2">Belum Ada Data</p>
                <p class="text-gray-400 text-sm mb-4">Lakukan pemeriksaan untuk melihat grafik</p>
                <a href="{{ route('deteksi.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-semibold hover:bg-green-700 transition-all">
                    Mulai Pemeriksaan
                </a>
            </div>
            @endif
        </div>

        {{-- Rekomendasi --}}
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Rekomendasi Tindakan
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                    <div class="flex items-start gap-3">
                        <div class="bg-green-100 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">Pola Makan Sehat</h4>
                            <p class="text-sm text-gray-700">Perbanyak konsumsi sayur dan buah, kurangi makanan manis dan berlemak</p>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                    <div class="flex items-start gap-3">
                        <div class="bg-blue-100 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">Rutin Olahraga</h4>
                            <p class="text-sm text-gray-700">Lakukan olahraga minimal 30 menit setiap hari untuk menjaga kesehatan</p>
                        </div>
                    </div>
                </div>

                <div class="bg-purple-50 border-l-4 border-purple-500 p-4 rounded-lg">
                    <div class="flex items-start gap-3">
                        <div class="bg-purple-100 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">Pemeriksaan Rutin</h4>
                            <p class="text-sm text-gray-700">Periksa kesehatan secara rutin setiap 3-6 bulan untuk monitoring</p>
                        </div>
                    </div>
                </div>

                <div class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded-lg">
                    <div class="flex items-start gap-3">
                        <div class="bg-orange-100 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">Kelola Stres</h4>
                            <p class="text-sm text-gray-700">Istirahat cukup dan kelola stres dengan baik untuk kesehatan optimal</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- SweetAlert --}}
@if (session('login'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Login Berhasil!',
            text: 'Selamat datang kembali, {{ $user->name }}',
            showConfirmButton: false,
            timer: 2000
        });
    });
</script>
@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Ambil data dari data-attribute (TIDAK ADA WARNING!)
const chartContainer = document.getElementById('chartContainer');

if (chartContainer) {
    // Parse data dari HTML data attributes
    const totalRiwayat = parseInt(chartContainer.dataset.total) || 0;
    const persenRendah = parseInt(chartContainer.dataset.rendah) || 0;
    const persenSedang = parseInt(chartContainer.dataset.sedang) || 0;
    const persenTinggi = parseInt(chartContainer.dataset.tinggi) || 0;

    console.log('Dashboard Data:', {
        total: totalRiwayat,
        rendah: persenRendah,
        sedang: persenSedang,
        tinggi: persenTinggi
    });

    // Grafik Risiko jika ada data
    if (totalRiwayat > 0) {
        const risikoData = {
            labels: ['Rendah', 'Sedang', 'Tinggi'],
            datasets: [{
                data: [persenRendah, persenSedang, persenTinggi],
                backgroundColor: [
                    'rgb(34, 197, 94)',
                    'rgb(234, 179, 8)',
                    'rgb(239, 68, 68)'
                ],
                borderWidth: 0
            }]
        };

        const risikoConfig = {
            type: 'doughnut',
            data: risikoData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed + '%';
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        };

        const risikoCtx = document.getElementById('risikoChart');
        if (risikoCtx) {
            new Chart(risikoCtx, risikoConfig);
        }
    }
}

// Function Download Report
function downloadReport() {
    const chartContainer = document.getElementById('chartContainer');
    const emptyState = document.getElementById('emptyState');
    
    // Cek apakah ada data
    const hasData = chartContainer && chartContainer.dataset.total && parseInt(chartContainer.dataset.total) > 0;
    
    if (hasData) {
        Swal.fire({
            icon: 'info',
            title: 'Mengunduh Laporan',
            text: 'Laporan kesehatan Anda sedang disiapkan...',
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            window.location.href = '{{ route("riwayat_kesehatan.index") }}';
        });
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'Belum Ada Data',
            text: 'Anda belum memiliki riwayat pemeriksaan. Silakan lakukan pemeriksaan terlebih dahulu.',
            confirmButtonText: 'Mulai Pemeriksaan',
            confirmButtonColor: '#16a34a'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route("deteksi.create") }}';
            }
        });
    }
}
</script>
@endpush