@extends('layouts.main')

@section('content')
<div class="p-4 mt-14">
    <div class="mb-6">
        <h3 class="text-xl font-semibold text-heading">Create New User</h3>
        <p class="text-sm text-body">Tambahkan pengguna baru ke dalam sistem.</p>
    </div>

    <div class="bg-neutral-primary-soft border border-default rounded-base shadow-xs p-6">
        <form action="{{ route('user-management.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label class="block mb-2 text-sm font-medium text-heading">Nama Lengkap</label>
                    <input type="text" name="nama" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand-soft focus:border-brand-soft block w-full p-2.5" placeholder="Ahmad Yassin" required>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-heading">Email</label>
                    <input type="email" name="email" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand-soft focus:border-brand-soft block w-full p-2.5" placeholder="name@company.com" required>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-heading">Username</label>
                    <input type="text" name="username" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand-soft focus:border-brand-soft block w-full p-2.5" required>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-heading">NIP</label>
                    <input type="text" name="nip" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand-soft focus:border-brand-soft block w-full p-2.5" required>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-heading">Role</label>
                    <select name="role" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand-soft focus:border-brand-soft block w-full p-2.5">
                        <option value="pengguna_asn">Pengguna ASN</option>
                        <option value="kabid">Kabid</option>
                        <option value="operator">Operator</option>
                        <option value="super_admin">Super Admin</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-heading">Nomor WhatsApp</label>
                    <input type="text" name="no_wa" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand-soft focus:border-brand-soft block w-full p-2.5">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-heading">Password</label>
                    <input type="password" name="password" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand-soft focus:border-brand-soft block w-full p-2.5" required>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-heading">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand-soft focus:border-brand-soft block w-full p-2.5" required>
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-heading">Avatar</label>
                <input type="file" name="avatar" class="block w-full text-sm text-body border border-default-medium rounded-base cursor-pointer bg-neutral-secondary-medium focus:outline-none">
            </div>

            <div class="flex items-center space-x-3">
                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-base text-sm w-full sm:w-auto px-5 py-2.5 text-center">Save User</button>
                <a href="{{ route('user-management.index') }}" class="text-heading bg-neutral-secondary-medium border border-default-medium hover:bg-neutral-tertiary-medium focus:ring-4 focus:outline-none focus:ring-neutral-200 font-medium rounded-base text-sm w-full sm:w-auto px-5 py-2.5 text-center">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection