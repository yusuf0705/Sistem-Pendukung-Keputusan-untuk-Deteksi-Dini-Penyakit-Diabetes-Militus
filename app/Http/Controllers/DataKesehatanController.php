<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DataKesehatanUser;

class DataKesehatanController extends Controller
{
    // Tampilkan semua data kesehatan milik user
    public function index()
    {
        $data = DataKesehatanUser::where('id_user', Auth::id())->get();

        return view('DataKesehatan.index', compact('data'));
    }

    // Form tambah data
    public function create()
    {
        return view('DataKesehatan.create');
    }

    // Simpan data ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required',
            'usia'          => 'required|integer',
            'jenis_kelamin' => 'required',
            'berat_badan'   => 'required|numeric',
            'tinggi_badan'  => 'required|numeric',
        ]);

        // Hitung IMT otomatis
        $imt = $request->berat_badan / (($request->tinggi_badan / 100) ** 2);

        DataKesehatanUser::create([
            'id_user'       => Auth::id(),
            'nama'          => $request->nama,
            'usia'          => $request->usia,
            'jenis_kelamin' => $request->jenis_kelamin,
            'berat_badan'   => $request->berat_badan,
            'tinggi_badan'  => $request->tinggi_badan,
            'imt'           => $imt,
        ]);

        return redirect()->route('kesehatan.index')
            ->with('success', 'Data kesehatan berhasil disimpan!');
    }

    // Form edit data
    public function edit($id)
    {
        $data = DataKesehatanUser::findOrFail($id);

        return view('DataKesehatan.edit', compact('data'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'          => 'required',
            'usia'          => 'required|integer',
            'jenis_kelamin' => 'required',
            'berat_badan'   => 'required|numeric',
            'tinggi_badan'  => 'required|numeric',
        ]);

        $data = DataKesehatanUser::findOrFail($id);

        // Hitung ulang IMT
        $imt = $request->berat_badan / (($request->tinggi_badan / 100) ** 2);

        $data->update([
            'nama'          => $request->nama,
            'usia'          => $request->usia,
            'jenis_kelamin' => $request->jenis_kelamin,
            'berat_badan'   => $request->berat_badan,
            'tinggi_badan'  => $request->tinggi_badan,
            'imt'           => $imt,
        ]);

        return redirect()->route('kesehatan.index')
            ->with('success', 'Data kesehatan berhasil diperbarui!');
    }

    // Hapus data
    public function destroy($id)
    {
        DataKesehatanUser::destroy($id);

        return back()->with('success', 'Data kesehatan berhasil dihapus!');
    }
}
