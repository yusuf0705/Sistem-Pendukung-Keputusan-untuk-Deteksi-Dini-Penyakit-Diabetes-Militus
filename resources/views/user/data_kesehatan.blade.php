<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Kesehatan</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { background-color: #E8F5E9; }
        .btn-green { background-color: #146135; }
        .btn-green:hover { opacity: 0.9; }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center">

    <div class="bg-white rounded-xl shadow-lg w-full max-w-3xl p-8 border">

        <h2 class="text-xl font-semibold text-gray-800">Input Data Kesehatan</h2>
        <p class="text-sm text-gray-600 mb-6">Masukkan data kesehatan Anda untuk deteksi IMT.</p>

        <form action="{{ route('data-kesehatan.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium">Nama</label>
                <input type="text" name="nama" required class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Usia</label>
                    <input type="number" name="usia" required class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium">Jenis Kelamin</label>
                    <select name="jenis_kelamin" required class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        <option value="">Pilih</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Berat Badan (kg)</label>
                    <input type="number" step="0.1" name="berat_badan" required class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium">Tinggi Badan (cm)</label>
                    <input type="number" step="0.1" name="tinggi_badan" required class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                </div>
            </div>

            <button type="submit" class="w-full py-2 text-white font-semibold rounded-md btn-green">
                Simpan & Deteksi
            </button>

        </form>

    </div>

</body>
</html>
