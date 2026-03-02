@extends('layouts.main')
@section('title', 'Meja Kerja Operator')
@section('content')
    <div class="p-4 mt-14">
        <h2 class="text-2xl font-bold mb-6 dark:text-white">Meja Kerja: Tiket Sedang Ditangani</h2>
        <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-4 font-bold">No Tiket</th>
                            <th class="px-6 py-4 font-bold">Layanan</th>
                            <th class="px-6 py-4 font-bold">Pengaju</th>
                            <th class="px-6 py-4 text-right font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($tickets as $ticket)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 font-mono font-bold text-blue-600 dark:text-blue-400">{{ $ticket->no_tiket }}</td>
                                <td class="px-6 py-4">{{ $ticket->layanan->nama }}</td>
                                <td class="px-6 py-4">{{ $ticket->user->nama }}</td>
                                <td class="px-6 py-4 text-right">
                                    <button data-modal-target="update-modal-{{ $ticket->uuid }}"
                                        data-modal-toggle="update-modal-{{ $ticket->uuid }}"
                                        class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-2 rounded-lg text-xs cursor-pointer transition-all shadow-sm">
                                        Proses Tiket
                                    </button>

                                    <div id="update-modal-{{ $ticket->uuid }}" tabindex="-1" aria-hidden="true"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 border dark:border-gray-700">
                                                <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white text-left">Update Status: {{ $ticket->no_tiket }}</h3>
                                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="update-modal-{{ $ticket->uuid }}">
                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" /></svg>
                                                    </button>
                                                </div>

                                                <form action="{{ route('ticket.update', $ticket->uuid) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="p-6 space-y-4 text-left">
                                                        <div class="grid grid-cols-2 gap-4 mb-2">
                                                            <div>
                                                                <label class="block text-xs text-gray-500 uppercase">Pengaju</label>
                                                                <p class="text-sm font-bold dark:text-white">{{ $ticket->user->nama }}</p>
                                                            </div>
                                                            <div>
                                                                <label class="block text-xs text-gray-500 uppercase">Layanan</label>
                                                                <p class="text-sm font-bold dark:text-white">{{ $ticket->layanan->nama }}</p>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <label class="block text-xs text-gray-500 uppercase">Deskripsi Masalah</label>
                                                            <p class="text-sm dark:text-gray-300">{{ $ticket->deskripsi }}</p>
                                                        </div>

                                                        @if ($ticket->lampiran)
                                                            <div class="mt-2">
                                                                <label class="block text-xs text-gray-500 uppercase mb-1">Lampiran</label>
                                                                <img src="{{ asset('storage/lampiran/' . $ticket->lampiran) }}" class="w-full max-h-48 object-contain rounded border dark:border-gray-600 bg-gray-50 dark:bg-gray-900">
                                                            </div>
                                                        @endif

                                                        <hr class="dark:border-gray-600">

                                                        <div>
                                                            <label class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Pilih Status Akhir</label>
                                                            <select name="status" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white cursor-pointer">
                                                                <option value="selesai">Selesai (Tiket Berhasil Ditangani)</option>
                                                                <option value="ditolak">Tolak (Permohonan Tidak Sesuai)</option>
                                                            </select>
                                                        </div>

                                                        <div>
                                                            <label class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Komentar / Balasan ke Pengguna</label>
                                                            <textarea name="komentar" rows="4" required class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" 
                                                                placeholder="Berikan instruksi langkah selanjutnya jika selesai, atau berikan alasan yang jelas jika tiket ditolak..."></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center p-6 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                        <button type="submit" class="text-white bg-orange-600 hover:bg-orange-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center cursor-pointer transition-all">Simpan Perubahan</button>
                                                        <button data-modal-hide="update-modal-{{ $ticket->uuid }}" type="button" class="ms-3 text-gray-500 bg-white hover:bg-gray-100 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 cursor-pointer">Batal</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400 font-medium">
                                    Meja kerja Anda kosong. Silakan ambil tiket di menu Tiket Masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection