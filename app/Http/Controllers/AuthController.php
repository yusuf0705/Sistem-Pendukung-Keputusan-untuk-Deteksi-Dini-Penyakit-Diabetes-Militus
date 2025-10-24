<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('user.login');
    }
    public function showRegister()
    {
        return view('user.register');
    }
    public function showForgotPassword()
    {
        return view('user.forgot-password');
    }

}
