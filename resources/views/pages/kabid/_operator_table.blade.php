<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs uppercase bg-gray-800 text-cyan-400 border-b border-gray-700">
            <tr>
                <th class="px-6 py-4 font-black tracking-widest">NAMA OPERATOR</th>
                <th class="px-6 py-4 text-center font-black tracking-widest">TIKET DITANGANI</th>
                <th class="px-6 py-4 text-right font-black tracking-widest">PROGRESS</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            @forelse($operatorPerformance as $op)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-all duration-200">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div
                                class="shrink-0 w-9 h-9 rounded-full bg-linear-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-xs font-bold text-white shadow-sm">
                                {{ strtoupper(substr($op->nama, 0, 2)) }}
                            </div>
                            <div>
                                <div class="text-gray-900 dark:text-white font-bold">{{ $op->nama }}</div>
                                <div class="text-[10px] text-gray-500 dark:text-gray-400">{{ $op->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span
                            class="font-mono font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 px-3 py-1 rounded-full border border-blue-100 dark:border-blue-800">
                            {{ $op->total_handle }} Tiket
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        @php $percent = $stats['total'] > 0 ? ($op->total_handle / $stats['total']) * 100 : 0; @endphp
                        <div class="flex items-center justify-end gap-3">
                            <span
                                class="text-xs font-bold text-gray-700 dark:text-gray-300">{{ round($percent) }}%</span>
                            <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                <div class="bg-blue-600 dark:bg-blue-500 h-1.5 rounded-full"
                                    style="width: {{ $percent }}%"></div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-6 py-8 text-center italic text-gray-500">Tidak ada data operator.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700">
    {{ $operatorPerformance->links() }}
</div>
