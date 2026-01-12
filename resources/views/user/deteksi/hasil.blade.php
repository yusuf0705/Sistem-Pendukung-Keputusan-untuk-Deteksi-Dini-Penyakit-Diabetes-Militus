@extends('layouts.navbar')

@section('title', 'Hasil Deteksi Diabetes')
@section('page_title', 'Hasil Deteksi Diabetes')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-blue-50 py-10 px-4">
    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Header Card dengan Status Utama --}}
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            
            {{-- Banner Status --}}
            <div class="
                {{ $hasil['kategori'] == 'Tinggi' ? 'bg-gradient-to-r from-red-500 to-red-600' : 
                   ($hasil['kategori'] == 'Sedang' ? 'bg-gradient-to-r from-yellow-500 to-orange-500' : 
                   'bg-gradient-to-r from-green-500 to-emerald-600') }} 
                px-8 py-6 text-white">
                
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium opacity-90 mb-1">Status Kesehatan Anda</p>
                        <h1 class="text-4xl font-bold">
                            {{ $hasil['analisis']['status_diabetes'] ?? 'Normal' }}
                        </h1>
                        <p class="text-base opacity-90 mt-2">
                            Tingkat Risiko: <span class="font-semibold text-lg">{{ $hasil['kategori'] }}</span>
                        </p>
                    </div>
                    <div class="text-right">
                        <div class="text-6xl font-bold">
                            {{ number_format($hasil['score'], 1) }}%
                        </div>
                        <p class="text-base opacity-90 mt-1">Skor Risiko</p>
                    </div>
                </div>
            </div>

            {{-- Konten Utama --}}
            <div class="p-8">
                
                {{-- Ringkasan Analisis AI --}}
                <div class="mb-8">
                    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-6 border-l-4 border-indigo-500 shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="bg-indigo-500 text-white p-3 rounded-full">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center gap-2">
                                    🤖 Hasil Analisis AI
                                </h2>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div class="bg-white rounded-lg p-4 shadow-sm">
                                        <p class="text-xs text-gray-600 mb-1">Probabilitas Diabetes</p>
                                        <p class="text-2xl font-bold text-indigo-600">{{ number_format($hasil['score'], 1) }}%</p>
                                    </div>
                                    <div class="bg-white rounded-lg p-4 shadow-sm">
                                        <p class="text-xs text-gray-600 mb-1">Tingkat Kepercayaan</p>
                                        <p class="text-2xl font-bold text-purple-600">{{ $hasil['confidence'] ?? 0 }}%</p>
                                    </div>
                                    <div class="bg-white rounded-lg p-4 shadow-sm">
                                        <p class="text-xs text-gray-600 mb-1">Skor Manual</p>
                                        <p class="text-2xl font-bold text-gray-700">{{ $hasil['skor'] ?? 0 }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Penjelasan Risiko --}}
                @if(isset($hasil['analisis']['penjelasan_resiko']))
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Penjelasan Hasil Analisis
                    </h2>
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg shadow-sm">
                        <p class="text-gray-800 leading-relaxed text-base">
                            {{ $hasil['analisis']['penjelasan_resiko'] }}
                        </p>
                    </div>
                </div>
                @endif

                {{-- Faktor Risiko yang Teridentifikasi --}}
                @if(isset($hasil['risk_factors']) && count($hasil['risk_factors']) > 0)
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Faktor Risiko yang Teridentifikasi
                    </h2>
                    <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-6 shadow-sm">
                        <ul class="space-y-3">
                            @foreach($hasil['risk_factors'] as $risk)
                                <li class="flex items-start gap-3">
                                    <span class="text-red-500 font-bold text-xl mt-0.5">⚠</span>
                                    <span class="text-gray-800 text-base">{{ $risk }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                {{-- Rekomendasi --}}
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Rekomendasi untuk Anda
                    </h2>

                    <div class="space-y-4">
                        {{-- Diet --}}
                        @if(isset($hasil['analisis']['rekomendasi_diet']))
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 rounded-xl border-l-4 border-green-600 shadow-sm hover:shadow-md transition-shadow">
                            <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2 text-lg">
                                <span class="text-2xl">🥗</span>
                                Rekomendasi Diet
                            </h3>
                            <p class="text-gray-700 leading-relaxed text-base">
                                {{ $hasil['analisis']['rekomendasi_diet'] }}
                            </p>
                        </div>
                        @endif

                        {{-- Olahraga --}}
                        @if(isset($hasil['analisis']['rekomendasi_olahraga']))
                        <div class="bg-gradient-to-r from-blue-50 to-cyan-50 p-6 rounded-xl border-l-4 border-blue-600 shadow-sm hover:shadow-md transition-shadow">
                            <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2 text-lg">
                                <span class="text-2xl">🏃</span>
                                Rekomendasi Olahraga
                            </h3>
                            <p class="text-gray-700 leading-relaxed text-base">
                                {{ $hasil['analisis']['rekomendasi_olahraga'] }}
                            </p>
                        </div>
                        @endif

                        {{-- Perubahan Gaya Hidup --}}
                        @if(isset($hasil['analisis']['perubahan_gaya_hidup']))
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-6 rounded-xl border-l-4 border-purple-600 shadow-sm hover:shadow-md transition-shadow">
                            <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2 text-lg">
                                <span class="text-2xl">🔄</span>
                                Perubahan Gaya Hidup
                            </h3>
                            <p class="text-gray-700 leading-relaxed text-base">
                                {{ $hasil['analisis']['perubahan_gaya_hidup'] }}
                            </p>
                        </div>
                        @endif

                        {{-- Tips Pencegahan --}}
                        @if(isset($hasil['analisis']['tips_pencegahan']))
                        <div class="bg-gradient-to-r from-yellow-50 to-amber-50 p-6 rounded-xl border-l-4 border-yellow-600 shadow-sm hover:shadow-md transition-shadow">
                            <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2 text-lg">
                                <span class="text-2xl">💡</span>
                                Tips Pencegahan
                            </h3>
                            <p class="text-gray-700 leading-relaxed text-base">
                                {{ $hasil['analisis']['tips_pencegahan'] }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Pesan Konsultasi --}}
                @if(isset($hasil['analisis']['perlu_konsul']) && $hasil['analisis']['perlu_konsul'] == 'Ya')
                <div class="bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-600 p-6 rounded-xl shadow-lg">
                    <div class="flex items-start gap-4">
                        <div class="bg-red-600 text-white p-3 rounded-full flex-shrink-0">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 mb-2 text-xl flex items-center gap-2">
                                <span class="text-2xl">⚠️</span>
                                Perlu Konsultasi Medis
                            </h3>
                            <p class="text-gray-800 leading-relaxed text-base">
                                {{ $hasil['analisis']['pesan_konsultasi'] ?? 'Sangat disarankan untuk segera berkonsultasi dengan dokter untuk pemeriksaan lebih lanjut.' }}
                            </p>
                        </div>
                    </div>
                </div>
                @else
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-600 p-6 rounded-xl shadow-lg">
                    <div class="flex items-start gap-4">
                        <div class="bg-green-600 text-white p-3 rounded-full flex-shrink-0">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 mb-2 text-xl flex items-center gap-2">
                                <span class="text-2xl">✓</span>
                                Kondisi Baik
                            </h3>
                            <p class="text-gray-800 leading-relaxed text-base">
                                {{ $hasil['analisis']['pesan_konsultasi'] ?? 'Kondisi Anda baik. Tetap lanjutkan gaya hidup sehat dan lakukan pemeriksaan rutin.' }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Tombol Aksi --}}
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('deteksi.create') }}" 
                           class="px-6 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-bold hover:from-green-700 hover:to-green-800 transition-all shadow-lg hover:shadow-xl text-center transform hover:-translate-y-0.5 duration-200">
                            🔄 Deteksi Ulang
                        </a>

                        <a href="{{ route('riwayat_kesehatan.index') }}"
                           class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl text-center transform hover:-translate-y-0.5 duration-200">
                            📋 Lihat Riwayat
                        </a>

                        <a href="{{ route('dashboard') }}"
                           class="px-6 py-4 bg-gradient-to-r from-gray-500 to-gray-600 text-white rounded-xl font-bold hover:from-gray-600 hover:to-gray-700 transition-all shadow-lg hover:shadow-xl text-center transform hover:-translate-y-0.5 duration-200">
                            🏠 Dashboard
                        </a>
                    </div>
                </div>

                {{-- Info Disclaimer --}}
                <div class="mt-6 bg-gray-50 border-2 border-gray-200 p-5 rounded-xl">
                    <div class="flex items-start gap-3">
                        <span class="text-2xl flex-shrink-0">⚠️</span>
                        <p class="text-sm text-gray-700 leading-relaxed">
                            <span class="font-bold">Disclaimer:</span> Hasil analisis ini menggunakan model AI dan bersifat prediktif untuk membantu deteksi dini risiko diabetes. 
                            Hasil ini <span class="font-semibold">TIDAK menggantikan</span> diagnosis medis profesional. 
                            Untuk pemeriksaan yang lebih akurat dan penanganan yang tepat, sangat disarankan untuk berkonsultasi dengan dokter atau tenaga medis profesional.
                        </p>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection