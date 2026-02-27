<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Tiket::with(['user', 'layanan']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('no_tiket', 'ilike', "%{$search}%")
                  ->orWhereHas('layanan', function ($qL) use ($search) {
                      $qL->where('nama', 'ilike', "%{$search}%");
                  })
                  ->orWhereHas('user', function ($qU) use ($search) {
                      $qU->where('nama', 'ilike', "%{$search}%");
                  });
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $tickets = $query->latest()->paginate(10);

        return view('pages.operator.ticket.index', compact('tickets'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $ticket = Tiket::with(['user', 'layanan', 'riwayatStatus', 'komentar.user'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        return view('pages.operator.ticket.show', compact('ticket'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $ticket = Tiket::where('uuid', $uuid)->firstOrFail();
        $ticket->delete();

        return redirect()->route('operator.ticket.index')
            ->with('success', 'Tiket berhasil dihapus.');
    }
}