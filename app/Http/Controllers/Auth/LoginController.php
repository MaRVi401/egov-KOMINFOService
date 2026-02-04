<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validasi + custom error message
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

        // Proses autentikasi
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            return match (Auth::user()->role) {
                'super_admin'  => redirect()->intended('/super-admin/dashboard'),
                'pengguna_asn' => redirect()->intended('/asn/dashboard'),
                'kabid'        => redirect()->intended('/kabid/dashboard'),
                'operator'     => redirect()->intended('/operator/dashboard'),
                default        => redirect('/'),
            };
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
