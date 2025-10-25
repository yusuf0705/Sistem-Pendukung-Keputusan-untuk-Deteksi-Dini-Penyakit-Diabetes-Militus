<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeteksiController extends Controller
{
    public function index()
    {
        return view('user.deteksi.index');
    }

    public function create()
    {
        return view('user.deteksi.create');
    }

    public function store(Request $request)
    {
        // Validate and store the data
    }
}
