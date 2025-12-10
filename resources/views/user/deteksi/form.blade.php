<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Deteksi Diabetes</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
        Form Pemeriksaan Diabetes
    </h2>

    <form action="{{ route('deteksi.store') }}" method="POST">
        @csrf

        <!-- Usia -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Usia</label>
            <input type="number" name="usia" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <!-- Jenis Kelamin -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="">-- Pilih --</option>
                <option value="1">Laki-Laki</option>
                <option value="0">Perempuan</option>
            </select>
        </div>

        <!-- Riwayat Keluarga -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Riwayat Keluarga Diabetes</label>
            <select name="riwayat_keluarga" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="">-- Pilih --</option>
                <option value="1">Ada</option>
                <option value="0">Tidak Ada</option>
            </select>
        </div>

        <!-- Merokok -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Merokok</label>
            <select name="merokok" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="">-- Pilih --</option>
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
            </select>
        </div>

        <!-- Alkohol -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Konsumsi Alkohol</label>
            <select name="alkohol" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="">-- Pilih --</option>
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
            </select>
        </div>

        <!-- Obesitas -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Obesitas</label>
            <select name="obesitas" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="">-- Pilih --</option>
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
            </select>
        </div>

        <!-- Olahraga -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Olahraga Rutin</label>
            <select name="olahraga" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="">-- Pilih --</option>
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
            </select>
        </div>

        <button type="submit" 
                class="w-full bg-green-700 text-white py-3 rounded-lg font-semibold hover:bg-green-800 transition">
            Deteksi Sekarang
        </button>
    </form>
</div>

</body>
</html>
