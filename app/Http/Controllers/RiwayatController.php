<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {
        return view('user.riwayat_kesehatan.index');
    }

    public function create()
    {
        return view('user.riwayat_kesehatan.create');
    }

    public function store(Request $request)
    {
        // Validate and store the data
    }
}
