<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PemeriksaanController extends Controller
{
    public function index()
    {
        return view('user.pemeriksaan');
    }
    
}