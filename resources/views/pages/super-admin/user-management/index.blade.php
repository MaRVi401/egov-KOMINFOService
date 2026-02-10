@extends('layouts.main')

@section('title', 'Users Management')

@section('content')
    <div class="p-4 mt-14">
        {{-- Breadcrumb Section --}}
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white transition-colors">
                        <svg class="w-3 h-3 me-2.5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Home
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-500">User
                            Management</span>
                    </div>
                </li>
            </ol>
        </nav>
        <hr class="mb-6 border-gray-200 dark:border-gray-700">

        {{-- Header Section (Search & Add) --}}
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 mb-6">
            <div class="w-full md:w-1/2">
                <form action="{{ route('user-management.index') }}" method="GET" class="flex items-center">
                    <label for="simple-search" class="sr-only">Search</label>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="simple-search" value="{{ request('search') }}"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Cari nama, username, atau email...">
                    </div>
                </form>
            </div>
            <div
                class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 shrink-0">
                <a href="{{ route('user-management.create') }}"
                    class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-all shadow-sm">
                    <svg class="h-4 w-4 mr-2" fill="currentColor" viewbox="0 0 20 20">
                        <path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                    Tambah User
                </a>
            </div>
        </div>

        {{-- Table Section --}}
        <div
            class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold text-gray-900 dark:text-white">Detail Pengguna
                            </th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Username</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Role</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">NIP</th>
                            <th scope="col" class="px-6 py-4 text-right font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($users as $user)
                            <tr
                                class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="flex items-center gap-3">
                                        @if ($user->avatar)
                                            <img class="w-10 h-10 rounded-full object-cover border border-gray-200 dark:border-gray-600"
                                                src="{{ Storage::url($user->avatar) }}" alt="{{ $user->nama }}">
                                        @else
                                            <div
                                                class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300 flex items-center justify-center font-bold border border-blue-200 dark:border-blue-800">
                                                {{ strtoupper(substr($user->nama, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm font-bold text-gray-900 dark:text-white">{{ $user->nama }}</span>
                                            <span
                                                class="text-xs text-gray-500 dark:text-gray-400 font-normal">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </th>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="font-mono text-xs font-medium px-2 py-1 rounded bg-gray-100 text-gray-600 border border-gray-200 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-600">
                                        {{ $user->username }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border
                                        {{ $user->role == 'super_admin'
                                            ? 'bg-red-100 text-red-800 border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800'
                                            : 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800' }}">
                                        {{ Str::headline($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php $roleRel = Str::camel($user->role); @endphp
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $user->$roleRel ? $user->$roleRel->nip : '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('user-management.edit', $user->uuid) }}"
                                            class="px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/40 transition-all">
                                            Edit
                                        </a>
                                        <form id="delete-form-{{ $user->uuid }}"
                                            action="{{ route('user-management.destroy', $user->uuid) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                onclick="confirmDelete('{{ $user->uuid }}', '{{ $user->nama }}')"
                                                class="px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/40 transition-all">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="px-6 py-12 text-center text-gray-500 dark:text-gray-400 italic font-medium">
                                    Tidak ada data pengguna yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination Section --}}
        <div class="mt-6">
            {{ $users->appends(['search' => request('search')])->links() }}
        </div>
    </div>

    @push('scripts')
        @vite('resources/js/user-management.js')
    @endpush
@endsection
