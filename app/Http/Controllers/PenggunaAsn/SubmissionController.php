<?php

namespace App\Http\Controllers\PenggunaAsn;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Tiket::with('layanan')->where('users_id', Auth::user()->uuid);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('status', 'LIKE', "%{$search}%")
                ->orWhereHas('layanan', function ($subQuery) use ($search) {
                    $subQuery->where('nama', 'LIKE', "%{$search}%");
                });
            });
        }

        $tickets = $query->latest()->paginate(10);

        return view('pages.pengguna-asn.submission.index', compact('tickets'));
    }

    public function show($uuid)
    {
        $ticket = Tiket::with([
            'layanan',
            'detailEmailGov',
            'detailSubdomain',
            'detailApps'
        ])
        ->where('uuid', $uuid)
        ->where('users_id', Auth::user()->uuid)
        ->firstOrFail();

        $kategoriEmail = null; 

        if ($ticket->detailEmailGov) {
            if (!empty($ticket->detailEmailGov->pd_jenis_layanan) || !empty($ticket->detailEmailGov->pd_instansi_nama)) {
                $kategoriEmail = 'perangkat_daerah';
            } elseif (!empty($ticket->detailEmailGov->asn_jenis_layanan) || !empty($ticket->detailEmailGov->asn_nip)) {
                $kategoriEmail = 'asn';
            }
        }

        return view('pages.pengguna-asn.submission.show', compact('ticket', 'kategoriEmail'));
    }

    public function destroy($uuid)
    {
        $ticket = Tiket::where('uuid', $uuid)
            ->where('users_id', Auth::user()->uuid)
            ->firstOrFail();

        $ticket->delete();

        return redirect()->route('submission.index')->with('success', 'Tiket berhasil dihapus.');
    }

    public function uploadDocument(Request $request, $uuid)
    {
        $request->validate([
            'file_surat' => 'required|mimes:pdf|max:2048',
        ], [
            'file_surat.required' => 'Dokumen wajib diunggah.',
            'file_surat.mimes'   => 'Format dokumen harus berupa PDF.',
            'file_surat.max'      => 'Ukuran file maksimal adalah 2 MB.',
        ]);

        $ticket = Tiket::where('uuid', $uuid)->firstOrFail();

        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $path = $file->store('lampiran_tiket', 's3');

            $ticket->lampiran = $path;
            $ticket->save();

            return back()->with('success', 'Dokumen PDF berhasil diunggah ke MinIO!');
        }

        return back()->with('error', 'Terjadi kesalahan saat mengunggah dokumen.');
    }
}