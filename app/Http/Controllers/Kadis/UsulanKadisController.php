<?php

namespace App\Http\Controllers\Kadis;

use App\Http\Controllers\Controller;
use App\Models\PrioritasTiketKadis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsulanKadisController extends Controller
{
    public function update(Request $request, $uuid)
    {
        $request->validate([
            'status_persetujuan' => 'required|in:disetujui,ditolak',
            'catatan_kadis' => 'required|string|max:255',
        ]);

        $usulan = PrioritasTiketKadis::where('uuid', $uuid)->firstOrFail();

        DB::transaction(function () use ($request, $usulan) {
            $usulan->update([
                'status_persetujuan' => $request->status_persetujuan,
                'catatan_kadis' => $request->catatan_kadis,
            ]);

            if ($request->status_persetujuan === 'disetujui') {
                $tiket = $usulan->tiket;
                if ($tiket && $tiket->status === 'selesai') {
                    $tiket->update([
                        'status' => 'diajukan' 
                    ]);
                }
            }
        });

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Keputusan berhasil disimpan.'
            ]);
        }

        return redirect()->route('kadis.dashboard.index')->with('success', 'Keputusan berhasil disimpan.');
    }
}