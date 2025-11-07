@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
            💚 Manajemen Pengguna
        </h1>
        <a href="{{ route('admin.users.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl shadow-md transition transform hover:scale-105">
           + Tambah Pengguna
        </a>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-5 shadow-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    <!-- Card Container -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-green-200">
        <table class="min-w-full border-collapse">
            <thead class="bg-gradient-to-r from-green-600 to-emerald-500 text-white">
                <tr>
                    <th class="text-left py-3 px-4 font-semibold">No</th>
                    <th class="text-left py-3 px-4 font-semibold">Nama</th>
                    <th class="text-left py-3 px-4 font-semibold">Email</th>
                    <th class="text-left py-3 px-4 font-semibold">Role</th>
                    <th class="text-center py-3 px-4 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                    <tr class="hover:bg-green-50 transition-all duration-200 border-b border-gray-200">
                        <td class="py-4 px-4 text-gray-700">{{ $index + 1 }}</td>
                        <td class="py-4 px-4 font-medium text-gray-800">{{ $user->name }}</td>
                        <td class="py-4 px-4 text-gray-600">{{ $user->email }}</td>
                        <td class="py-4 px-4">
                            @if($user->role === 'admin')
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">
                                    Admin
                                </span>
                            @else
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                                    User
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-center flex justify-center items-center gap-2">
                            <!-- Tombol Edit -->
                            <a href="{{ route('admin.users.edit', $user->id_user) }}" 
                               class="flex items-center bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg hover:bg-yellow-200 transition font-semibold text-sm">
                                ✏️ Edit
                            </a>
                            <!-- Tombol Hapus -->
                            <form action="{{ route('admin.users.destroy', $user->id_user) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')"
                                  class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="flex items-center bg-red-100 text-red-700 px-3 py-1 rounded-lg hover:bg-red-200 transition font-semibold text-sm">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">Belum ada data pengguna</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Total Data -->
    <div class="mt-4 text-gray-600 text-sm">
        Total pengguna: <span class="font-semibold text-gray-800">{{ $users->count() }}</span>
    </div>
</div>
@endsection
