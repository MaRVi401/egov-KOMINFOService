<?php
namespace App\Http\Controllers;

use App\Models\PrioritasTiketKadis;
use App\Models\Tiket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsulanKabidController extends Controller
{
    /**
     * Menampilkan daftar tiket yang diusulkan oleh Kabid yang sedang login.
     */
    public function index()
    {
        $usulan = PrioritasTiketKadis::with(['tiket.layanan', 'penerima'])
            ->where('pengusul_id', Auth::user()->uuid)
            ->latest()
            ->get();

        return view('kabid.usulan.index', compact('usulan'));
    }

    /**
     * Form untuk membuat usulan baru (opsional jika langsung dari detail tiket)
     */
    public function create(Request $request)
    {
        // Ambil tiket yang belum selesai dan belum diusulkan
        $tiket_id = $request->query('tiket_id');
        $tiket = Tiket::findOrFail($tiket_id);
        
        // Cari user yang berperan sebagai Kadis/Penerima (Asumsi role super_admin untuk Kadis)
        $kadis = User::where('role', 'super_admin')->first(); 

        return view('kabid.usulan.create', compact('tiket', 'kadis'));
    }

    /**
     * Menyimpan usulan ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tiket_id' => 'required|exists:tiket,uuid',
            'penerima_id' => 'required|exists:users,uuid',
            'catatan_kabid' => 'required|string|max:255',
            'level_prioritas' => 'required|in:rendah,sedang,tinggi',
        ]);

        PrioritasTiketKadis::create([
            'tiket_id' => $request->tiket_id,
            'pengusul_id' => Auth::user()->uuid,
            'penerima_id' => $request->penerima_id,
            'catatan_kabid' => $request->catatan_kabid,
            'level_prioritas' => $request->level_prioritas,
            'status_persetujuan' => 'pending', // Default dari skema
        ]);

        // Opsional: Catat aksi ini ke jejak_audit
        // JejakAudit::create([...]);

        return redirect()->route('kabid.usulan.index')
                         ->with('success', 'Usulan prioritas berhasil dikirim ke Kadis.');
    }
}