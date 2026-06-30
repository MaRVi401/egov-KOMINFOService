@extends('layouts.master')

@section('title', 'Dashboard Eksekutif Kadis')

@section('content')
    <div class="p-4 mt-14">
        <div class="mb-8 border-b border-gray-200 pb-6 dark:border-gray-700">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="text-center md:text-left">
                    <h2 class="text-xl md:text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                        @php
                            $hour = date('H');
                            $sapaan = $hour < 12 ? 'Pagi' : ($hour < 15 ? 'Siang' : ($hour < 18 ? 'Sore' : 'Malam'));
                        @endphp
                        Selamat {{ $sapaan }},
                        <span
                            class="block md:inline text-transparent bg-clip-text bg-linear-to-r from-blue-600 to-cyan-500 uppercase font-black">
                            {{ auth()->user()->nama }}
                        </span>
                    </h2>
                    <p class="mt-1 text-xs md:text-sm text-gray-500 dark:text-gray-400 tracking-wider">
                        Executive Dashboard Monitoring SIMDOKUM
                    </p>
                </div>

                <div class="flex flex-col md:flex-row items-center gap-4">
                    <div
                        class="flex items-center justify-center space-x-3 md:space-x-4 bg-white dark:bg-gray-800 px-4 py-2 md:px-5 md:py-2.5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm transition-all hover:shadow-md">
                        <div class="flex flex-col text-right border-r border-gray-200 dark:border-gray-600 pr-3 md:pr-4">
                            <span class="text-xs md:text-sm font-bold text-gray-700 dark:text-gray-200 leading-none">
                                {{ \Carbon\Carbon::now()->translatedFormat('l') }}
                            </span>
                            <span class="text-[10px] md:text-xs text-gray-500 dark:text-gray-400 mt-1">
                                {{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase text-gray-400 tracking-wider">Total Tiket Sistem</p>
                    <i class="ti ti-ticket text-blue-500 text-xl"></i>
                </div>
                <h5 class="text-3xl font-black text-gray-900 dark:text-white">{{ $totalTiketSistem }}</h5>
            </div>

            <div
                class="p-5 bg-orange-50/50 border border-orange-100 rounded-xl shadow-sm dark:bg-orange-900/10 dark:border-orange-900/20">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase text-orange-600 dark:text-orange-400 tracking-wider">Perlu
                        Persetujuan</p>
                    <i class="ti ti-bell-ringing text-orange-500 text-xl"></i>
                </div>
                <h5 class="text-3xl font-black text-orange-700 dark:text-orange-100">{{ $usulanStats->pending }}</h5>
            </div>

            <div
                class="p-5 bg-green-50/50 border border-green-100 rounded-xl shadow-sm dark:bg-green-900/10 dark:border-green-900/20">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase text-green-600 dark:text-green-400 tracking-wider">Usulan
                        Disetujui</p>
                    <i class="ti ti-check text-green-500 text-xl"></i>
                </div>
                <h5 class="text-3xl font-black text-green-700 dark:text-green-100">{{ $usulanStats->disetujui }}</h5>
            </div>

            <div
                class="p-5 bg-red-50/50 border border-red-100 rounded-xl shadow-sm dark:bg-red-900/10 dark:border-red-900/20">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase text-red-600 dark:text-red-400 tracking-wider">Usulan Ditolak</p>
                    <i class="ti ti-x text-red-500 text-xl"></i>
                </div>
                <h5 class="text-3xl font-black text-red-700 dark:text-red-100">{{ $usulanStats->ditolak }}</h5>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div
                class="lg:col-span-2 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden flex flex-col min-h-112.5">
                <div
                    class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30 flex justify-between items-center text-heading font-bold italic">
                    <h3 class="flex items-center text-gray-900 dark:text-white">
                        <i class="ti ti-clipboard-list text-blue-600 me-2 text-xl"></i> Antrean Usulan Prioritas (Pending)
                    </h3>
                </div>

                <div class="p-0 overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b border-gray-200 dark:border-gray-600">
                            <tr>
                                <th scope="col" class="px-6 py-4">No Tiket</th>
                                <th scope="col" class="px-6 py-4">Layanan</th>
                                <th scope="col" class="px-6 py-4">Pengusul (Kabid)</th>
                                <th scope="col" class="px-6 py-4">Level</th>
                                <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($usulanMasuk as $usulan)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                                        {{ $usulan->tiket->no_tiket ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $usulan->tiket->layanan->nama ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $usulan->pengusul->nama ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($usulan->level_prioritas == 'tinggi')
                                            <span
                                                class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Tinggi</span>
                                        @elseif($usulan->level_prioritas == 'sedang')
                                            <span
                                                class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Sedang</span>
                                        @else
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Rendah</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button type="button" data-uuid="{{ $usulan->uuid }}"
                                            data-notiket="{{ $usulan->tiket->no_tiket ?? '-' }}"
                                            data-layanan="{{ $usulan->tiket->layanan->nama ?? '-' }}"
                                            data-pengusul="{{ $usulan->pengusul->nama ?? '-' }}"
                                            data-catatankabid="{{ $usulan->catatan_kabid ?? '-' }}"
                                            data-deskripsi="{{ $usulan->tiket->deskripsi ?? 'Tidak ada catatan/deskripsi dari operator.' }}"
                                            data-lampiran="{{ !empty($usulan->tiket->lampiran) ? Storage::url($usulan->tiket->lampiran) : '' }}"
                                            data-suratpengantar="{{ !empty($usulan->tiket->surat_pengantar) ? Storage::url($usulan->tiket->surat_pengantar) : '' }}"
                                            onclick="bukaModalReview(this)" class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white
                                                    text-xs font-bold rounded-lg transition-colors shadow-sm">
                                            <i class="ti ti-search me-1"></i> Review
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="ti ti-inbox text-4xl mb-2 text-gray-300 dark:text-gray-600"></i>
                                            <p>Tidak ada usulan prioritas yang menunggu persetujuan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div
                class="bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-gray-800 dark:border-gray-700 p-6 flex flex-col items-center">
                <h3
                    class="w-full font-bold text-gray-900 dark:text-white mb-8 border-b border-gray-50 dark:border-gray-700 pb-3 flex items-center italic">
                    <i class="ti ti-chart-pie text-orange-500 me-2 text-xl"></i> Rasio Persetujuan Usulan
                </h3>

                <div class="w-full max-w-55 aspect-square mb-8 relative">
                    <canvas id="usulanDonutChart" data-labels="{{ json_encode($chartData['labels']) }}"
                        data-values="{{ json_encode($chartData['data']) }}">
                    </canvas>
                </div>

                <div class="w-full space-y-3 mt-auto">
                    @foreach($chartData['labels'] as $index => $label)
                        <div
                            class="flex items-center justify-between text-xs font-bold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 px-3 py-2.5 rounded-xl border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full shadow-sm"
                                    style="background-color: {{ ['#f59e0b', '#10b981', '#ef4444'][$index] }}"></span>
                                {{ $label }}
                            </div>
                            <span
                                class="text-gray-900 dark:text-white font-mono text-sm">{{ $chartData['data'][$index] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div
        class="mt-8 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden flex flex-col">
        <div
            class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30 flex justify-between items-center text-heading font-bold italic">
            <h3 class="flex items-center text-gray-900 dark:text-white">
                <i class="ti ti-history text-blue-600 me-2 text-xl"></i> Riwayat Keputusan Usulan Prioritas
            </h3>
        </div>

        <div class="p-0 overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b border-gray-200 dark:border-gray-600">
                    <tr>
                        <th scope="col" class="px-6 py-4">No Tiket</th>
                        <th scope="col" class="px-6 py-4">Layanan</th>
                        <th scope="col" class="px-6 py-4">Pengusul</th>
                        <th scope="col" class="px-6 py-4">Keputusan</th>
                        <th scope="col" class="px-6 py-4">Catatan Anda</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatUsulan as $riwayat)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                                {{ $riwayat->tiket->no_tiket ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $riwayat->tiket->layanan->nama ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $riwayat->pengusul->nama ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($riwayat->status_persetujuan == 'disetujui')
                                    <span
                                        class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                        <i class="ti ti-check me-1"></i> Disetujui
                                    </span>
                                @elseif($riwayat->status_persetujuan == 'ditolak')
                                    <span
                                        class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                        <i class="ti ti-x me-1"></i> Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs italic">
                                {{ Str::limit($riwayat->catatan_kadis, 60, '...') ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="ti ti-history text-4xl mb-2 text-gray-300 dark:text-gray-600"></i>
                                    <p>Belum ada riwayat keputusan yang Anda buat.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="modalReviewKadis"
        class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm overflow-y-auto h-full w-full  items-center justify-center p-4">
        <div
            class="relative w-full max-w-5xl bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-6 md:p-8 border border-gray-100 dark:border-gray-700 flex flex-col max-h-[90vh]">

            <div class="flex justify-between items-center mb-6 shrink-0 border-b border-gray-100 dark:border-gray-700 pb-4">
                <h3 class="text-xl font-black text-gray-900 dark:text-white flex items-center gap-3">
                    <i class="ti ti-clipboard-check text-blue-600 text-2xl"></i> Review Usulan Prioritas
                </h3>
                <button onclick="tutupModalReview()" type="button"
                    class="text-gray-400 hover:text-red-500 transition-colors">
                    <i class="ti ti-x text-2xl"></i>
                </button>
            </div>

            <form id="formReviewKadis" method="POST" data-action-url="{{ url('usulan/:uuid/update') }}"
                class="flex flex-col overflow-hidden">
                @csrf
                <div
                    class="flex flex-col md:flex-row gap-6 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-gray-200 dark:scrollbar-thumb-gray-600">

                    <div class="w-full md:w-1/2 flex flex-col space-y-4">
                        <h4
                            class="text-sm font-bold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2">
                            Informasi Tiket</h4>

                        <div class="grid grid-cols-2 gap-4">
                            <div
                                class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                                <span class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-1">No
                                    Tiket</span>
                                <span id="rev-notiket" class="text-sm font-black text-gray-900 dark:text-white"></span>
                            </div>
                            <div
                                class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                                <span
                                    class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-1">Kategori
                                    Layanan</span>
                                <span id="rev-layanan" class="text-sm font-bold text-gray-900 dark:text-white"></span>
                            </div>
                        </div>

                        <div
                            class="bg-blue-50/50 dark:bg-blue-900/20 p-4 rounded-xl border border-blue-100 dark:border-blue-800/50">
                            <span
                                class="block text-[10px] font-bold uppercase tracking-widest text-blue-600 dark:text-blue-400 mb-2">Catatan/Alasan
                                Pengusul (Kabid)</span>
                            <p id="rev-catatankabid" class="text-sm text-gray-700 dark:text-gray-300 italic"></p>
                            <div class="mt-2 text-right">
                                <span id="rev-pengusul" class="text-xs font-bold text-blue-800 dark:text-blue-300"></span>
                            </div>
                        </div>

                        <div
                            class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                            <span
                                class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-2">Catatan/Deskripsi
                                Operator</span>
                            <p id="rev-deskripsi" class="text-sm text-gray-700 dark:text-gray-300"></p>
                        </div>

                        <div
                            class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                            <span class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-3">Dokumen
                                Lampiran (S3)</span>

                            <div class="flex flex-col gap-3">
                                <a id="rev-lampiran" href="#" target="_blank"
                                    class="hidden inline-flex items-center justify-center px-4 py-2 bg-white dark:bg-gray-600 border border-gray-200 dark:border-gray-500 rounded-lg text-sm font-bold text-blue-600 hover:text-blue-700 hover:bg-gray-50 dark:text-blue-400 dark:hover:bg-gray-500 transition-colors shadow-sm">
                                    <i class="ti ti-external-link me-2 text-lg"></i> Lampiran Usulan Laporan
                                </a>

                                <a id="rev-suratpengantar" href="#" target="_blank"
                                    class="hidden inline-flex items-center justify-center px-4 py-2 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-lg text-sm font-bold text-blue-700 hover:text-blue-800 hover:bg-blue-100 dark:text-blue-300 dark:hover:bg-blue-800/50 transition-colors shadow-sm">
                                    <i class="ti ti-file-certificate me-2 text-lg"></i> Surat Pengantar Kepala Dinas
                                </a>
                            </div>

                            <p id="rev-nolampiran" class="text-sm text-gray-500 italic hidden mt-1">Tidak ada dokumen
                                lampiran yang tersedia.</p>
                        </div>
                    </div>

                    <div
                        class="w-full md:w-1/2 flex flex-col gap-6 pt-6 md:pt-0 border-t md:border-t-0 md:border-l border-gray-100 dark:border-gray-700 md:pl-6">
                        <h4
                            class="text-sm font-bold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2">
                            Form Keputusan</h4>

                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-3 tracking-widest">Keputusan
                                Persetujuan</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" name="status_persetujuan" value="disetujui" class="peer hidden"
                                        required>
                                    <div
                                        class="text-center p-4 rounded-xl border-2 border-gray-200 dark:border-gray-600 text-gray-500 dark:text-gray-400 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20 peer-checked:border-green-500 peer-checked:text-green-700 dark:peer-checked:text-green-400 transition-all hover:border-green-300 flex flex-col items-center gap-2">
                                        <i class="ti ti-circle-check text-2xl"></i>
                                        <span class="text-sm font-bold uppercase tracking-wide">Disetujui</span>
                                    </div>
                                </label>

                                <label class="cursor-pointer">
                                    <input type="radio" name="status_persetujuan" value="ditolak" class="peer hidden"
                                        required>
                                    <div
                                        class="text-center p-4 rounded-xl border-2 border-gray-200 dark:border-gray-600 text-gray-500 dark:text-gray-400 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/20 peer-checked:border-red-500 peer-checked:text-red-700 dark:peer-checked:text-red-400 transition-all hover:border-red-300 flex flex-col items-center gap-2">
                                        <i class="ti ti-circle-x text-2xl"></i>
                                        <span class="text-sm font-bold uppercase tracking-wide">Ditolak</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="flex-1 flex flex-col">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-3 tracking-widest">Catatan
                                Untuk Kabid / Operator</label>
                            <textarea name="catatan_kadis" rows="5"
                                class="flex-1 w-full bg-gray-50 dark:bg-gray-700/50 border-2 border-gray-100 dark:border-gray-700 text-gray-900 dark:text-white text-sm rounded-2xl p-4 focus:ring-0 focus:border-blue-500 outline-none resize-none transition-colors"
                                placeholder="Tambahkan instruksi, alasan penolakan, atau catatan persetujuan di sini..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-5 mt-5 border-t border-gray-100 dark:border-gray-700 shrink-0">
                    <button type="button" onclick="tutupModalReview()"
                        class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-bold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition">Batal</button>
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition flex items-center gap-2">
                        <i class="ti ti-device-floppy"></i> Simpan Keputusan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/js/dashboard-kadis.js'])
@endpush