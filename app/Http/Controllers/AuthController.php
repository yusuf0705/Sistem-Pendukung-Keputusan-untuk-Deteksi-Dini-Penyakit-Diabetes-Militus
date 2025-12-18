<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /* =========================
       HALAMAN
    ========================== */

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

    /* =========================
       REGISTER
    ========================== */

    public function register(Request $request)
    {
        $request->validate(
            [
                'name'     => 'required|min:3',
                'email'    => 'required|email|unique:users,email',
                'password' => 'required|min:6',
            ],
            [
                'name.required'     => 'Nama tidak boleh kosong',
                'name.min'          => 'Nama minimal 3 karakter',
                'email.required'    => 'Email tidak boleh kosong',
                'email.email'       => 'Format email tidak valid',
                'email.unique'      => 'Email sudah terdaftar',
                'password.required' => 'Password tidak boleh kosong',
                'password.min'      => 'Password minimal 6 karakter',
            ]
        );

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil! Silakan login.');
    }

    /* =========================
       LOGIN
    ========================== */

    public function login(Request $request)
    {
        $request->validate(
            [
                'email'    => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required'    => 'Email tidak boleh kosong',
                'email.email'       => 'Format email tidak valid',
                'password.required' => 'Password tidak boleh kosong',
            ]
        );

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            // ✅ pesan login berhasil
            session()->flash('success', 'Login berhasil! Selamat datang 👋');

            return Auth::user()->role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('dashboard');
        }

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Email atau password salah!');
    }

    /* =========================
       LOGOUT
    ========================== */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Anda berhasil logout.');
    }
}
