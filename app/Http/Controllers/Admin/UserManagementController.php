<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SuperAdmin;
use App\Models\PenggunaAsn;
use App\Models\Kabid;
use App\Models\Operator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the users with Search & Pagination.
     */
    public function index(Request $request)
    {
        $query = User::query()->where('uuid', '!=', Auth::id());

        // Filter logic
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Search Logic
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                    ->orWhere('username', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    // Cari di tabel relasi detail (NIP)
                    ->orWhereHas('superAdmin', function ($sq) use ($search) {
                        $sq->where('nip', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('penggunaAsn', function ($sq) use ($search) {
                        $sq->where('nip', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('kabid', function ($sq) use ($search) {
                        $sq->where('nip', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('operator', function ($sq) use ($search) {
                        $sq->where('nip', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Use paginate for Flowbite pagination support
        $users = $query->latest()->paginate(10);

        return view('pages.super-admin.user-management.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('pages.super-admin.user-management.create');
    }

    /**
     * Store a newly created user in Minio (S3).
     */
    public function store(Request $request)
    {
        // 1. Validasi dengan Custom Messages
        $rules = [
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'role'     => 'required|in:super_admin,pengguna_asn,kabid,operator',
            'nip'      => 'required|numeric|digits:18',
            'no_wa'    => 'nullable|numeric|digits_between:10,13',
            'password' => 'required|min:8|confirmed',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        $messages = [
            'avatar.max'   => 'Ukuran foto terlalu besar, maksimal adalah 2MB.',
            'avatar.image' => 'File yang diunggah harus berupa gambar.',
            'avatar.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WebP.',
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'nip.numeric' => 'NIP harus berupa angka.',
            'nip.digits'  => 'NIP harus berjumlah tepat 18 digit.',
            'no_wa.numeric' => 'Nomor WhatsApp harus berupa angka.',
            'no_wa.digits_between' => 'Nomor WhatsApp harus berjumlah antara 10 sampai 13 digit.',
            'username.unique' => 'Username ini sudah digunakan.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];

        $request->validate($rules, $messages);

        DB::beginTransaction();
        try {
            $avatarPath = null;

            // 2. Proses Gambar ke WebP
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = 'avatars/' . Str::random(40) . '.webp';

                $image = Image::read($file)
                    ->scale(width: 500)
                    ->encodeByExtension('webp', quality: 75);

                Storage::disk('s3')->put($filename, (string) $image);
                $avatarPath = $filename;
            }

            // 3. Simpan User Utama
            $user = User::create([
                'nama'     => $request->nama,
                'email'    => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role'     => $request->role,
                'alamat'   => $request->alamat,
                'no_wa'    => $request->no_wa,
                'avatar'   => $avatarPath,
            ]);

            // 4. Simpan Detail Role
            $this->getRoleModel($request->role)::create([
                'uuid'     => (string) Str::uuid(),
                'users_id' => $user->uuid,
                'nip'      => $request->nip,
            ]);

            DB::commit();
            return redirect()->route('user-management.index')->with('success', 'User baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal sistem: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roleRelation = Str::camel($user->role);
        $nip = $user->$roleRelation ? $user->$roleRelation->nip : '';

        return view('pages.super-admin.user-management.edit', compact('user', 'nip'));
    }

    /**
     * Update user data and sync Minio (S3) storage.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->uuid . ',uuid',
            'username' => 'required|string|unique:users,username,' . $user->uuid . ',uuid',
            'role'     => 'required|in:super_admin,pengguna_asn,kabid,operator',
            'nip'      => 'required|numeric|digits:18',
            'no_wa'    => 'nullable|numeric|digits_between:10,13',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'password' => 'nullable|min:8|confirmed',
        ];

        $messages = [
            'avatar.max' => 'Ukuran foto maksimal 2MB.',
            'avatar.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WebP.',
            'email.unique' => 'Alamat email sudah digunakan oleh user lain.',
            'nip.required' => 'NIP wajib diisi untuk sinkronisasi data.',
            'nip.numeric' => 'NIP harus berupa angka.',
            'nip.digits'  => 'NIP harus berjumlah tepat 18 digit.',
            'no_wa.numeric' => 'Nomor WhatsApp harus berupa angka.',
            'no_wa.digits_between' => 'Nomor WhatsApp harus berjumlah antara 10 sampai 13 digit.',
        ];

        $request->validate($rules, $messages);

        DB::beginTransaction();
        try {
            $oldRole = $user->role;
            $newRole = $request->role;

            $user->nama = $request->nama;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->no_wa = $request->no_wa;
            $user->alamat = $request->alamat;
            $user->role = $newRole;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            // 5. Update Gambar & Hapus File Lama
            if ($request->hasFile('avatar')) {
                if ($user->avatar) {
                    Storage::disk('s3')->delete($user->avatar);
                }

                $file = $request->file('avatar');
                $filename = 'avatars/' . Str::random(40) . '.webp';

                $image = Image::read($file)
                    ->scale(width: 500)
                    ->encodeByExtension('webp', quality: 75);

                Storage::disk('s3')->put($filename, (string) $image);
                $user->avatar = $filename;
            }

            $user->save();

            // 6. Sinkronisasi Tabel Role
            if ($oldRole !== $newRole) {
                $this->getRoleModel($oldRole)::where('users_id', $user->uuid)->delete();
                $this->getRoleModel($newRole)::create([
                    'uuid' => (string) Str::uuid(),
                    'users_id' => $user->uuid,
                    'nip' => $request->nip,
                ]);
            } else {
                $this->getRoleModel($newRole)::where('users_id', $user->uuid)->update(['nip' => $request->nip]);
            }

            DB::commit();
            return redirect()->route('user-management.index')->with('success', 'Profil user diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove user and clean up Minio (S3) storage.
     */
    public function destroy(User $user)
    {
        if ($user->uuid === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        // Delete from Minio
        if ($user->avatar) {
            Storage::disk('s3')->delete($user->avatar);
        }

        $user->delete(); // Cascade delete handles detail tables
        return redirect()->route('user-management.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Helper to get Role Model class.
     */
    private function getRoleModel($role)
    {
        return [
            'super_admin'  => SuperAdmin::class,
            'pengguna_asn' => PenggunaAsn::class,
            'kabid'        => Kabid::class,
            'operator'     => Operator::class,
        ][$role];
    }
}
