<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * Tampilkan semua pengguna
     */
    public function index()
    {
        // Ubah 'id' jadi 'id_user'
        $users = User::orderBy('id_user', 'asc')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Tampilkan form tambah pengguna
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Simpan pengguna baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,pengguna',
        ]);

        // Simpan data ke database
        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Pengguna berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit pengguna
     */
    public function edit($id_user)
    {
        $user = User::findOrFail($id_user);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update data pengguna
     */
    public function update(Request $request, $id_user)
    {
        $user = User::findOrFail($id_user);

        $validated = $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'role'  => 'required|in:admin,pengguna',
        ]);

        // Update data
        $user->update($validated);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Data pengguna berhasil diperbarui!');
    }

    /**
     * Hapus pengguna
     */
    public function destroy($id_user)
    {
        $user = User::findOrFail($id_user);
        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Pengguna berhasil dihapus!');
    }
}
