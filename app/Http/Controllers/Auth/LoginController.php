<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class LoginController extends Controller
{
    public function login(Request $request) {
    $credentials = $request->validate([
        'username' => ['required'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        
        // Redirect berdasarkan role
        return match (Auth::user()->role) {
            'super_admin' => redirect()->intended('/super-admin/dashboard'),
            'pengguna_asn' => redirect()->intended('/asn/dashboard'),
            'kabid'        => redirect()->intended('/kabid/dashboard'),
            'operator'     => redirect()->intended('/operator/dashboard'),
            default        => redirect('/'),
        };
    }

    return back()->withErrors(['username' => 'Kredensial tidak cocok.']);
}
}
