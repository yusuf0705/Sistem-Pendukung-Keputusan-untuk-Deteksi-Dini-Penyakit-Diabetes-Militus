@extends('layouts.navbar')

@section('title', 'Dashboard')

@section('content')

<style>
    :root {
        --green-main: #146135;
        --green-light: #e6f3ec;
    }
</style>

<div class="flex min-h-screen bg-gray-100">
    <main class="flex-1 p-8 max-w-7xl mx-auto">

        {{-- Header --}}
        <h2 class="text-2xl font-semibold text-gray-700 mb-1">
           Halo, {{ $user->name }}
        </h2>
        <p class="text-gray-500 mb-8">
            Pantau risiko diabetes Anda secara real-time
        </p>

        {{-- Card Analisis --}}
        <div
            class="bg-[color:var(--green-light)]
                   border border-[color:var(--green-main)]/40
                   rounded-2xl p-6
                   flex flex-col md:flex-row
                   md:items-center md:justify-between
                   mb-8">

            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">
                    Analisis AI Terkini
                </h3>
                <p class="text-sm text-gray-600">
                    Terakhir diperbarui:
                    <span class="font-medium">
                        {{ now()->format('d F Y') }}
                    </span>
                </p>
            </div>

            <button
                onclick="showInfo()"
                class="mt-4 md:mt-0
                       bg-[color:var(--green-main)]
                       text-white px-6 py-2 rounded-lg
                       hover:bg-[color:var(--green-main)]/90 transition">
                Unduh Laporan Lengkap
            </button>
        </div>

        {{-- Grid Dashboard --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            {{-- Status Diabetes --}}
            <div class="bg-white shadow rounded-2xl p-5 text-center">
                <p class="text-gray-500 text-sm">Status Diabetes</p>
                <h3 class="text-xl font-semibold mt-1">Normal</h3>
                <p class="text-green-600 font-medium mt-2">
                    Risiko Rendah
                </p>
            </div>

            {{-- Berat Badan --}}
            <div class="bg-white shadow rounded-2xl p-5 text-center">
                <p class="text-gray-500 text-sm">Berat Badan</p>
                <h3 class="text-xl font-semibold mt-1">65 kg</h3>
                <p class="text-green-600 font-medium mt-2">
                    Ideal
                </p>
            </div>

            {{-- BMI --}}
            <div class="bg-white shadow rounded-2xl p-5 text-center">
                <p class="text-gray-500 text-sm">BMI</p>
                <h3 class="text-xl font-semibold mt-1">23.5</h3>
                <p class="text-green-600 font-medium mt-2">
                    Ideal
                </p>
            </div>

            {{-- Rekomendasi --}}
            <div class="bg-white shadow rounded-2xl p-5">
                <p class="text-gray-500 text-sm mb-2">
                    Rekomendasi Tindakan
                </p>
                <ul class="text-gray-700 text-sm leading-relaxed list-disc list-inside space-y-1">
                    <li>Perbanyak konsumsi sayur dan buah</li>
                    <li>Rutin olahraga minimal 30 menit</li>
                    <li>Kurangi makanan manis dan berlemak</li>
                    <li>Periksa kesehatan secara rutin</li>
                </ul>
            </div>

        </div>
    </main>
</div>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Popup Login Berhasil --}}
@if (session('success'))
<script>
    Swal.fire({
        title: 'Berhasil Login',
        text: '{{ session('success') }}',
        icon: 'success',
        background: '#111827',
        color: '#e5e7eb',
        confirmButtonText: 'OK',
        confirmButtonColor: '#22c55e',
        allowOutsideClick: false
    });
</script>
@endif

{{-- Popup Info --}}
<script>
    function showInfo() {
        Swal.fire({
            title: 'Fitur Dalam Pengembangan',
            html: `
                <p class="text-sm mt-2">
                    Fitur Unduh Laporan Lengkap akan segera tersedia.
                </p>
                <ul class="text-left text-sm mt-3 list-disc list-inside">
                    <li>Riwayat pemeriksaan</li>
                    <li>Grafik perkembangan kesehatan</li>
                    <li>Analisis AI lanjutan</li>
                </ul>
            `,
            icon: 'info',
            confirmButtonColor: '#22c55e'
        });
    }
</script>

@endsection
