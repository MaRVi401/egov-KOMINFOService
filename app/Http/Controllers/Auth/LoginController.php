<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LogKeamanan;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required', 'min:8'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 8 karakter.',
        ]);

        $remember = $request->has('remember');
        $ipAddress = $request->ip();
        $userAgent = $request->header('User-Agent');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // [SIEM] Catat Login Berhasil
            LogKeamanan::create([
                'users_id' => Auth::id(),
                'username_attempt' => $request->username,
                'tipe_event' => 'login_sukses',
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'is_suspicious' => false
            ]);

            return redirect()->intended('/dashboard');
        }

        // [SIEM] Deteksi Brute Force (Suspicious)
        $failedCount = LogKeamanan::where('ip_address', $ipAddress)
            ->where('tipe_event', 'login_gagal')
            ->where('created_at', '>=', now()->subMinutes(10))
            ->count();

        // [SIEM] Catat Login Gagal
        LogKeamanan::create([
            'users_id' => null,
            'username_attempt' => $request->username,
            'tipe_event' => 'login_gagal',
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'is_suspicious' => $failedCount >= 4 // Alert jika gagal ke-5 kalinya
        ]);

        return back()->withErrors(['username' => 'Kredensial tidak cocok.'])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        // [SIEM] Catat Logout sebelum session dihancurkan
        if (Auth::check()) {
            LogKeamanan::create([
                'users_id' => Auth::id(),
                'username_attempt' => Auth::user()->username,
                'tipe_event' => 'logout',
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'is_suspicious' => false
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
