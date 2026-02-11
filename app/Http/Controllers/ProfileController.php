<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash, Storage, DB};
use Illuminate\Validation\Rule;
use Intervention\Image\Laravel\Facades\Image; 
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman edit profil dengan data NIP.
     */
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();

        // 1. Ambil NIP secara dinamis berdasarkan relasi role user
        $roleRelation = Str::camel($user->role);
        $nip = $user->$roleRelation ? $user->$roleRelation->nip : '-';

        // 2. Kirim data user dan nip ke view
        return view('pages.edit-profile', compact('user', 'nip'));
    }

    /**
     * Memproses pembaruan profil dan kompresi foto.
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'nama'     => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->uuid, 'uuid')],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->uuid, 'uuid')],
            'no_wa'    => 'nullable|string|max:15',
            'alamat'   => 'nullable|string',
            'avatar'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = $request->only(['nama', 'username', 'email', 'no_wa', 'alamat']);

        // --- LOGIKA UPLOAD & KOMPRES GAMBAR ---
        if ($request->hasFile('avatar')) {
            try {
                // 1. Hapus avatar lama di S3 jika ada
                if ($user->avatar && Storage::disk('s3')->exists($user->avatar)) {
                    Storage::disk('s3')->delete($user->avatar);
                }

                $file = $request->file('avatar');
                
                // 2. Buat path file lengkap dengan folder 'avatars/'
                $filename = 'avatars/avatar_' . $user->uuid . '_' . time() . '.webp';

                // 3. Proses gambar dengan Intervention Image
                $image = Image::read($file);
                $image->scale(width: 500); // Resize agar ukuran file kecil
                $encoded = $image->toWebp(quality: 75); // Konversi ke WebP

                // 4. Upload ke S3/MinIO
                Storage::disk('s3')->put($filename, (string) $encoded);

                // 5. Simpan path lengkap ke database agar pemanggilan di Blade mudah
                $data['avatar'] = $filename;

            } catch (\Exception $e) {
                return back()->withErrors(['avatar' => 'Gagal memproses gambar: ' . $e->getMessage()]);
            }
        }

        // Update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}