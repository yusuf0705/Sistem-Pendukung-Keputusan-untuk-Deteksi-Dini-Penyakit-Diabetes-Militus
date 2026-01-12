<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Deteksi Diabetes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        .animate-shake {
            animation: shake 0.5s;
            border-color: #ef4444 !important;
        }
        
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9998;
        }
        
        .modal-overlay.show {
            display: block;
            animation: fadeIn 0.3s ease-in-out;
        }
        
        .modal-container {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            z-index: 9999;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-container.show {
            display: block;
            animation: slideIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideIn {
            from { 
                transform: translate(-50%, -60%);
                opacity: 0;
            }
            to { 
                transform: translate(-50%, -50%);
                opacity: 1;
            }
        }

        /* Tooltip styles */
        .tooltip {
            position: relative;
            display: inline-block;
            cursor: help;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 200px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 8px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -100px;
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 12px;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-green-50 to-blue-50 min-h-screen py-8">

<!-- Modal Overlay -->
<div class="modal-overlay" id="modalOverlay"></div>

<!-- Modal Container -->
<div class="modal-container" id="modalContainer">
    <div class="p-8">
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center">
                <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        
        <h3 class="text-2xl font-bold text-gray-800 text-center mb-3" id="modalTitle">
            Silahkan Isi Semua Formnya
        </h3>
        
        <p class="text-gray-600 text-center mb-6" id="modalDescription">
            Anda belum mengisi beberapa pilihan yang wajib diisi.
        </p>
        
        <div id="modalList" class="mb-6"></div>
        
        <div class="flex justify-center">
            <button type="button" id="modalOkBtn" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-8 py-3 rounded-lg transition duration-200 shadow-md">
                OK
            </button>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4">
    <!-- Header -->
    <div class="bg-white rounded-2xl shadow-xl p-8 mb-6">
        <h1 class="text-4xl font-bold text-gray-800 mb-2 text-center">
            🩺 Form Pemeriksaan Diabetes
        </h1>
        <p class="text-center text-gray-600">
            Isi data dengan lengkap untuk mendapatkan analisis risiko diabetes
        </p>
    </div>

    <!-- Form -->
    <form action="{{ route('deteksi.cek') }}" method="POST" class="bg-white rounded-2xl shadow-xl p-8" id="formDeteksi">
        @csrf

        <!-- Alert untuk validasi error dari Laravel -->
        @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada input:</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <!-- Section 1: Data Diri -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-green-500">
                📋 Data Diri
            </h2>
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Usia -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">
                        Usia (tahun) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="usia" 
                        value="{{ old('usia') }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('usia') border-red-500 @enderror"
                        placeholder="Contoh: 30" 
                        min="1"
                        max="120"
                        step="1">
                    <p class="text-red-500 text-sm mt-1 hidden" id="error-usia">⚠️ Usia harus antara 1-120 tahun!</p>
                    @error('usia')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">
                        Jenis Kelamin <span class="text-red-500">*</span>
                    </label>
                    <select name="jenis_kelamin"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('jenis_kelamin') border-red-500 @enderror">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="1" {{ old('jenis_kelamin') == '1' ? 'selected' : '' }}>Laki-Laki</option>
                        <option value="0" {{ old('jenis_kelamin') == '0' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Berat Badan -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">
                        Berat Badan (kg) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="berat_badan" 
                        value="{{ old('berat_badan') }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('berat_badan') border-red-500 @enderror"
                        placeholder="Contoh: 65.5"
                        min="1"
                        max="500"
                        step="0.1">
                    <p class="text-red-500 text-sm mt-1 hidden" id="error-berat_badan">⚠️ Berat badan harus antara 1-500 kg!</p>
                    @error('berat_badan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tinggi Badan -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">
                        Tinggi Badan (cm) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="tinggi_badan" 
                        value="{{ old('tinggi_badan') }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('tinggi_badan') border-red-500 @enderror"
                        placeholder="Contoh: 170"
                        min="50"
                        max="300"
                        step="0.1">
                    <p class="text-red-500 text-sm mt-1 hidden" id="error-tinggi_badan">⚠️ Tinggi badan harus antara 50-300 cm!</p>
                    @error('tinggi_badan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- IMT (Otomatis) -->
                <div class="md:col-span-2">
                    <label class="block font-semibold text-gray-700 mb-2">
                        Indeks Massa Tubuh (IMT) <span class="text-red-500">*</span>
                        <span class="tooltip ml-1">
                            <svg class="w-4 h-4 inline text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="tooltiptext">IMT dihitung otomatis: Berat (kg) / (Tinggi (m))²</span>
                        </span>
                    </label>
                    <div class="flex items-center gap-4">
                        <input type="number" step="0.01" name="imt" id="imt"
                            value="{{ old('imt') }}"
                            class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed"
                            readonly>
                        <div id="imtKategori" class="px-4 py-3 rounded-lg font-semibold text-sm min-w-[150px] text-center bg-gray-100 text-gray-500">
                            Isi berat & tinggi
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">
                        <span class="font-semibold">ℹ️ Info:</span> IMT dihitung otomatis dari berat dan tinggi badan
                    </p>
                </div>
            </div>
        </div>

        <!-- Section 2: Riwayat Kesehatan -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-blue-500">
                🏥 Riwayat Kesehatan
            </h2>
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Riwayat Keluarga -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">
                        Riwayat Keluarga Diabetes <span class="text-red-500">*</span>
                    </label>
                    <select name="keluarga_diabetes"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('keluarga_diabetes') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('keluarga_diabetes') == '1' ? 'selected' : '' }}>Ada</option>
                        <option value="0" {{ old('keluarga_diabetes') == '0' ? 'selected' : '' }}>Tidak Ada</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Orangtua, saudara kandung, atau anak</p>
                    @error('keluarga_diabetes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Riwayat Hipertensi -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">
                        Riwayat Hipertensi <span class="text-red-500">*</span>
                    </label>
                    <select name="riwayat_hipertensi"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('riwayat_hipertensi') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('riwayat_hipertensi') == '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('riwayat_hipertensi') == '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Tekanan darah tinggi (>140/90 mmHg)</p>
                    @error('riwayat_hipertensi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Riwayat Obesitas -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">
                        Riwayat Obesitas <span class="text-red-500">*</span>
                    </label>
                    <select name="riwayat_obesitas"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('riwayat_obesitas') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('riwayat_obesitas') == '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('riwayat_obesitas') == '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Pernah atau sedang mengalami kelebihan berat badan</p>
                    @error('riwayat_obesitas')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Section 3: Gaya Hidup -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-purple-500">
                🏃 Gaya Hidup
            </h2>
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Merokok -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">
                        Kebiasaan Merokok <span class="text-red-500">*</span>
                    </label>
                    <select name="merokok"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition @error('merokok') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('merokok') == '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('merokok') == '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('merokok')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Minum Alkohol -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">
                        Konsumsi Alkohol <span class="text-red-500">*</span>
                    </label>
                    <select name="minum_alkohol"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition @error('minum_alkohol') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('minum_alkohol') == '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('minum_alkohol') == '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('minum_alkohol')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Olahraga -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">
                        Frekuensi Olahraga <span class="text-red-500">*</span>
                    </label>
                    <select name="olahraga"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition @error('olahraga') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="0" {{ old('olahraga') == '0' ? 'selected' : '' }}>Tidak Pernah (0x/minggu)</option>
                        <option value="1" {{ old('olahraga') == '1' ? 'selected' : '' }}>Kadang-kadang (1-2x/minggu)</option>
                        <option value="2" {{ old('olahraga') == '2' ? 'selected' : '' }}>Rutin (≥3x/minggu)</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Minimal 30 menit per sesi</p>
                    @error('olahraga')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pola Makan -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">
                        Pola Makan <span class="text-red-500">*</span>
                    </label>
                    <select name="pola_makan"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition @error('pola_makan') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="0" {{ old('pola_makan') == '0' ? 'selected' : '' }}>Tidak Sehat (banyak gorengan, junk food)</option>
                        <option value="1" {{ old('pola_makan') == '1' ? 'selected' : '' }}>Cukup Sehat (sesekali sayur/buah)</option>
                        <option value="2" {{ old('pola_makan') == '2' ? 'selected' : '' }}>Sangat Sehat (rutin sayur/buah)</option>
                    </select>
                    @error('pola_makan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Section 4: Gejala (Optional) -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-orange-500">
                🩹 Gejala yang Dialami <span class="text-sm font-normal text-gray-500">(Opsional)</span>
            </h2>
            <div class="bg-orange-50 border-l-4 border-orange-500 p-4 mb-4 rounded">
                <p class="text-sm text-orange-800">
                    <span class="font-semibold">ℹ️ Info:</span> Bagian ini bersifat opsional. Isi jika Anda mengalami gejala berikut.
                </p>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Sering Buang Air Kecil Malam -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">
                        Sering Buang Air Kecil Malam Hari
                    </label>
                    <select name="sering_buang_air_kecil_malam"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('sering_buang_air_kecil_malam') == '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('sering_buang_air_kecil_malam') == '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Lebih dari 2x per malam</p>
                </div>

                <!-- Sering Lapar -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">
                        Sering Merasa Lapar
                    </label>
                    <select name="sering_lapar"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('sering_lapar') == '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('sering_lapar') == '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Meski sudah makan cukup</p>
                </div>

                <!-- Pandangan Kabur -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">
                        Pandangan Kabur
                    </label>
                    <select name="pandangan_kabur"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('pandangan_kabur') == '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('pandangan_kabur') == '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Penglihatan tidak jelas</p>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex gap-4">
            <button type="submit"
                class="flex-1 bg-gradient-to-r from-green-600 to-green-700 text-white py-4 rounded-xl font-bold text-lg hover:from-green-700 hover:to-green-800 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                🔍 Deteksi Sekarang
            </button>
            <button type="button" id="resetBtn"
                class="px-8 bg-gray-200 text-gray-700 py-4 rounded-xl font-semibold hover:bg-gray-300 transition duration-300">
                Reset
            </button>
        </div>

        <!-- Info -->
        <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
            <p class="text-sm text-blue-800">
                <span class="font-semibold">ℹ️ Catatan:</span> 
                Semua field bertanda <span class="text-red-500">*</span> wajib diisi. 
                Hasil analisis akan menampilkan tingkat risiko diabetes dan rekomendasi kesehatan.
            </p>
        </div>
    </form>
</div>

<script>
    function showModal(title, description, listItems = []) {
        const modalOverlay = document.getElementById('modalOverlay');
        const modalContainer = document.getElementById('modalContainer');
        const modalTitle = document.getElementById('modalTitle');
        const modalDescription = document.getElementById('modalDescription');
        const modalList = document.getElementById('modalList');
        
        modalTitle.textContent = title;
        modalDescription.textContent = description;
        
        if (listItems.length > 0) {
            let listHTML = '<ul class="text-left space-y-2 bg-gray-50 p-4 rounded-lg max-h-64 overflow-y-auto">';
            listItems.forEach(item => {
                listHTML += `<li class="flex items-start">
                    <span class="text-red-500 mr-2 mt-1">•</span>
                    <span class="text-gray-700">${item}</span>
                </li>`;
            });
            listHTML += '</ul>';
            modalList.innerHTML = listHTML;
        } else {
            modalList.innerHTML = '';
        }
        
        modalOverlay.classList.add('show');
        modalContainer.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
    
    function closeModal() {
        const modalOverlay = document.getElementById('modalOverlay');
        const modalContainer = document.getElementById('modalContainer');
        
        modalOverlay.classList.remove('show');
        modalContainer.classList.remove('show');
        document.body.style.overflow = 'auto';
    }
    
    document.getElementById('modalOkBtn').addEventListener('click', closeModal);
    document.getElementById('modalOverlay').addEventListener('click', closeModal);
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });

    // Validasi input numerik
    const numericFields = [
        { name: 'usia', min: 1, max: 120 },
        { name: 'berat_badan', min: 1, max: 500 },
        { name: 'tinggi_badan', min: 50, max: 300 }
    ];

    numericFields.forEach(field => {
        const input = document.querySelector(`input[name="${field.name}"]`);
        const errorMsg = document.getElementById(`error-${field.name}`);

        if (input && errorMsg) {
            input.addEventListener('input', function(e) {
                const numValue = parseFloat(this.value);
                
                if (this.value && (numValue < field.min || numValue > field.max)) {
                    errorMsg.classList.remove('hidden');
                    this.classList.add('border-red-500');
                    this.classList.remove('border-gray-300');
                } else {
                    errorMsg.classList.add('hidden');
                    this.classList.remove('border-red-500');
                    this.classList.add('border-gray-300');
                }
            });

            input.addEventListener('blur', function() {
                if (this.value === '') {
                    errorMsg.classList.add('hidden');
                    this.classList.remove('border-red-500');
                    this.classList.add('border-gray-300');
                }
            });
        }
    });

    // Hitung IMT otomatis
    const berat = document.querySelector('input[name="berat_badan"]');
    const tinggi = document.querySelector('input[name="tinggi_badan"]');
    const imt = document.getElementById('imt');
    const imtKategori = document.getElementById('imtKategori');

    function hitungIMT() {
        if (berat && tinggi && imt && imtKategori) {
            if (berat.value && tinggi.value) {
                const beratNum = parseFloat(berat.value);
                const tinggiNum = parseFloat(tinggi.value);
                
                if (!isNaN(beratNum) && !isNaN(tinggiNum) && tinggiNum > 0) {
                    let t = tinggiNum / 100;
                    let bmi = beratNum / (t * t);
                    imt.value = bmi.toFixed(2);
                    
                    let kategori = '';
                    let bgColor = '';
                    let textColor = '';
                    
                    if (bmi < 18.5) {
                        kategori = 'Kurus';
                        bgColor = 'bg-blue-100';
                        textColor = 'text-blue-800';
                    } else if (bmi < 25) {
                        kategori = 'Normal';
                        bgColor = 'bg-green-100';
                        textColor = 'text-green-800';
                    } else if (bmi < 30) {
                        kategori = 'Kelebihan Berat';
                        bgColor = 'bg-yellow-100';
                        textColor = 'text-yellow-800';
                    } else {
                        kategori = 'Obesitas';
                        bgColor = 'bg-red-100';
                        textColor = 'text-red-800';
                    }
                    
                    imtKategori.className = `px-4 py-3 rounded-lg font-semibold text-sm min-w-[150px] text-center ${bgColor} ${textColor}`;
                    imtKategori.textContent = kategori;
                }
            } else {
                imt.value = '';
                imtKategori.className = 'px-4 py-3 rounded-lg font-semibold text-sm min-w-[150px] text-center bg-gray-100 text-gray-500';
                imtKategori.textContent = 'Isi berat & tinggi';
            }
        }
    }

    if (berat && tinggi) {
        berat.addEventListener('input', hitungIMT);
        tinggi.addEventListener('input', hitungIMT);
    }

    window.addEventListener('load', hitungIMT);

    // Validasi form sebelum submit
    const formDeteksi = document.getElementById('formDeteksi');
    
    if (formDeteksi) {
        formDeteksi.addEventListener('submit', function(e) {
            const requiredFields = [
                { name: 'usia', label: 'Usia', type: 'number' },
                { name: 'jenis_kelamin', label: 'Jenis Kelamin', type: 'select' },
                { name: 'berat_badan', label: 'Berat Badan', type: 'number' },
                { name: 'tinggi_badan', label: 'Tinggi Badan', type: 'number' },
                { name: 'imt', label: 'IMT', type: 'number' },
                { name: 'keluarga_diabetes', label: 'Riwayat Keluarga Diabetes', type: 'select' },
                { name: 'merokok', label: 'Kebiasaan Merokok', type: 'select' },
                { name: 'minum_alkohol', label: 'Konsumsi Alkohol', type: 'select' },
                { name: 'riwayat_hipertensi', label: 'Riwayat Hipertensi', type: 'select' },
                { name: 'riwayat_obesitas', label: 'Riwayat Obesitas', type: 'select' },
                { name: 'olahraga', label: 'Frekuensi Olahraga', type: 'select' },
                { name: 'pola_makan', label: 'Pola Makan', type: 'select' }
            ];

            let emptyFields = [];
            let emptySelects = [];
            
            requiredFields.forEach(field => {
                const input = document.querySelector(`[name="${field.name}"]`);
                if (input && (!input.value || input.value === '')) {
                    emptyFields.push(field.label);
                    if (field.type === 'select') {
                        emptySelects.push(field.label);
                    }
                }
            });

            if (emptyFields.length > 0) {
                e.preventDefault();
                
                if (emptySelects.length > 0) {
                    showModal(
                        'Silahkan Isi Semua Formnya',
                        'Anda belum mengisi beberapa pilihan yang wajib diisi:',
                        emptySelects
                    );
                } else {
                    showModal(
                        'Tolong Isi Semua Kolom',
                        'Beberapa field wajib belum diisi:',
                        emptyFields
                    );
                }
                
                const firstEmptyFieldName = requiredFields.find(f => emptyFields.includes(f.label))?.name;
                const firstEmptyField = document.querySelector(`[name="${firstEmptyFieldName}"]`);
                if (firstEmptyField) {
                    firstEmptyField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    setTimeout(() => {
                        firstEmptyField.focus();
                        firstEmptyField.classList.add('animate-shake');
                        setTimeout(() => {
                            firstEmptyField.classList.remove('animate-shake');
                        }, 500);
                    }, 300);
                }
                
                return false;
            }

            const hasNumericError = numericFields.some(field => {
                const input = document.querySelector(`input[name="${field.name}"]`);
                const errorMsg = document.getElementById(`error-${field.name}`);
                return errorMsg && !errorMsg.classList.contains('hidden');
            });

            if (hasNumericError) {
                e.preventDefault();
                showModal(
                    'Input Tidak Valid',
                    'Pastikan semua field numerik diisi dengan angka yang benar.',
                    ['Periksa kembali Usia, Berat Badan, dan Tinggi Badan']
                );
                return false;
            }

            const imtValue = parseFloat(imt.value);
            if (!imtValue || imtValue <= 0) {
                e.preventDefault();
                showModal(
                    'IMT Belum Dihitung',
                    'Pastikan berat dan tinggi badan sudah diisi dengan benar.',
                    ['Isi Berat Badan (kg)', 'Isi Tinggi Badan (cm)', 'IMT akan dihitung otomatis']
                );
                if (berat) berat.focus();
                return false;
            }
        });
    }

    // Reset handler dengan konfirmasi
    const resetBtn = document.getElementById('resetBtn');
    if (resetBtn) {
        resetBtn.addEventListener('click', function(e) {
            e.preventDefault();
            showResetConfirmation();
        });
    }
    
    function showResetConfirmation() {
        const modalOverlay = document.getElementById('modalOverlay');
        const modalContainer = document.getElementById('modalContainer');
        const modalTitle = document.getElementById('modalTitle');
        const modalDescription = document.getElementById('modalDescription');
        const modalList = document.getElementById('modalList');
        const modalOkBtn = document.getElementById('modalOkBtn');
        
        modalTitle.textContent = 'Konfirmasi Reset Form';
        modalDescription.textContent = 'Apakah Anda yakin ingin mengosongkan semua data yang telah diisi?';
        modalList.innerHTML = `
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                <p class="text-yellow-800 text-sm">
                    <span class="font-semibold">⚠️ Peringatan:</span> Semua data yang telah Anda isi akan dihapus dan tidak dapat dikembalikan.
                </p>
            </div>
            <div class="flex gap-3 justify-center">
                <button type="button" id="confirmResetBtn" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2 rounded-lg transition duration-200">
                    Ya, Reset Form
                </button>
                <button type="button" id="cancelResetBtn" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold px-6 py-2 rounded-lg transition duration-200">
                    Batal
                </button>
            </div>
        `;
        
        modalOkBtn.style.display = 'none';
        
        modalOverlay.classList.add('show');
        modalContainer.classList.add('show');
        document.body.style.overflow = 'hidden';
        
        document.getElementById('confirmResetBtn').addEventListener('click', function() {
            formDeteksi.reset();
            
            if (imt) imt.value = '';
            if (imtKategori) {
                imtKategori.className = 'px-4 py-3 rounded-lg font-semibold text-sm min-w-[150px] text-center bg-gray-100 text-gray-500';
                imtKategori.textContent = 'Isi berat & tinggi';
            }
            
            numericFields.forEach(field => {
                const errorMsg = document.getElementById(`error-${field.name}`);
                if (errorMsg) {
                    errorMsg.classList.add('hidden');
                }
                const input = document.querySelector(`input[name="${field.name}"]`);
                if (input) {
                    input.classList.remove('border-red-500');
                    input.classList.add('border-gray-300');
                }
            });
            
            closeModal();
            
            setTimeout(() => {
                showModal(
                    'Form Berhasil Direset',
                    'Semua data telah dikosongkan. Anda dapat mengisi form dari awal.',
                    []
                );
                modalOkBtn.style.display = 'inline-block';
            }, 300);
        });
        
        document.getElementById('cancelResetBtn').addEventListener('click', function() {
            closeModal();
            modalOkBtn.style.display = 'inline-block';
        });
    }
</script>

</body>
</html>