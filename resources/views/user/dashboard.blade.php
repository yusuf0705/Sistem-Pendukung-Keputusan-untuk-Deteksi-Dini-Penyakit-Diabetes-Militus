@extends('layouts.navbar')

@section('title', 'Riwayat Kesehatan')

@section('content')


  <style>
    :root {
      --green-main: #146135;
      --green-light: #e6f3ec;
    }
  </style>

  <div class="flex min-h-screen">
    
    <!-- Konten Utama -->
    <main class="flex-1 p-8">
      <h2 class="text-gray-700 text-2xl font-semibold mb-2">Halo, <span class="text-[color:var(--green-main)]">Andi</span></h2>
      <p class="text-gray-500 mb-6">Pantau risiko diabetes Anda secara real-time</p>

      <!-- Kartu Analisis AI -->
      <div class="bg-[color:var(--green-light)] border border-[color:var(--green-main)]/40 rounded-2xl p-6 flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
          <h3 class="text-lg font-semibold text-gray-700 mb-1">Analisis AI Terkini</h3>
          <p class="text-sm text-gray-600">Status: <span class="font-medium">Terakhir diperbarui: 24 Oktober 2025</span></p>
        </div>
        <button class="bg-[color:var(--green-main)] text-white px-6 py-2 mt-4 md:mt-0 rounded-lg hover:bg-[color:var(--green-main)]/90 transition">
          Lihat Detail Pemeriksaan
        </button>
      </div>

      <!-- Grid Data -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white shadow rounded-2xl p-4 text-center">
          <p class="text-gray-500">Gula Darah</p>
          <h3 class="text-xl font-semibold mt-1">110 mg/dL</h3>
          <p class="text-[color:var(--green-main)] font-medium mt-2">Normal</p>
        </div>

        <div class="bg-white shadow rounded-2xl p-4 text-center">
          <p class="text-gray-500">Tekanan Darah</p>
          <h3 class="text-xl font-semibold mt-1">120/80 mmHg</h3>
          <p class="text-[color:var(--green-main)] font-medium mt-2">Normal</p>
        </div>

        <div class="bg-white shadow rounded-2xl p-4 text-center">
          <p class="text-gray-500">BMI</p>
          <h3 class="text-xl font-semibold mt-1">23.5</h3>
          <p class="text-[color:var(--green-main)] font-medium mt-2">Ideal</p>
        </div>

        <div class="bg-white shadow rounded-2xl p-4 text-left">
          <p class="text-gray-500 mb-1">Rekomendasi Tindakan</p>
          <ul class="text-gray-700 text-sm leading-relaxed list-disc list-inside">
            <li>Perbanyak konsumsi sayur dan buah</li>
            <li>Rutin olahraga minimal 30 menit</li>
            <li>Kurangi makanan manis dan berlemak</li>
            <li>Periksa gula darah secara rutin</li>
          </ul>
        </div>
      </div>
    </main>
  </div>
@endsection
</body>
</html>