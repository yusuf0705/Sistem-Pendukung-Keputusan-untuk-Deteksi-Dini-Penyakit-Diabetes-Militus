<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-custom-green {
            background-color: #146135;
        }
        .text-custom-green {
            color: #146135;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white rounded-lg shadow-md w-full max-w-sm border border-gray-300 p-6">
        <h2 class="text-xl font-semibold mb-2 text-gray-800">Lupa Kata Sandi?</h2>
        <p class="text-sm text-gray-600 mb-5">
            Masukkan alamat email yang terdaftar. Kami akan mengirim tautan untuk mengatur ulang kata sandi Anda.
        </p>

        <!-- Form Reset -->
        <form action="#" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan email"
                    class="w-full mt-1 p-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-custom-green">
            </div>

            <button type="submit" class="w-full bg-custom-green text-white py-2 rounded-md hover:opacity-90">
                Kirim Tautan Reset
            </button>
        </form>

        <p class="text-center text-sm text-gray-700 mt-5">
            Kembali Ke 
            <a href="{{ route('login') }}" class="text-blue-600 font-medium hover:underline">Masuk</a>
        </p>
    </div>

</body>
</html>
