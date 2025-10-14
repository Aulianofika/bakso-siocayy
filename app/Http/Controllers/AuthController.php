<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /** ===============================
     * 🔹 FORM LOGIN
     * =============================== */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /** ===============================
     * 🔹 PROSES LOGIN
     * =============================== */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Arahkan berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard')->with('success', 'Selamat datang, Admin!');
            }

            if ($user->role === 'user') {
                return redirect()->intended('/home')->with('success', 'Login berhasil!');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /** ===============================
     * 🔹 FORM REGISTER
     * =============================== */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /** ===============================
     * 🔹 PROSES REGISTER
     * =============================== */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // default semua pendaftar = user
        ]);

        return redirect('/login')->with('success', 'Akun berhasil dibuat. Silakan login.');
    }

    /** ===============================
     * 🔹 FORM LUPA PASSWORD
     * =============================== */
    public function showForgotForm()
    {
        return view('auth.forgot');
    }

    /** ===============================
     * 🔹 PROSES RESET PASSWORD MANUAL
     * =============================== */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Password berhasil direset. Silakan login ulang.');
    }

    /** ===============================
     * 🔹 LOGOUT
     * =============================== */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Berhasil logout.');
    }
}
