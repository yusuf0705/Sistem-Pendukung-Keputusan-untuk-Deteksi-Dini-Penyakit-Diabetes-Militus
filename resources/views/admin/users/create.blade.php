@extends('layouts.admin')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="container mx-auto px-6 py-8 max-w-lg">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 flex items-center gap-2">
        ➕ Tambah Pengguna
    </h1>

    <div class="bg-white shadow-lg rounded-2xl p-6 border border-green-200">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <!-- Nama -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                <input type="text" name="name" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none"
                       placeholder="Masukkan nama pengguna">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" name="email" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none"
                       placeholder="Masukkan email pengguna">
            </div>

            <!-- Role -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Role</label>
                <select name="role" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none">
                    <option value="">-- Pilih Role --</option>
                    <option value="admin">Admin</option>
                    <option value="pengguna">Pengguna</option>
                </select>
            </div>

            <!-- Password -->
            <div class="mb-6 relative">
                <label class="block text-gray-700 font-semibold mb-2">Password</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none pr-10"
                       placeholder="Masukkan password">
                <button type="button" id="togglePassword"
                        class="absolute inset-y-0 right-3 top-7 flex items-center text-gray-500">
                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                </button>
            </div>

            <!-- Tombol -->
            <div class="flex justify-end">
                <a href="{{ route('admin.users.index') }}" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg mr-2 transition">
                   Batal
                </a>
                <button type="submit" 
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");
    const eyeIcon = document.querySelector("#eyeIcon");

    togglePassword.addEventListener("click", () => {
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);
        eyeIcon.innerHTML = type === "password"
            ? `<path stroke-linecap="round" stroke-linejoin="round" 
                d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
               <circle cx='12' cy='12' r='3' />`
            : `<path stroke-linecap="round" stroke-linejoin="round"
                d="M3 3l18 18M9.88 9.88A3 3 0 0112 9c1.657 0 3 1.343 3 3a3 3 0 01-.88 2.12M15 15l1.42 1.42M9 9L7.58 7.58M12 5c4.478 0 8.268 2.943 9.542 7a10.478 10.478 0 01-1.308 2.528M4.458 12A10.478 10.478 0 015.766 9.47" />`;
    });
</script>
@endsection
