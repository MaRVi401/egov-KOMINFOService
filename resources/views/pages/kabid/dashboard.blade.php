@extends('layouts.master')

@section('title', 'Dashboard Monitoring Kabid')

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
                        Selamat <span id="sapaan-teks">{{ $sapaan }}</span>,
                        <span class="block md:inline text-transparent bg-clip-text bg-linear-to-r from-blue-600 to-cyan-500 uppercase font-black">
                            {{ auth()->user()->nama }}
                        </span>
                    </h2>
                    <p class="mt-1 text-xs md:text-sm text-gray-500 dark:text-gray-400  tracking-wider">
                        Dashboard Monitoring Services KOMINFO Subang
                    </p>
                </div>

                <div class="flex items-center justify-center md:justify-end space-x-3 md:space-x-4 bg-white dark:bg-gray-800 px-4 py-2 md:px-5 md:py-2.5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm transition-all hover:shadow-md">
                    <div class="flex flex-col items-center md:items-end border-r border-gray-200 dark:border-gray-600 pr-3 md:pr-4">
                        <span id="realtime-clock" class="text-lg md:text-xl font-black font-mono text-blue-600 dark:text-blue-400 leading-none">00:00:00</span>
                        <span class="text-[9px] md:text-[10px] uppercase tracking-widest font-bold text-gray-400 mt-1">Waktu Server</span>
                    </div>
                    <div class="flex flex-col text-left">
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

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase text-gray-400 tracking-wider">Total Layanan</p>
                    <i class="ti ti-apps text-blue-500 text-xl"></i>
                </div>
                <h5 class="text-3xl font-black text-gray-900 dark:text-white">{{ $layananAktif }}</h5>
            </div>

            <div class="p-5 bg-yellow-50/50 border border-yellow-100 rounded-xl shadow-sm dark:bg-yellow-900/10 dark:border-yellow-900/20">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase text-yellow-600 dark:text-yellow-400 tracking-wider">Penyelesaian</p>
                    <i class="ti ti-chart-bar text-yellow-500 text-xl"></i>
                </div>
                <h5 class="text-3xl font-black text-yellow-700 dark:text-yellow-100">{{ $tingkatPenyelesaian }}%</h5>
            </div>

            <div class="p-5 bg-green-50/50 border border-green-100 rounded-xl shadow-sm dark:bg-green-900/10 dark:border-green-900/20">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase text-green-600 dark:text-green-400 tracking-wider">Tiket Selesai</p>
                    <i class="ti ti-circle-check text-green-500 text-xl"></i>
                </div>
                <h5 class="text-3xl font-black text-green-700 dark:text-green-100">{{ $stats['selesai'] }}</h5>
            </div>

            <div class="p-5 bg-orange-50/50 border border-orange-100 rounded-xl shadow-sm dark:bg-orange-900/10 dark:border-orange-900/20">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase text-orange-600 dark:text-orange-400 tracking-wider">Diproses</p>
                    <i class="ti ti-loader text-orange-500 text-xl"></i>
                </div>
                <h5 class="text-3xl font-black text-orange-700 dark:text-orange-100">{{ $stats['proses'] }}</h5>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div id="table-container" class="lg:col-span-2 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden flex flex-col min-h-[450px]">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30 flex justify-between items-center text-heading font-bold italic">
                    <h3 class="flex items-center">
                        <i class="ti ti-users text-blue-600 me-2 text-xl"></i> Produktivitas Operator
                    </h3>
                </div>

                <div id="ajax-table-content">
                    @include('pages.kabid._operator_table')
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-gray-800 dark:border-gray-700 p-6 flex flex-col items-center">
                <h3 class="w-full font-bold text-gray-900 dark:text-white mb-8 border-b border-gray-50 dark:border-gray-700 pb-3 flex items-center italic">
                    <i class="ti ti-chart-pie text-orange-500 me-2 text-xl"></i> Status Layanan Masuk
                </h3>

                <div class="w-full max-w-[220px] aspect-square mb-8 relative">
                    <canvas id="ticketDonutChart"></canvas>
                </div>

                <div class="w-full space-y-3 mt-auto">
                    @foreach($chartData['labels'] as $index => $label)
                    <div class="flex items-center justify-between text-xs font-bold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 px-3 py-2.5 rounded-xl border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full shadow-sm" style="background-color: {{ ['#3b82f6', '#f59e0b', '#10b981', '#ef4444'][$index] }}"></span>
                            {{ $label }}
                        </div>
                        <span class="text-gray-900 dark:text-white font-mono text-sm">{{ $chartData['data'][$index] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

{{-- ... kode HTML Anda tetap sama ... --}}

@push('scripts')
    {{-- Ganti asset menjadi @vite untuk mengambil file dari resources --}}
    @vite(['resources/js/dashboard-kabid.js'])

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initDashboard({
                labels: @json($chartData['labels']),
                data: @json($chartData['data'])
            });
        });
    </script>
@endpush
@endsection
