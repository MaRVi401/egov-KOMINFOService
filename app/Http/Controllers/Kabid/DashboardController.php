<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use App\Models\Layanan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil data statistik Dasar
        $layananAktif = Layanan::count();
        $stats = [
            'total'   => Tiket::count(),
            'selesai' => Tiket::where('status', 'selesai')->count(),
            'proses'  => Tiket::where('status', 'ditangani')->count(),
        ];

        // 2. Kalkulasi Tingkat Penyelesaian (%)
        $tingkatPenyelesaian = $stats['total'] > 0
            ? round(($stats['selesai'] / $stats['total']) * 100)
            : 0;

        // 3. Ambil data operator dengan Pagination
        $operatorPerformance = User::where('role', 'operator')
            ->withCount(['tiketDitangani as total_handle'])
            ->paginate(5);

        // 4. Data untuk Grafik Donat
        $chartData = [
            'labels' => ['Diajukan', 'Ditangani', 'Selesai', 'Ditolak'],
            'data'   => [
                Tiket::where('status', 'diajukan')->count(),
                Tiket::where('status', 'ditangani')->count(),
                Tiket::where('status', 'selesai')->count(),
                Tiket::where('status', 'ditolak')->count(),
            ]
        ];

        // LOGIKA AJAX: Mencegah Refresh Halaman
        if ($request->ajax()) {
            return view('pages.kabid._operator_table', compact('operatorPerformance', 'stats'))->render();
        }

        return view('pages.kabid.dashboard', compact(
            'layananAktif',
            'tingkatPenyelesaian',
            'stats',
            'chartData',
            'operatorPerformance'
        ));
    }
}
