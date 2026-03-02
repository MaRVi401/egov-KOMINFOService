<?php

namespace App\Http\Controllers\PenggunaAsn;

use App\Http\Controllers\Controller;
use App\Models\Tiket; // Ganti dengan nama Model kamu yang sebenarnya (misal: Submission)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceHistoryTicketController extends Controller
{
    /**
     * Menampilkan halaman riwayat tiket yang sudah selesai.
     */
    public function index(Request $request)
    {
        // 1. Mulai query: Ambil tiket milik user yang sedang login dan yang berstatus 'selesai'
        // Menggunakan 'with' (Eager Loading) untuk memuat relasi 'layanan' agar tidak berat saat dilooping di blade
        $query = Tiket::with('layanan')
            ->where('users_id', Auth::id())
            ->where('status', 'selesai');

        // 2. Tangani fitur pencarian (search)
        if ($request->filled('search')) {
            $search = $request->search;
            
            $query->where(function($q) use ($search) {
                // Cari berdasarkan nomor tiket
                $q->where('no_tiket', 'like', '%' . $search . '%')
                  // Atau cari berdasarkan nama layanan yang berelasi
                  ->orWhereHas('layanan', function($qLayanan) use ($search) {
                      $qLayanan->where('nama', 'like', '%' . $search . '%');
                  });
            });
        }

        // 3. Urutkan berdasarkan waktu update terakhir (waktu diselesaikan) dan buat paginasi
        $tickets = $query->latest('updated_at')->paginate(10);

        // 4. Kembalikan ke view dengan membawa data tiket
        // Pastikan nama view ('riwayat.index') sesuai dengan struktur folder resources/views kamu
        return view('pages.pengguna-asn.history_ticket.index', compact('tickets'));
    }
}