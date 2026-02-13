<?php
/*-----------------------------------------------------
    THIS CODE IS ONLY FOR DEVELOPMENT 
--------------------------------------------------------*/


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DevTemplateController extends Controller
{
    public function index()
    {
        return view('dev.upload-template');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'template_file' => 'required|file|mimes:docx|max:2048', // Max 2MB
            'target_name'   => 'required|string', // Nama file yang akan disimpan di MinIO
        ]);

        try {
            // 2. Ambil File
            $file = $request->file('template_file');
            $targetName = $request->target_name;

            // 3. Tentukan Disk (Sesuai config filesystems.php Anda)
            // Gunakan 's3' atau 'minio' sesuai setup Anda terakhir
            $disk = 's3'; 

            // 4. Upload ke MinIO (Timpa jika ada)
            // storeAs(folder, nama_file, disk)
            // Kita kosongkan folder pertama ('') agar tersimpan di root bucket
            // atau ganti 'templates' jika struktur folder Anda begitu.
            $path = $file->storeAs('', $targetName, $disk);

            if ($path) {
                return back()->with('success', "Berhasil upload: <strong>$targetName</strong> ke MinIO ($disk).");
            } else {
                return back()->with('error', "Gagal upload ke MinIO.");
            }

        } catch (\Exception $e) {
            return back()->with('error', "Error: " . $e->getMessage());
        }
    }
}