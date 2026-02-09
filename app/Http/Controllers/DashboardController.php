<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        switch ($user->role) {
            case 'super_admin':
                return view('pages.super-admin.dashboard');
            case 'operator':
                return view('pages.operator.dashboard');
            case 'kabid':
                return view('pages.kabid.dashboard');
            case 'pengguna_asn':
                return view('pages.pengguna-asn.dashboard');
            default:
                abort(403, 'Role tidak dikenali.');
        }
    }
}