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
                        <span class="block md:inline text-transparent bg-clip-text bg-linear-to-r from-blue-600 to-cyan-500 uppercase">
                            {{ auth()->user()->nama ?? 'Bapak/Ibu Kabid' }}
                        </span>
                    </h2>
                    <p class="mt-1 text-xs md:text-sm text-gray-500 dark:text-gray-400 font-medium">
                        Dashboard Monitoring Services KOMINFO Subang
                    </p>
                </div>

                <div class="flex items-center justify-center md:justify-end space-x-3 md:space-x-4 bg-gray-50 dark:bg-gray-800/50 px-4 py-2 md:px-5 md:py-2.5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm transition-all">
                    <div class="flex flex-col items-center md:items-end border-r border-gray-300 dark:border-gray-600 pr-3 md:pr-4">
                        <span id="realtime-clock" class="text-lg md:text-xl font-black font-mono text-blue-600 dark:text-blue-400 leading-none">
                            00:00:00
                        </span>
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

            <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Layanan Aktif</p>
                    <span class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </span>
                </div>
                <h5 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $layananAktif }}</h5>
            </div>

            <div class="p-5 bg-yellow-50 border border-yellow-200 rounded-lg shadow-sm dark:bg-yellow-900/10 dark:border-yellow-900/30">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-yellow-600 dark:text-yellow-400">Tingkat Penyelesaian</p>
                    <span class="p-2 bg-yellow-100 dark:bg-yellow-900/40 rounded-lg">
                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </span>
                </div>
                <h5 class="text-3xl font-bold text-yellow-900 dark:text-yellow-100">{{ $tingkatPenyelesaian }}%</h5>
            </div>

            <div class="p-5 bg-green-50 border border-green-200 rounded-lg shadow-sm dark:bg-green-900/10 dark:border-green-900/30">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-green-600 dark:text-green-400">Total Tiket Selesai</p>
                    <span class="p-2 bg-green-100 dark:bg-green-900/40 rounded-lg">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <h5 class="text-3xl font-bold text-green-900 dark:text-green-100">{{ $stats['selesai'] }}</h5>
            </div>

            <div class="p-5 bg-orange-50 border border-orange-200 rounded-lg shadow-sm dark:bg-orange-900/10 dark:border-orange-900/30">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-orange-600 dark:text-orange-400">Sedang Ditangani</p>
                    <span class="p-2 bg-orange-100 dark:bg-orange-900/40 rounded-lg">
                        <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <h5 class="text-3xl font-bold text-orange-900 dark:text-orange-100">{{ $stats['proses'] }}</h5>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/30 dark:bg-gray-700/30 flex justify-between items-center">
                    <h3 class="font-bold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-5 h-5 me-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Produktivitas Operator
                    </h3>
                    <span class="text-xs font-medium px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                        {{ $operatorPerformance->count() }} Operator
                    </span>
                </div>

                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50/50 dark:bg-gray-700/50 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3 font-semibold">Nama Operator</th>
                                <th class="px-6 py-3 font-semibold text-center">Tiket Ditangani</th>
                                <th class="px-6 py-3 font-semibold text-right">Progress Beban Kerja</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($operatorPerformance as $op)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-all duration-200">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="shrink-0 w-9 h-9 rounded-full bg-linear-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-xs font-bold text-white shadow-sm">
                                                {{ strtoupper(substr($op->nama, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="text-gray-900 dark:text-white font-bold">{{ $op->nama }}</div>
                                                <div class="text-[10px] text-gray-500 dark:text-gray-400">{{ $op->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="font-mono font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 px-3 py-1 rounded-full border border-blue-100 dark:border-blue-800">
                                            {{ $op->total_handle }} Tiket
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $percent = $stats['total'] > 0 ? ($op->total_handle / $stats['total']) * 100 : 0;
                                        @endphp
                                        <div class="flex items-center justify-end gap-3">
                                            <span class="text-xs font-bold text-gray-700 dark:text-gray-300">{{ round($percent) }}%</span>
                                            <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                                <div class="bg-blue-600 dark:bg-blue-500 h-1.5 rounded-full" style="width: {{ $percent }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-200 dark:text-gray-700 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            <p class="text-gray-400 dark:text-gray-500 italic">Belum ada data aktivitas operator.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700 p-5 flex flex-col items-center">
                <h3 class="w-full font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-700 pb-3 flex items-center">
                    <svg class="w-5 h-5 me-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                    </svg>
                    Status Layanan Masuk
                </h3>

                <div class="w-full max-w-[220px] aspect-square mb-6 relative">
                    <canvas id="ticketDonutChart"></canvas>
                </div>

                <div class="w-full space-y-3 mt-auto">
                    @foreach($chartData['labels'] as $index => $label)
                    <div class="flex items-center justify-between text-xs font-bold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 px-3 py-2 rounded-lg">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full shadow-sm" style="background-color: {{ ['#3b82f6', '#f59e0b', '#10b981', '#ef4444'][$index] }}"></span>
                            {{ $label }}
                        </div>
                        <span class="text-gray-900 dark:text-white font-mono">{{ $chartData['data'][$index] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Skrip untuk Real-time Clock
                function updateClock() {
                    const now = new Date();
                    const hours = String(now.getHours()).padStart(2, '0');
                    const minutes = String(now.getMinutes()).padStart(2, '0');
                    const seconds = String(now.getSeconds()).padStart(2, '0');
                    const clockElement = document.getElementById('realtime-clock');
                    if(clockElement) {
                        clockElement.textContent = `${hours}:${minutes}:${seconds}`;
                    }
                }
                setInterval(updateClock, 1000);
                updateClock();

                // Skrip untuk Chart.js (Doughnut Chart)
                const chartElement = document.getElementById('ticketDonutChart');
                if(chartElement) {
                    const ctx = chartElement.getContext('2d');
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: @json($chartData['labels']),
                            datasets: [{
                                data: @json($chartData['data']),
                                backgroundColor: ['#3b82f6', '#f59e0b', '#10b981', '#ef4444'],
                                borderWidth: 0,
                                hoverOffset: 8
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            cutout: '75%',
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: 'rgba(17, 24, 39, 0.9)',
                                    titleColor: '#fff',
                                    bodyColor: '#fff',
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.label || '';
                                            if (label) { label += ': '; }
                                            if (context.parsed !== null) { label += context.parsed + ' Tiket'; }
                                            return label;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
