<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Pemeriksaan</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background-color: #E8F5E9;
        }
        .btn-green {
            background-color: #146135;
        }
        .btn-green:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">

    <div class="bg-white rounded-xl shadow-lg w-full max-w-4xl p-8 md:flex md:space-x-8 border border-gray-200">
        <!-- Kiri: Form -->
        <div class="flex-1">
            <div class="flex items-center space-x-2 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6m9 6H3a2 2 0 01-2-2V5a2 2 0 012-2h7l2 2h10a2 2 0 012 2v12a2 2 0 01-2 2z" />
                </svg>
                <h2 class="text-lg font-semibold text-gray-800">Input Data Pemeriksaan</h2>
            </div>

            <p class="text-sm text-gray-600 mb-6">Masukkan data kesehatan Anda untuk deteksi dini risiko diabetes.</p>

            <form action="#" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium">Nama Lengkap</label>
                    <input type="text" name="nama" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-700 focus:border-green-700">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Umur</label>
                        <input type="number" name="umur" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            <option value="">Pilih</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Berat Badan (kg)</label>
                        <input type="number" name="berat" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Tinggi Badan (cm)</label>
                        <input type="number" name="tinggi" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Gula Darah Puasa (mg/dL)</label>
                        <input type="number" name="gula" placeholder="OPSIONAL" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Tekanan Darah</label>
                        <input type="text" name="tekanan" placeholder="OPSIONAL" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Aktivitas Fisik (minggu)</label>
                        <input type="number" name="aktivitas" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Riwayat Keluarga Diabetes</label>
                        <input type="text" name="riwayat" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>

                <div>
                    <h3 class="font-medium mt-4 mb-2">Gejala yang Dirasakan</h3>
                    <div class="grid grid-cols-2 gap-2 text-sm text-gray-700">
                        <label><input type="checkbox" name="gejala[]" value="Sering buang air kecil" class="mr-2">Sering buang air kecil</label>
                        <label><input type="checkbox" name="gejala[]" value="Sering merasa haus" class="mr-2">Sering merasa haus</label>
                        <label><input type="checkbox" name="gejala[]" value="Mudah lelah" class="mr-2">Mudah lelah</label>
                        <label><input type="checkbox" name="gejala[]" value="Berat badan turun tanpa sebab" class="mr-2">Berat badan turun tanpa sebab</label>
                        <label><input type="checkbox" name="gejala[]" value="Sering merasa lapar" class="mr-2">Sering merasa lapar</label>
                    </div>
                </div>

                <div class="flex space-x-4 mt-6">
                    <button type="submit" class="flex-1 py-2 rounded-md text-white font-semibold btn-green">
                        Deteksi Sekarang
                    </button>
                    <button type="reset" class="flex-1 py-2 rounded-md text-white font-semibold btn-green">
                        Reset Data
                    </button>
                </div>
            </form>
        </div>

        <!-- Kanan: Ilustrasi -->
        <div class="hidden md:flex items-center justify-center flex-1">
            <img src="{{ asset('images/ai-doctor.png') }}" alt="AI Doctor" class="w-64 h-auto">
        </div>
    </div>

</body>
</html>
