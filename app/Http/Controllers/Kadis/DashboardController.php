<?php

namespace App\Http\Controllers\Kadis;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use App\Models\PrioritasTiketKadis;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTiketSistem = Tiket::count();
        
        $usulanStats = PrioritasTiketKadis::selectRaw("
            count(*) as total,
            count(case when status_persetujuan = 'pending' then 1 end) as pending,
            count(case when status_persetujuan = 'disetujui' then 1 end) as disetujui,
            count(case when status_persetujuan = 'ditolak' then 1 end) as ditolak
        ")->first();

        $usulanMasuk = PrioritasTiketKadis::with(['tiket.layanan', 'pengusul'])
            ->where('status_persetujuan', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $riwayatUsulan = PrioritasTiketKadis::with(['tiket.layanan', 'pengusul'])
            ->whereIn('status_persetujuan', ['disetujui', 'ditolak'])
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        $chartData = [
            'labels' => ['Pending', 'Disetujui', 'Ditolak'],
            'data'   => [
                (int) $usulanStats->pending,
                (int) $usulanStats->disetujui,
                (int) $usulanStats->ditolak
            ]
        ];

        return view('pages.kadis.dashboard', compact(
            'totalTiketSistem',
            'usulanStats',
            'usulanMasuk',
            'chartData',
            'riwayatUsulan'
        ));
    }
}