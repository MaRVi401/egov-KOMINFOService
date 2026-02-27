<div class="space-y-6">
    <div>
        <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Detail Pengaduan / Kronologi</label>
        <div class="p-4 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white min-h-[150px] whitespace-pre-line">
            {{ $ticket->detailPengaduan->detail_pengaduan ?? 'Tidak ada detail deskripsi.' }}
        </div>
    </div>

    <div>
        <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Lampiran Screenshot Kejadian</label>
        @if(!empty($ticket->detailPengaduan->lampiran_screenshot))
            <div class="mt-2">
                <a href="{{ Storage::disk('s3')->temporaryUrl($ticket->detailPengaduan->lampiran_screenshot, now()->addMinutes(60)) }}" target="_blank" class="group relative block max-w-md overflow-hidden rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm hover:shadow-md transition-shadow">
                    <img src="{{ Storage::disk('s3')->temporaryUrl($ticket->detailPengaduan->lampiran_screenshot, now()->addMinutes(60)) }}" 
                         alt="Screenshot Pengaduan" 
                         class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <span class="text-white text-sm font-medium flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Lihat Fullsize
                        </span>
                    </div>
                </a>
            </div>
        @else
            <div class="flex items-center p-4 text-sm text-gray-500 bg-gray-50 rounded-lg border border-dashed border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Tidak ada lampiran.
            </div>
        @endif
    </div>
</div>