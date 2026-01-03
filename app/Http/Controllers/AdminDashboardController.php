<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        $totalPengguna = User::where('role', 'pengguna')->count();
        $admin = Auth::user(); 

        return view('admin.dashboard', [
            'totalPengguna' => $totalPengguna,
            'admin' => $admin,
            'pageTitle' => 'Admin Dashboard',
        ]);
    }
}
