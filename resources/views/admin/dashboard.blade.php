@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    
    <!-- Card Total Users -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Pengguna</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-2">156</h3>
                <p class="text-green-500 text-sm mt-2">↑ 12% dari bulan lalu</p>
            </div>
            <div class="bg-blue-100 rounded-full p-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Card Total Pemeriksaan -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Pemeriksaan</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-2">1,284</h3>
                <p class="text-green-500 text-sm mt-2">↑ 8% dari bulan lalu</p>
            </div>
            <div class="bg-green-100 rounded-full p-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Card Risiko Tinggi -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Risiko Tinggi</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-2">42</h3>
                <p class="text-red-500 text-sm mt-2">Perlu perhatian</p>
            </div>
            <div class="bg-red-100 rounded-full p-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <!-- Pemeriksaan Terbaru -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Pemeriksaan Terbaru</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between pb-4 border-b">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 font-semibold">JD</span>
                    </div>
                    <div class="ml-3">
                        <p class="font-medium text-gray-800">John Doe</p>
                        <p class="text-sm text-gray-500">25 Okt 2025, 14:30</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-red-100 text-red-600 text-xs font-semibold rounded-full">Risiko Tinggi</span>
            </div>
            
            <div class="flex items-center justify-between pb-4 border-b">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <span class="text-green-600 font-semibold">AR</span>
                    </div>
                    <div class="ml-3">
                        <p class="font-medium text-gray-800">Ahmad Rahman</p>
                        <p class="text-sm text-gray-500">25 Okt 2025, 13:15</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-green-100 text-green-600 text-xs font-semibold rounded-full">Risiko Rendah</span>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                        <span class="text-yellow-600 font-semibold">SN</span>
                    </div>
                    <div class="ml-3">
                        <p class="font-medium text-gray-800">Siti Nurhaliza</p>
                        <p class="text-sm text-gray-500">24 Okt 2025, 16:45</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-yellow-100 text-yellow-600 text-xs font-semibold rounded-full">Risiko Sedang</span>
            </div>
        </div>
    </div>

    <!-- Statistik Prediksi -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Prediksi (Bulan Ini)</h3>
        <div class="space-y-4">
            <div>
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Risiko Rendah</span>
                    <span class="text-sm font-semibold text-gray-800">65%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-green-500 h-3 rounded-full" style="width: 65%"></div>
                </div>
            </div>
            
            <div>
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Risiko Sedang</span>
                    <span class="text-sm font-semibold text-gray-800">25%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-yellow-500 h-3 rounded-full" style="width: 25%"></div>
                </div>
            </div>
            
            <div>
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Risiko Tinggi</span>
                    <span class="text-sm font-semibold text-gray-800">10%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-red-500 h-3 rounded-full" style="width: 10%"></div>
                </div>
            </div>
        </div>
        
        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
            <p class="text-sm text-blue-800">
                <span class="font-semibold">Info:</span> Data evaluasi AI diperbarui setiap hari untuk meningkatkan akurasi prediksi.
            </p>
        </div>
    </div>
</div>
@endsection
