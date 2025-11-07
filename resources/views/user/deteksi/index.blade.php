@extends('layouts.navbar')

@section('title', 'Dashboard - Deteksi Diabetes')
@section('page_title', 'Deteksi Diabetes')


@section('content')
<div class="p-8">
    <div class="max-w-4xl mx-auto">
        <!-- Card Deteksi Diabetes -->
        <div class="bg-linear-to-br from-green-100 to-green-200 rounded-2xl p-8 shadow-lg">
            <div class="flex items-start gap-6">
                <!-- Brain Icon -->
                <div class="bg-green-600 p-4 rounded-2xl">
                    <i class="fas fa-brain text-5xl text-white"></i>
                </div>

                <!-- Content -->
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">
                        Deteksi diabetes
                    </h2>
                    <p class="text-gray-700 text-lg mb-6">
                        Deteksi dini Diabetes militus
                    </p>

                    <a href="{{ route('deteksi.create') }}" 
                       class="inline-block bg-[#146135] text-white px-8 py-3 rounded-lg font-semibold hover:bg-[#0f4a27] transition-colors shadow-md">
                        Lakukan Pemeriksaan
                    </a>
                </div>
            </div>
        </div>

        <!-- Additional Content Area -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Riwayat Pemeriksaan -->
            <div class="bg-white rounded-xl p-6 shadow-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">
                    <i class="fas fa-history text-[#146135] mr-2"></i>
                    Riwayat Pemeriksaan Terakhir
                </h3>
                @if(isset($lastCheckup))
                    <div class="space-y-2">
                        <p class="text-sm text-gray-600">
                            Tanggal: {{ $lastCheckup->created_at->format('d M Y') }}
                        </p>
                        <p class="text-sm text-gray-600">
                            Hasil: <span class="font-semibold">{{ $lastCheckup->result }}</span>
                        </p>
                    </div>
                @else
                    <p class="text-gray-600">
                        Belum ada riwayat pemeriksaan
                    </p>
                @endif
            </div>

            <!-- Tips Kesehatan -->
            <div class="bg-white rounded-xl p-6 shadow-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">
                    <i class="fas fa-lightbulb text-[#146135] mr-2"></i>
                    Tips Kesehatan
                </h3>
                <ul class="text-gray-600 space-y-2">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1"></i>
                        <span>Jaga pola makan sehat dan seimbang</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1"></i>
                        <span>Olahraga teratur minimal 30 menit/hari</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1"></i>
                        <span>Cek gula darah secara berkala</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Statistik Section -->
        <div class="mt-8 bg-white rounded-xl p-6 shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-chart-bar text-[#146135] mr-2"></i>
                Statistik Kesehatan
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <div class="text-3xl font-bold text-blue-600">{{ $totalCheckups ?? 0 }}</div>
                    <div class="text-sm text-gray-600 mt-1">Total Pemeriksaan</div>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <div class="text-3xl font-bold text-green-600">{{ $normalCount ?? 0 }}</div>
                    <div class="text-sm text-gray-600 mt-1">Hasil Normal</div>
                </div>
                <div class="text-center p-4 bg-red-50 rounded-lg">
                    <div class="text-3xl font-bold text-red-600">{{ $abnormalCount ?? 0 }}</div>
                    <div class="text-sm text-gray-600 mt-1">Perlu Perhatian</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
