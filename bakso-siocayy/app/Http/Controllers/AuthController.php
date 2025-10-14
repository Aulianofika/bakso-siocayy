<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    /**  LOGIN FORM */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**  PROSES LOGIN */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Jika admin => dashboard
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            // Jika user => home
            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**  REGISTER FORM */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**  PROSES REGISTER */
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
            'role' => 'user',
        ]);

        return redirect('/login')->with('success', 'Akun berhasil dibuat, silakan login.');
    }

    /**  FORM LUPA PASSWORD */
    public function showForgotForm()
    {
        return view('auth.forgot');
    }

    /**  RESET PASSWORD SEDERHANA (manual) */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->update(['password' => Hash::make($request->password)]);

        return redirect('/login')->with('success', 'Password berhasil direset. Silakan login ulang.');
    }

    /**  LOGOUT */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
