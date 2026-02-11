<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return match ($user->role) {
            // Dashboard Super Admin
            'super_admin'  => app(Admin\DashboardController::class)->index(),
            
            // Dashboard Other Roles
            'operator'     => view('pages.operator.dashboard'),
            'kabid'        => view('pages.kabid.dashboard'),
            'pengguna_asn' => view('pages.pengguna-asn.dashboard'),
            
            default        => abort(403, 'Role tidak dikenali.'),
        };
    }
}