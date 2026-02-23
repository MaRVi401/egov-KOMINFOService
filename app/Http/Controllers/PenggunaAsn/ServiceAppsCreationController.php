<?php

namespace App\Http\Controllers\PenggunaAsn;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Tiket;
use App\Models\DetailTiketLayananPembuatanApp; // Sesuaikan dengan nama Model-mu
use App\Models\RiwayatStatusTiket;
use App\Models\Layanan;

class ServiceAppsCreationController extends Controller
{
    public function index()
    {
        return view('pages.pengguna-asn.layanan.appscreation'); 
    }

    public function store(Request $request)
    {
        $kategori = $request->input('kategori_aktif');

        // Pastikan kategori valid sesuai dengan value yang dikirim dari JS
        if (!in_array($kategori, ['pembangunan_awal', 'pengembangan_fitur'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kategori formulir tidak valid.'
            ], 422);
        }
        
        // 1. Validasi Input (Tanpa validasi no_surat karena di-generate oleh Model)
        $this->validateInput($request, $kategori);

        DB::beginTransaction();
        try {
            // Ambil data layanan dari master tabel (Sesuaikan dengan nama layanan di DB)
            $layanan = Layanan::where('nama', 'LIKE', 'Pembuatan & Pengembangan apps')->firstOrFail();
            
            // Generate Nomor Tiket Internal (Berbeda dengan Nomor Surat)
            $noTiket = 'TPA-' . Carbon::now()->format('dmY') . '-' . Str::upper(Str::random(4));
            
            $jenisLayananDB = ($kategori === 'pembangunan_awal') ? 'Pembangunan Sistem Awal' : 'Pengembangan Fitur';
            
            // 2. Simpan ke tabel tiket master
            $tiket = Tiket::create([
                'uuid'       => (string) Str::uuid(),
                'users_id'   => Auth::user()->uuid,
                'layanan_id' => $layanan->uuid,
                'no_tiket'   => $noTiket,
                'status'     => 'diajukan',
                'deskripsi'  => 'Pembuatan Apps - ' . $jenisLayananDB,
            ]);
        
            // 3. Simpan ke tabel detail (Model akan otomatis mengisi no_surat & convert array ke JSON)
            $this->storeDetail($tiket->uuid, $request, $kategori);
            
            // 4. Catat riwayat status
            RiwayatStatusTiket::create([
                'uuid'     => (string) Str::uuid(), 
                'tiket_id' => $tiket->uuid,
                'users_id' => Auth::user()->uuid, 
                'status'   => 'diajukan'
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'uuid'   => $tiket->uuid
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    private function validateInput($request, $kategori)
    {
        // Perhatikan: 'ajuan_no_surat' dan 'kembang_no_surat' sudah dihapus dari validasi
        if ($kategori === 'pembangunan_awal') {
            $rules = [
                'ajuan_nama_skpd'            => 'required|string|max:255',
                'ajuan_ttd_nama'             => 'required|string|max:255',
                'ajuan_ttd_nip'              => 'required|string|max:50',
                'ajuan_perintah_pj1_nama'    => 'required|string|max:255',
                'ajuan_perintah_pj1_nip'     => 'required|string|max:50',
                'ajuan_perintah_pj1_jabatan' => 'required|string|max:255',
                'ajuan_perintah_pj2_nama'    => 'nullable|string|max:255',
                'ajuan_perintah_pj2_nip'     => 'nullable|string|max:50',
                'ajuan_perintah_pj2_jabatan' => 'nullable|string|max:255',
                'ajuan_nama_sistem'          => 'required|string|max:255',
                'ajuan_ket_sistem'           => 'required|string',
                'ajuan_fitur'                => 'required|array|min:1|max:20',
                'ajuan_fitur.*'              => 'required|string|max:255',
                'ajuan_ket_fitur'            => 'required|string',
            ];
        } else {
            $rules = [
                'kembang_nama_skpd'            => 'required|string|max:255',
                'kembang_ttd_nama'             => 'required|string|max:255',
                'kembang_ttd_nip'              => 'required|string|max:50',
                'kembang_perintah_pj1_nama'    => 'required|string|max:255',
                'kembang_perintah_pj1_nip'     => 'required|string|max:50',
                'kembang_perintah_pj1_jabatan' => 'required|string|max:255',
                'kembang_perintah_pj2_nama'    => 'nullable|string|max:255',
                'kembang_perintah_pj2_jabatan' => 'nullable|string|max:255',
                'kembang_perintah_pj2_nip'     => 'nullable|string|max:50',
                'kembang_nama_sistem'          => 'required|string|max:255',
                'kembang_ket'                  => 'required|string',
                'kembang_nama_fitur'           => 'required|array|min:1|max:20',
                'kembang_nama_fitur.*'         => 'required|string|max:255',
                'kembang_ket_fitur'            => 'required|string',
            ];
        }
 
        $request->validate($rules);
    }

    private function storeDetail($tiketUuid, $request, $kategori)
    {
        $detail = new DetailTiketLayananPembuatanApp();
        $detail->uuid     = (string) Str::uuid();
        $detail->tiket_id = $tiketUuid;

        // Kita tidak lagi memasukkan _no_surat dari request, dan tidak perlu json_encode
        if ($kategori === 'pembangunan_awal') {
            $detail->ajuan_tgl = Carbon::now();
            $detail->ajuan_nama_sistem          = $request->ajuan_nama_sistem;
            $detail->ajuan_ket_sistem           = $request->ajuan_ket_sistem;
            $detail->ajuan_ttd_nama             = $request->ajuan_ttd_nama;
            $detail->ajuan_ttd_nip              = $request->ajuan_ttd_nip;
            $detail->ajuan_perintah_pj1_nama    = $request->ajuan_perintah_pj1_nama;
            $detail->ajuan_perintah_pj1_nip     = $request->ajuan_perintah_pj1_nip;
            $detail->ajuan_perintah_pj1_jabatan = $request->ajuan_perintah_pj1_jabatan;
            
            $detail->ajuan_perintah_pj2_nama    = $request->ajuan_perintah_pj2_nama;
            $detail->ajuan_perintah_pj2_nip     = $request->ajuan_perintah_pj2_nip;
            $detail->ajuan_perintah_pj2_jabatan = $request->ajuan_perintah_pj2_jabatan;

            $detail->ajuan_nama_skpd            = $request->ajuan_nama_skpd;
            
            // Langsung passing array-nya karena Model sudah punya $casts
            $detail->ajuan_fitur                = $request->ajuan_fitur;
            
            $detail->ajuan_ket_fitur            = $request->ajuan_ket_fitur;

        } else {
            $detail->kembang_tgl = Carbon::now();
            $detail->kembang_ttd_nama             = $request->kembang_ttd_nama;
            $detail->kembang_ttd_nip              = $request->kembang_ttd_nip;
            $detail->kembang_nama_sistem          = $request->kembang_nama_sistem;
            $detail->kembang_ket                  = $request->kembang_ket;
            $detail->kembang_perintah_pj1_nama    = $request->kembang_perintah_pj1_nama;
            $detail->kembang_perintah_pj1_nip     = $request->kembang_perintah_pj1_nip;
            $detail->kembang_perintah_pj1_jabatan = $request->kembang_perintah_pj1_jabatan;
            $detail->kembang_perintah_pj2_nama    = $request->kembang_perintah_pj2_nama;
            $detail->kembang_perintah_pj2_nip     = $request->kembang_perintah_pj2_nip;
            $detail->kembang_nama_skpd            = $request->kembang_nama_skpd;
            $detail->kembang_nama_skpd            = $request->kembang_nama_skpd;
            
            // Langsung passing array-nya karena Model sudah punya $casts
            $detail->kembang_nama_fitur           = $request->kembang_nama_fitur;
            
            $detail->kembang_ket_fitur            = $request->kembang_ket_fitur;
        }
        
        $detail->save(); 
        
        return $detail;
    }

    public function download($uuid, \App\Services\WordTemplateServiceAppsCreation $wordService)
    {
        // 1. Ambil data tiket berdasarkan UUID
        $tiket = Tiket::where('uuid', $uuid)->firstOrFail();
        
        // 2. Ambil detail tiket
        $detail = DetailTiketLayananPembuatanApp::where('tiket_id', $tiket->uuid)->firstOrFail();

        // 3. Tentukan kategori berdasarkan data yang terisi
        $kategori = !empty($detail->ajuan_nama_skpd) ? 'pembangunan_awal' : 'pengembangan_fitur';

        // 4. Panggil service Word (yang sudah terhubung ke MinIO)
        return $wordService->generateDokumen($kategori, $detail, $tiket->no_tiket);
    }
}