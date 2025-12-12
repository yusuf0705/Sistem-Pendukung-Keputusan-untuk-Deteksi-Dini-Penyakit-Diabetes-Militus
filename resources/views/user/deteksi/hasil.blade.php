@extends('layouts.navbar')

@section('title', 'Hasil Deteksi Diabetes')
@section('page_title', 'Hasil Deteksi Diabetes')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-blue-50 py-10 px-4 font-inter">
    <div class="max-w-3xl mx-auto space-y-6">

        {{-- Card Hasil --}}
        <div class="bg-white rounded-2xl shadow-xl p-8 border-l-4 
            {{ (isset($hasil['diabetes']) && $hasil['diabetes'] == 1) ? 'border-red-600' : 'border-green-600' }}">

            <h1 class="text-3xl font-bold text-gray-900 mb-4 font-poppins">
                Hasil Analisis Diabetes
            </h1>

            {{-- Status --}}
            <div class="flex items-center gap-3 mb-6">
                @if(isset($hasil['diabetes']) && $hasil['diabetes'] == 1)
                    <div class="bg-red-100 text-red-700 px-4 py-2 rounded-full font-semibold">
                        Risiko Tinggi Diabetes
                    </div>
                @else
                    <div class="bg-green-100 text-green-700 px-4 py-2 rounded-full font-semibold">
                        Risiko Rendah / Normal
                    </div>
                @endif
            </div>

            {{-- Nilai Prediksi --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">

                <div class="bg-gray-50 p-4 rounded-xl shadow-sm">
                    <div class="text-sm text-gray-700 mb-1">Skor Risiko (%)</div>
                    <div class="text-3xl font-bold text-gray-900">
                        {{ $hasil['score'] ?? '-' }}%
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-xl shadow-sm">
                    <div class="text-sm text-gray-700 mb-1">Kategori</div>
                    <div class="text-xl font-semibold text-gray-900">
                        {{ $hasil['kategori'] ?? ((isset($hasil['diabetes']) && $hasil['diabetes'] == 1) ? 'Tinggi' : 'Rendah') }}
                    </div>
                </div>

            </div>

            {{-- Rekomendasi --}}
            <div class="space-y-4">
                <h2 class="text-xl font-bold text-gray-900 font-poppins">Rekomendasi</h2>

                <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-5 rounded-xl border-l-4 border-green-600">
                    <h3 class="font-bold text-gray-900 mb-2">Gaya Hidup</h3>
                    <p class="text-gray-700">
                        {{ $hasil['rekomendasi_gaya_hidup'] ?? 'Pertahankan gaya hidup sehat, rutin olahraga, dan jaga berat badan ideal.' }}
                    </p>
                </div>

                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 p-5 rounded-xl border-l-4 border-blue-600">
                    <h3 class="font-bold text-gray-900 mb-2">Pola Makan</h3>
                    <p class="text-gray-700">
                        {{ $hasil['rekomendasi_pola_makan'] ?? 'Kurangi gula, makanan olahan, dan perbanyak sayur serta buah.' }}
                    </p>
                </div>

                <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-5 rounded-xl border-l-4 border-purple-600">
                    <h3 class="font-bold text-gray-900 mb-2">Konsultasi</h3>
                    <p class="text-gray-700">
                        {{ $hasil['pesan_konsultasi'] ?? 'Jika Anda memiliki gejala, segera lakukan pemeriksaan ke dokter.' }}
                    </p>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="mt-8 flex gap-3">
                <a href="{{ route('deteksi.create') }}" 
                   class="px-5 py-3 bg-green-700 text-white rounded-lg font-semibold hover:bg-green-800 transition-all">
                    Deteksi Lagi
                </a>

                <a href="{{ route('dashboard') }}"
                   class="px-5 py-3 bg-gray-300 text-gray-900 rounded-lg font-semibold hover:bg-gray-400 transition-all">
                    Kembali ke Dashboard
                </a>
            </div>

        </div>

    </div>
</div>
@endsection
