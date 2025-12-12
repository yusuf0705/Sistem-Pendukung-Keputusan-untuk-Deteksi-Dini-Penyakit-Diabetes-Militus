<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Deteksi Diabetes</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-lg">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">
        Form Pemeriksaan Diabetes
    </h2>

    <form action="{{ route('deteksi.cek') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Usia -->
        <div>
            <label class="block font-semibold mb-1">Usia (tahun)</label>
            <input type="number" name="usia"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500"
                placeholder="Contoh: 30" required>
        </div>

        <!-- Jenis Kelamin -->
        <div>
            <label class="block font-semibold mb-1">Jenis Kelamin</label>
            <select name="jenis_kelamin"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500" required>
                <option value="">-- Pilih --</option>
                <option value="1">Laki-Laki</option>
                <option value="0">Perempuan</option>
            </select>
        </div>

        <!-- Berat Badan -->
        <div>
            <label class="block font-semibold mb-1">Berat Badan (kg)</label>
            <input type="number" step="0.1" name="berat_badan"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500"
                placeholder="Contoh: 65" required>
        </div>

        <!-- Tinggi Badan -->
        <div>
            <label class="block font-semibold mb-1">Tinggi Badan (cm)</label>
            <input type="number" step="0.1" name="tinggi_badan"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500"
                placeholder="Contoh: 170" required>
        </div>

        <!-- IMT (Otomatis) -->
        <div>
            <label class="block font-semibold mb-1">Indeks Massa Tubuh (IMT)</label>
            <input type="number" step="0.01" name="imt" id="imt"
                class="w-full px-4 py-2 border rounded-lg bg-gray-100 cursor-not-allowed"
                readonly required>
            <p class="text-sm text-gray-600 mt-1">* IMT dihitung otomatis dari berat dan tinggi</p>
        </div>

        <!-- Riwayat Keluarga -->
        <div>
            <label class="block font-semibold mb-1">Riwayat Keluarga Diabetes</label>
            <select name="keluarga_diabetes"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500" required>
                <option value="">-- Pilih --</option>
                <option value="1">Ada</option>
                <option value="0">Tidak Ada</option>
            </select>
        </div>

        <!-- Merokok -->
        <div>
            <label class="block font-semibold mb-1">Merokok</label>
            <select name="merokok"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500" required>
                <option value="">-- Pilih --</option>
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
            </select>
        </div>

        <!-- Minum Alkohol -->
        <div>
            <label class="block font-semibold mb-1">Minum Alkohol</label>
            <select name="minum_alkohol"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500" required>
                <option value="">-- Pilih --</option>
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
            </select>
        </div>

        <!-- Riwayat Hipertensi -->
        <div>
            <label class="block font-semibold mb-1">Riwayat Hipertensi</label>
            <select name="riwayat_hipertensi"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500" required>
                <option value="">-- Pilih --</option>
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
            </select>
        </div>

        <!-- Riwayat Obesitas -->
        <div>
            <label class="block font-semibold mb-1">Riwayat Obesitas</label>
            <select name="riwayat_obesitas"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500" required>
                <option value="">-- Pilih --</option>
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
            </select>
        </div>

        <!-- Olahraga -->
        <div>
            <label class="block font-semibold mb-1">Olahraga</label>
            <select name="olahraga"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500" required>
                <option value="">-- Pilih --</option>
                <option value="0">Tidak Pernah</option>
                <option value="1">Kadang-kadang</option>
                <option value="2">Rutin</option>
            </select>
        </div>

        <!-- Pola Makan -->
        <div>
            <label class="block font-semibold mb-1">Pola Makan</label>
            <select name="pola_makan"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500" required>
                <option value="">-- Pilih --</option>
                <option value="0">Tidak Sehat</option>
                <option value="1">Cukup Sehat</option>
                <option value="2">Sangat Sehat</option>
            </select>
        </div>

        <button type="submit"
            class="w-full bg-green-700 text-white py-3 rounded-lg font-semibold hover:bg-green-800 transition duration-200 shadow-md">
            Deteksi Sekarang
        </button>
    </form>
</div>

<script>
    // Hitung IMT otomatis
    const berat = document.querySelector('input[name="berat_badan"]');
    const tinggi = document.querySelector('input[name="tinggi_badan"]');
    const imt = document.getElementById('imt');

    function hitungIMT() {
        if (berat.value && tinggi.value) {
            let t = tinggi.value / 100;
            let bmi = berat.value / (t * t);
            imt.value = bmi.toFixed(2);
        }
    }

    berat.addEventListener('input', hitungIMT);
    tinggi.addEventListener('input', hitungIMT);
</script>

</body>
</html>
