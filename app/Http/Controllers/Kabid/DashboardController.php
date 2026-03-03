<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use App\Models\Layanan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $layananAktif = Layanan::count();
        $stats = [
            'total'   => Tiket::count(),
            'selesai' => Tiket::where('status', 'selesai')->count(),
            'proses'  => Tiket::where('status', 'ditangani')->count(),
        ];

        // Logika Tingkat Penyelesaian (%)
        $tingkatPenyelesaian = $stats['total'] > 0
            ? round(($stats['selesai'] / $stats['total']) * 100)
            : 0;

        // Ambil data operator menggunakan relasi 'tiketDitangani' dari model User
        $operatorPerformance = User::where('role', 'operator')
            ->withCount(['tiketDitangani as total_handle'])
            ->get();

        $chartData = [
            'labels' => ['Diajukan', 'Ditangani', 'Selesai', 'Ditolak'],
            'data'   => [
                Tiket::where('status', 'diajukan')->count(),
                Tiket::where('status', 'ditangani')->count(),
                Tiket::where('status', 'selesai')->count(),
                Tiket::where('status', 'ditolak')->count(),
            ]
        ];

        return view('pages.kabid.dashboard', compact(
            'layananAktif',
            'tingkatPenyelesaian',
            'stats',
            'chartData',
            'operatorPerformance'
        ));
    }

    // Method untuk mengambil detail tiket via AJAX
    public function operatorTickets($uuid)
    {
        $operator = User::where('role', 'operator')->where('uuid', $uuid)->firstOrFail();

        $tickets = Tiket::with(['user', 'layanan'])
            ->where('petugas_id', $uuid)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'operator' => $operator->nama,
            'tickets' => $tickets
        ]);
    }
}
