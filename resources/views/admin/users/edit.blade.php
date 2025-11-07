@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')
<div class="container mx-auto px-6 py-8 max-w-lg">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        ✏️ Edit Pengguna
    </h1>

    <form action="{{ route('admin.users.update', $user->id_user) }}" method="POST" 
          class="bg-white shadow-lg rounded-2xl p-6 border border-green-200">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold mb-2">Nama</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                   class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" required>
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                   class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" required>
            @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-semibold mb-2">Password (opsional)</label>
            <input type="password" id="password" name="password"
                   class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
            <p class="text-gray-500 text-sm mt-1">Kosongkan jika tidak ingin mengganti password.</p>
        </div>

        <div class="mb-6">
            <label for="role" class="block text-gray-700 font-semibold mb-2">Role</label>
            <select id="role" name="role"
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" required>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="pengguna" {{ $user->role === 'pengguna' ? 'selected' : '' }}>Pengguna</option>
            </select>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.users.index') }}" 
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg mr-2 transition">
               Batal
            </a>
            <button type="submit" 
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
