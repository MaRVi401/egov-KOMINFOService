<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
// Tambahkan import ini untuk memproses gambar
use Intervention\Image\Laravel\Facades\Image; 

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('pages.edit-profile', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'nama'     => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->uuid, 'uuid')],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->uuid, 'uuid')],
            'no_wa'    => 'nullable|string|max:15',
            'alamat'   => 'nullable|string',
            'avatar'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // Max upload awal 5MB (biar kita kompres nanti)
        ]);

        $data = $request->only(['nama', 'username', 'email', 'no_wa', 'alamat']);

        // --- LOGIKA BARU UNTUK UPLOAD & KOMPRES GAMBAR ---
        if ($request->hasFile('avatar')) {
            try {
                // 1. Hapus avatar lama jika ada
                if ($user->avatar) {
                    if (Storage::disk('s3')->exists('avatars/' . $user->avatar)) {
                        Storage::disk('s3')->delete('avatars/' . $user->avatar);
                    }
                }

                $file = $request->file('avatar');
                
                // 2. Buat nama file baru dengan akhiran .webp
                $filename = 'avatar_' . $user->uuid . '_' . time() . '.webp';

                // 3. Baca file gambar menggunakan Intervention Image
                $image = Image::read($file);

                // 4. Resize gambar (Opsional tapi sangat disarankan)
                // Kita atur lebar 500px, tingginya menyesuaikan (aspect ratio tetap)
                // Ini menjamin ukuran file pasti KECIL (< 200kb)
                $image->scale(width: 500);

                // 5. Encode ke format WebP dengan kualitas 75%
                // Kualitas 75% visualnya masih bagus tapi ukurannya turun drastis
                $encoded = $image->toWebp(quality: 75);

                // 6. Upload hasil encode ke MinIO
                // Perhatikan kita pakai 'put', bukan 'putFileAs' karena ini data stream
                Storage::disk('s3')->put('avatars/' . $filename, (string) $encoded);

                // 7. Simpan nama file ke array data untuk update database
                $data['avatar'] = $filename;

            } catch (\Exception $e) {
                // Jika error (misal GD Library belum aktif), kembalikan pesan error
                return back()->withErrors(['avatar' => 'Gagal memproses gambar: ' . $e->getMessage()]);
            }
        }
        // -----------------------------------------------------

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui! Gambar telah dikompres ke WebP.');
    }
}