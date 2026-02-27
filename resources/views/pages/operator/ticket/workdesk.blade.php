@extends('layouts.main')
@section('title', 'Meja Kerja Operator')
@section('content')
<div class="p-4 mt-14">
    <h2 class="text-2xl font-bold mb-6 dark:text-white">Meja Kerja: Tiket Sedang Ditangani</h2>
    <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="bg-gray-50 dark:bg-gray-700 text-white uppercase">
                <tr>
                    <th class="px-6 py-3">No Tiket</th>
                    <th class="px-6 py-3">Layanan</th>
                    <th class="px-6 py-3">Pengaju</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                <tr class="border-b dark:border-gray-700">
                    <td class="px-6 py-4 font-mono">{{ $ticket->no_tiket }}</td>
                    <td class="px-6 py-4">{{ $ticket->layanan->nama }}</td>
                    <td class="px-6 py-4">{{ $ticket->user->nama }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('ticket.show', $ticket->uuid) }}" class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm">
                            Proses & Update
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection