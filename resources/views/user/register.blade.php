<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-custom-green {
            background-color: #146135;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white rounded-lg shadow-md w-full max-w-sm border border-blue-400">
        <!-- Header Hijau -->
        <div class="bg-custom-green h-4 rounded-t-lg"></div>

        <div class="p-6">
            <h2 class="text-2xl font-semibold mb-1 text-gray-800">Daftar Akun Baru</h2>
            <p class="text-sm text-gray-600 mb-5">
                Mulai Pantau Kesehatan Anda Dengan Mudah
            </p>

            <!-- Form Register -->
            <form action="{{ route('register.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" id="name" name="name" placeholder="Masukkan nama lengkapmu"
                        class="w-full mt-1 p-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-custom-green"
                        required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan email"
                        class="w-full mt-1 p-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-custom-green"
                        required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password"
                        class="w-full mt-1 p-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-custom-green"
                        required>
                </div>

                <button type="submit" class="w-full bg-custom-green text-white py-2 rounded-md hover:opacity-90">
                    Daftar
                </button>
            </form>

            <p class="text-center text-sm text-gray-700 mt-5">
                Sudah Punya Akun? 
                <a href="{{ route('login') }}" class="text-blue-600 font-medium hover:underline">Masuk</a>
            </p>
        </div>
    </div>

</body>
</html>
