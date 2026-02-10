<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return match ($user->role) {
            // Memanggil index() dari Admin\DashboardController agar data statistik ter-load
            'super_admin'  => app(Admin\DashboardController::class)->index(),
            
            // Nantinya Anda bisa buat Controller serupa untuk role lain
            'operator'     => view('pages.operator.dashboard'),
            'kabid'        => view('pages.kabid.dashboard'),
            'pengguna_asn' => view('pages.pengguna-asn.dashboard'),
            
            default        => abort(403, 'Role tidak dikenali.'),
        };
    }
}