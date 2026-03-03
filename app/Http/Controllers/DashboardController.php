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

            // Dashboard Operator
            'operator'     => app(Operator\DashboardController::class)->index(request()),

            // Dashboard Role Lainnya
            'kabid' => app(\App\Http\Controllers\Kabid\DashboardController::class)->index(),

            'pengguna_asn' => view('pages.pengguna-asn.dashboard'),

            default        => abort(403, 'Role tidak dikenali.'),
        };
    }
}
