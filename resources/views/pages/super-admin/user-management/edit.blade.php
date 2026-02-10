@extends('layouts.main')

@section('content')
<div class="p-4 mt-14">
    <div class="mb-6">
        <h3 class="text-xl font-semibold text-heading">Edit User: {{ $user->nama }}</h3>
        <p class="text-sm text-body">Perbarui informasi profil dan hak akses pengguna.</p>
    </div>

    <div class="bg-neutral-primary-soft border border-default rounded-base shadow-xs p-6">
        <form action="{{ route('user-management.update', $user->uuid) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label class="block mb-2 text-sm font-medium text-heading">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ $user->nama }}" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand-soft focus:border-brand-soft block w-full p-2.5" required>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-heading">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand-soft focus:border-brand-soft block w-full p-2.5" required>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-heading">Username</label>
                    <input type="text" name="username" value="{{ $user->username }}" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand-soft focus:border-brand-soft block w-full p-2.5" required>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-heading">NIP</label>
                    <input type="text" name="nip" value="{{ $nip }}" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand-soft focus:border-brand-soft block w-full p-2.5" required>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-heading">Role</label>
                    <select name="role" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand-soft focus:border-brand-soft block w-full p-2.5">
                        <option value="super_admin" {{ $user->role == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                        <option value="pengguna_asn" {{ $user->role == 'pengguna_asn' ? 'selected' : '' }}>Pengguna ASN</option>
                        <option value="kabid" {{ $user->role == 'kabid' ? 'selected' : '' }}>Kabid</option>
                        <option value="operator" {{ $user->role == 'operator' ? 'selected' : '' }}>Operator</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-heading">Nomor WhatsApp</label>
                    <input type="text" name="no_wa" value="{{ $user->no_wa }}" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand-soft focus:border-brand-soft block w-full p-2.5">
                </div>
            </div>

            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-heading">Avatar</label>
                <div class="flex items-center space-x-4">
                    @if($user->avatar)
                        <img class="w-16 h-16 rounded-full border border-default" src="{{ Storage::url($user->avatar) }}" alt="current-avatar">
                    @endif
                    <input type="file" name="avatar" class="block w-full text-sm text-body border border-default-medium rounded-base cursor-pointer bg-neutral-secondary-medium focus:outline-none">
                </div>
            </div>

            <div class="border-t border-default pt-6 mb-6">
                <h4 class="text-md font-medium text-heading mb-4">Ubah Password (Opsional)</h4>
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-heading">Password Baru</label>
                        <input type="password" name="password" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand-soft focus:border-brand-soft block w-full p-2.5">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-heading">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand-soft focus:border-brand-soft block w-full p-2.5">
                    </div>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-base text-sm w-full sm:w-auto px-5 py-2.5 text-center">Update User</button>
                <a href="{{ route('user-management.index') }}" class="text-heading bg-neutral-secondary-medium border border-default-medium hover:bg-neutral-tertiary-medium focus:ring-4 focus:outline-none focus:ring-neutral-200 font-medium rounded-base text-sm w-full sm:w-auto px-5 py-2.5 text-center">Back to List</a>
            </div>
        </form>
    </div>
</div>
@endsection