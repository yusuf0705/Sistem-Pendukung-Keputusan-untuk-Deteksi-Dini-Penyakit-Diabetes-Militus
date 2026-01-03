<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $user = Auth::user();

        return view('user.dashboard', [
            'user' => $user,
            'pageTitle' => 'Dashboard',
        ]);
    }
}
