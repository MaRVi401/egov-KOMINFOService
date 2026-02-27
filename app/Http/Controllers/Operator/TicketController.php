<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    /**
     * Menampilkan Tiket Masuk (Status 'diajukan' & belum ada petugas)
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        // Gunakan style anonymous function agar Intelephense tidak error
        $query = Tiket::with(['user', 'layanan'])
            ->where('status', 'diajukan')
            ->whereNull('petugas_id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('no_tiket', 'ilike', "%{$search}%")
                  ->orWhereHas('user', function ($qu) use ($search) {
                      $qu->where('nama', 'ilike', "%{$search}%");
                  })
                  ->orWhereHas('layanan', function ($ql) use ($search) {
                      $ql->where('nama', 'ilike', "%{$search}%");
                  });
            });
        }

        $tickets = $query->latest()->paginate(10);
        return view('pages.operator.ticket.index', compact('tickets'));
    }

    /**
     * Aksi untuk mengambil alih tiket (Tangani)
     */
    public function handle($uuid)
    {
        // Pastikan tiket masih kosong
        $ticket = Tiket::where('uuid', $uuid)->whereNull('petugas_id')->firstOrFail();

        DB::transaction(function () use ($ticket) {
            $ticket->update([
                'petugas_id' => auth()->user()->uuid,
                'status' => 'ditangani',
            ]);

            // Catat riwayat status
            DB::table('riwayat_status_tiket')->insert([
                'uuid' => (string) Str::uuid(),
                'tiket_id' => $ticket->uuid,
                'users_id' => auth()->user()->uuid,
                'status' => 'ditangani',
                'created_at' => now(),
            ]);
        });

        return redirect()->route('ticket.workdesk')
            ->with('success', 'Tiket berhasil dipindahkan ke meja kerja Anda.');
    }

    /**
     * Menampilkan Meja Kerja (Tiket milik operator login)
     */
    public function workDesk(Request $request)
    {
        $search = $request->input('search');

        $query = Tiket::with(['user', 'layanan'])
            ->where('petugas_id', auth()->user()->uuid)
            ->where('status', 'ditangani');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('no_tiket', 'ilike', "%{$search}%")
                  ->orWhereHas('user', function ($qu) use ($search) {
                      $qu->where('nama', 'ilike', "%{$search}%");
                  });
            });
        }

        $tickets = $query->latest()->paginate(10);
        return view('pages.operator.ticket.workdesk', compact('tickets'));
    }

    /**
     * Detail Tiket
     */
    public function show($uuid)
    {
        $ticket = Tiket::with(['user', 'layanan', 'riwayatStatus', 'komentar.user'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        return view('pages.operator.ticket.show', compact('ticket'));
    }
}