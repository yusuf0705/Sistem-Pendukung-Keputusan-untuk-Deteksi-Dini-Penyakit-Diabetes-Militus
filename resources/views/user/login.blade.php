<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-custom-green {
            background-color: #146135;
        }
        .text-custom-green {
            color: #146135;
        }
        .border-custom-green {
            border-color: #146135;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white rounded-lg shadow-md w-full max-w-sm">
        <!-- Header Hijau -->
        <div class="bg-custom-green h-4 rounded-t-lg"></div>

        <div class="p-6">
            <h2 class="text-2xl font-semibold mb-1 text-gray-800">Masuk</h2>
            <p class="text-sm text-gray-600 mb-5">
                Deteksi kesehatan Anda sejak dini <span class="text-green-600">💚</span>
            </p>

            <!-- Form Login -->
            <form action="#" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan email"
                        class="w-full mt-1 p-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-custom-green">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password"
                        class="w-full mt-1 p-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-custom-green">
                </div>

                <div class="text-left">
                    <a href="{{ route('forgot.password') }}" class="text-sm text-blue-600 hover:underline">Lupa Password?</a>
                </div>

                <button type="submit" class="w-full bg-custom-green text-white py-2 rounded-md hover:opacity-90">
                    Masuk
                </button>
            </form>

            <p class="text-center text-sm text-gray-700 mt-5">
                Belum Punya Akun? 
                <a href="{{ route('register') }}" class="text-blue-600 font-medium hover:underline">Daftar</a>
            </p>
        </div>
    </div>

</body>
</html>
