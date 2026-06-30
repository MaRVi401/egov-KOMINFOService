<?php

namespace App\Http\Controllers\PenggunaAsn;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\JejakAudit;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Tiket::with('layanan')->where('users_id', Auth::user()->uuid);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', '!=', 'selesai');
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
            'detailApps',
            'detailPengaduan',
            'komentar.user'
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

        // Menghitung jumlah revisi berdasarkan riwayat komentar dari admin
        $jumlahRevisi = $ticket->komentar->count();

        return view('pages.pengguna-asn.submission.show', compact('ticket', 'kategoriEmail', 'jumlahRevisi'));
    }

    public function destroy($uuid)
    {
        $ticket = Tiket::where('uuid', $uuid)
            ->where('users_id', Auth::user()->uuid)
            ->firstOrFail();

        // Hapus lampiran berkas utama jika ada
        if ($ticket->lampiran) {
            if (Storage::disk('s3')->exists($ticket->lampiran)) {
                Storage::disk('s3')->delete($ticket->lampiran);
            }
        }

        // Hapus berkas surat pengantar jika ada
        if ($ticket->surat_pengantar) {
            if (Storage::disk('s3')->exists($ticket->surat_pengantar)) {
                Storage::disk('s3')->delete($ticket->surat_pengantar);
            }
        }

        JejakAudit::create([
            'users_id' => Auth::id(),
            'aksi' => 'delete',
            'nama_tabel' => 'tiket',
            'record_id' => $ticket->uuid,
            'data_lama' => $ticket->toArray(),
            'ip_address' => request()->ip()
        ]);

        $ticket->delete();

        return redirect()->route('submission.index')->with('success', 'Tiket dan seluruh dokumen lampiran berhasil dihapus.');
    }

    public function uploadDocument(Request $request, $uuid)
    {
        // Validasi untuk kedua berkas
        $request->validate([
            'file_surat' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'surat_pengantar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'file_surat.required' => 'Dokumen tindak lanjut wajib diunggah.',
            'file_surat.mimes' => 'Format dokumen tindak lanjut harus berupa Gambar (JPEG/PNG/JPG).',
            'file_surat.max' => 'Ukuran file dokumen tindak lanjut maksimal adalah 2 MB.',
            'surat_pengantar.required' => 'Surat pengantar kepala dinas wajib diunggah.',
            'surat_pengantar.mimes' => 'Format surat pengantar harus berupa Gambar (JPEG/PNG/JPG).',
            'surat_pengantar.max' => 'Ukuran file surat pengantar maksimal adalah 2 MB.',
        ]);

        $ticket = Tiket::where('uuid', $uuid)->firstOrFail();
        $manager = new ImageManager(new Driver());
        $dataLama = ['lampiran' => $ticket->lampiran, 'surat_pengantar' => $ticket->surat_pengantar, 'status' => $ticket->status];

        // Proses unggah File Surat Utama (Dokumen Tindak Lanjut)
        if ($request->hasFile('file_surat')) {
            $fileSurat = $request->file('file_surat');
            $filenameSurat = Str::uuid() . '.webp';
            $imageSurat = $manager->read($fileSurat->getRealPath());
            $encodedSurat = $imageSurat->toWebp(80);
            $pathSurat = 'lampiran_tiket/' . $filenameSurat;

            Storage::disk('s3')->put($pathSurat, $encodedSurat->toString());
            $ticket->lampiran = $pathSurat;
        }

        // Proses unggah Surat Pengantar Kepala Dinas
        if ($request->hasFile('surat_pengantar')) {
            $filePengantar = $request->file('surat_pengantar');
            $filenamePengantar = Str::uuid() . '.webp';
            $imagePengantar = $manager->read($filePengantar->getRealPath());
            $encodedPengantar = $imagePengantar->toWebp(80);
            $pathPengantar = 'surat_pengantar/' . $filenamePengantar;

            Storage::disk('s3')->put($pathPengantar, $encodedPengantar->toString());
            $ticket->surat_pengantar = $pathPengantar;
        }

        // Perbarui status tiket
        $ticket->status = 'diajukan';
        $ticket->petugas_id = null;
        $ticket->save();

        JejakAudit::create([
            'users_id' => Auth::id(),
            'aksi' => 'update',
            'nama_tabel' => 'tiket',
            'record_id' => $ticket->uuid,
            'data_lama' => $dataLama,
            'data_baru' => ['lampiran' => $ticket->lampiran, 'surat_pengantar' => $ticket->surat_pengantar, 'status' => 'diajukan'],
            'ip_address' => request()->ip()
        ]);

        return back()->with('success', 'Semua dokumen berhasil diunggah dan tiket berhasil diajukan!');
    }
}
