<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validasi + custom error message
        $credentials = $request->validate(
            [
                'username' => ['required'],
                'password' => ['required', 'min:8'],
            ],
            [
                'username.required' => 'Username wajib diisi.',
                'password.required' => 'Password wajib diisi.',
                'password.min'      => 'Password minimal 8 karakter.',
            ]
        );

        // 2. Ambil status checkbox "Remember Me"
        $remember = $request->has('remember');

        // 3. Proses autentikasi dengan menyertakan argumen $remember
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Cukup satu tujuan redirect, karena DashboardController yang akan mengatur tampilannya
            return redirect()->intended('/dashboard');
        }

        // Jika username/password salah
        return back()->withErrors([
            'username' => 'Kredensial tidak cocok.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
