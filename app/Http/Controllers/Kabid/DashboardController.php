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
        // 1. Ambil hitungan status global (Optimasi 1 Query)
        $countStatus = Tiket::selectRaw("
            count(*) as total,
            count(case when status = 'diajukan' then 1 end) as diajukan,
            count(case when status = 'ditangani' then 1 end) as ditangani,
            count(case when status = 'selesai' then 1 end) as selesai,
            count(case when status = 'ditolak' then 1 end) as ditolak
        ")->first();

        $layananAktif = Layanan::count();

        // 2. Kalkulasi Penyelesaian Global: Selesai dibanding (Selesai + Ditangani)
        $totalDiproses = $countStatus->selesai + $countStatus->ditangani;
        $tingkatPenyelesaian = $totalDiproses > 0
            ? round(($countStatus->selesai / $totalDiproses) * 100)
            : 0;

        // 3. Ambil data operator dengan Pagination + Hitungan Progres Individu
        // Menggunakan relasi tiketDitangani (petugas_id) dari model User
        $operatorPerformance = User::where('role', 'operator')
            ->withCount([
                'tiketDitangani as total_handle',
                'tiketDitangani as total_selesai' => function ($query) {
                    $query->where('status', 'selesai'); // Menghitung hanya yang selesai
                }
            ])
            ->paginate(5);

        // 4. Data untuk Grafik Donut
        $chartData = [
            'labels' => ['Diajukan', 'Ditangani', 'Selesai', 'Ditolak'],
            'data'   => [
                (int) $countStatus->diajukan,
                (int) $countStatus->ditangani,
                (int) $countStatus->selesai,
                (int) $countStatus->ditolak
            ]
        ];

        $stats = [
            'total'   => $countStatus->total,
            'selesai' => $countStatus->selesai,
            'proses'  => $countStatus->ditangani,
        ];

        // Respons untuk AJAX Pagination
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
