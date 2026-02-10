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
use Illuminate\Support\Str;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the users with Search & Pagination.
     */
    public function index(Request $request)
    {
        $query = User::query()->where('uuid', '!=', Auth::id());

        // Search Logic
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                    ->orWhere('username', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
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
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'role'     => 'required|in:super_admin,pengguna_asn,kabid,operator',
            'nip'      => 'required|string|max:50',
            'password' => 'required|min:8|confirmed',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // Upload to Minio (S3 disk)
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 's3');
            }

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

            // Create role specialization entry
            $this->getRoleModel($request->role)::create([
                'uuid'     => (string) Str::uuid(),
                'users_id' => $user->uuid,
                'nip'      => $request->nip,
            ]);

            DB::commit();
            return redirect()->route('user-management.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
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
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->uuid . ',uuid',
            'username' => 'required|string|unique:users,username,' . $user->uuid . ',uuid',
            'role'     => 'required|in:super_admin,pengguna_asn,kabid,operator',
            'nip'      => 'required|string|max:50',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|min:8|confirmed',
        ]);

        DB::beginTransaction();
        try {
            $oldRole = $user->role;
            $newRole = $request->role;

            $user->nama = $request->nama;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->alamat = $request->alamat;
            $user->no_wa = $request->no_wa;
            $user->role = $newRole;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            if ($request->hasFile('avatar')) {
                // Delete old avatar from Minio
                if ($user->avatar) {
                    Storage::disk('s3')->delete($user->avatar);
                }
                // Store new avatar in Minio
                $user->avatar = $request->file('avatar')->store('avatars', 's3');
            }

            $user->save();

            // Sync role tables
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
            return redirect()->route('user-management.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Update failed: ' . $e->getMessage());
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