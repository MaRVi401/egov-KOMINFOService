@extends('layouts.main')

@section('content')
    <div class="p-4 mt-14">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 mb-6">
            <div class="w-full md:w-1/2">
                <form action="{{ route('user-management.index') }}" method="GET" class="flex items-center">
                    <label for="simple-search" class="sr-only">Search</label>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-neutral-500" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="simple-search" value="{{ request('search') }}"
                            class="bg-neutral-primary-soft border border-default text-heading text-sm rounded-base focus:ring-brand-soft focus:border-brand-soft block w-full pl-10 p-2.5"
                            placeholder="Cari nama, username, atau email...">
                    </div>
                </form>
            </div>
            <div
                class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 shrink-0">
                <a href="{{ route('user-management.create') }}"
                    class="flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-base text-sm px-5 py-2.5 transition-all">
                    <svg class="h-4 w-4 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                    Tambah User
                </a>
            </div>
        </div>

        @if (session('success'))
            <div id="alert-3"
                class="flex items-center p-4 mb-6 text-green-800 rounded-base bg-green-50 border border-green-200"
                role="alert">
                <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <div class="ms-3 text-sm font-medium">{{ session('success') }}</div>
                <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8"
                    data-dismiss-target="#alert-3" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif

        <div class="relative overflow-hidden bg-neutral-primary-soft shadow-xs rounded-base border border-default">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-body">
                    <thead class="text-xs text-body uppercase bg-neutral-secondary-medium border-b border-default-medium">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold">Detail Pengguna</th>
                            <th scope="col" class="px-6 py-4 font-bold">Username</th>
                            <th scope="col" class="px-6 py-4 font-bold">Role</th>
                            <th scope="col" class="px-6 py-4 font-bold">NIP</th>
                            <th scope="col" class="px-6 py-4 text-right font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-default">
                        @forelse($users as $user)
                            <tr class="bg-neutral-primary-soft hover:bg-neutral-secondary-medium transition-colors">
                                <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        @if ($user->avatar)
                                            <img class="w-10 h-10 rounded-full object-cover border border-default"
                                                src="{{ Storage::url($user->avatar) }}" alt="{{ $user->nama }}">
                                        @else
                                            <div
                                                class="w-10 h-10 rounded-full bg-brand-soft text-fg-brand flex items-center justify-center font-bold border border-brand-soft">
                                                {{ strtoupper(substr($user->nama, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="flex flex-col">
                                            <span class="text-heading font-semibold text-sm">{{ $user->nama }}</span>
                                            <span class="text-xs text-neutral-500 font-normal">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </th>
                                <td class="px-6 py-4 font-mono text-xs text-neutral-600">{{ $user->username }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $user->role == 'super_admin' ? 'bg-red-100 text-red-800 border border-red-200' : 'bg-blue-100 text-blue-800 border border-blue-200' }}">
                                        {{ Str::headline($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @php $roleRel = Str::camel($user->role); @endphp
                                    <span
                                        class="text-sm text-heading font-medium">{{ $user->$roleRel ? $user->$roleRel->nip : '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-4">
                                        <a href="{{ route('user-management.edit', $user->uuid) }}"
                                            class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline">
                                            Edit
                                        </a>

                                        <form id="delete-form-{{ $user->uuid }}"
                                            action="{{ route('user-management.destroy', $user->uuid) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                onclick="confirmDelete('{{ $user->uuid }}', '{{ $user->nama }}')"
                                                class="text-sm font-medium text-red-600 hover:text-red-800 hover:underline">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-neutral-500 font-medium">
                                    Tidak ada data pengguna yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $users->appends(['search' => request('search')])->links() }}
        </div>
    </div>
    @push('scripts')
        @vite('resources/js/user-management.js')
    @endpush
@endsection
