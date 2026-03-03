@extends('layouts.main')

@section('title', 'Detail Pengajuan Tiket')

@section('content')
<div class="p-4 mt-14">
    <hr class="mb-6 border-gray-200 dark:border-gray-700">

    <div class="max-w-4xl mx-auto">
        @php
            $namaLayanan = strtolower($ticket->layanan->nama ?? '');
            $isPengaduan = in_array($namaLayanan, ['pengaduan', 'pengaduan sistem', 'pengaduan sistem electronic']);
        @endphp

        <div class="mb-6 flex justify-between items-center bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Tiket #{{ $ticket->no_tiket }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Layanan: <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $ticket->layanan->nama ?? 'Tidak Diketahui' }}</span></p>
            </div>
            <div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold border 
                    {{ $ticket->status == 'diajukan' ? 'bg-gray-100 text-gray-800 border-gray-200' : 
                      ($ticket->status == 'ditangani' ? 'bg-blue-100 text-blue-800 border-blue-200' : 
                      ($ticket->status == 'selesai' ? 'bg-green-100 text-green-800 border-green-200' : 'bg-red-100 text-red-800 border-red-200')) }}">
                    Status: {{ Str::ucfirst($ticket->status) }}
                </span>
            </div>
        </div>

        @if(!$isPengaduan)
            @if(($ticket->status == 'belum diajukan' && empty($ticket->lampiran)) || $ticket->status == 'ditolak')
                
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-8 text-center">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Unggah Dokumen Tindak Lanjut</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Unggah dokumen persuratan yang telah ditandatangani dan dicap basah di bawah ini.</p>

                    @if($ticket->status == 'ditolak')
                    <div class="mb-6 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">Perhatian!</span> Pengajuan ini sebelumnya ditolak. Silakan periksa kembali dan unggah ulang dokumen perbaikan.
                    </div>
                    @endif

                    <div class="flex flex-col justify-center items-center gap-6">
                        <div class="w-full max-w-md text-center">
                            <form action="{{ route('submission.upload', $ticket->uuid) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
                                @csrf
                                
                                <div class="text-left w-full">
                                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 p-2" 
                                           id="file_surat" name="file_surat" type="file" accept="image/jpeg,image/png,image/jpg" required onchange="previewUpload(this)">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format Gambar PNG, JPEG, JPG (Maksimal 2MB)</p>
                                </div>

                                <button type="submit" class="inline-flex items-center justify-center w-full px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition-all shadow-sm">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    Upload Dokumen
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div id="file-preview-container" class="mt-6 flex justify-center"></div>
                </div>

            @else
                <div class="bg-green-50 dark:bg-green-900/20 p-6 rounded-xl shadow-sm border border-green-200 dark:border-green-800/50 mb-8 text-center flex flex-col items-center justify-center">
                    <svg class="w-12 h-12 text-green-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-lg font-bold text-green-800 dark:text-green-400 mb-1">Dokumen Telah Diunggah</h3>
                    <p class="text-sm text-green-700 dark:text-green-500 mb-4">Dokumen tindak lanjut untuk tiket ini sudah berhasil diterima oleh sistem.</p>
                </div>
            @endif
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-8">
            <div class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 p-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Detail Formulir Pengajuan</h3>
            </div>
            
            <div class="p-6">
                @if(in_array($namaLayanan, ['email gov', 'email e-gov']))
                    @include('pages.pengguna-asn.submission.partials._detail_email_gov')
                @elseif($namaLayanan == 'subdomain')
                    @include('pages.pengguna-asn.submission.partials._detail_subdomain')
                @elseif(in_array($namaLayanan, ['pembuatan aplikasi', 'pembuatan & pengembangan apps']))
                    @include('pages.pengguna-asn.submission.partials._detail_pembuatan_apps')
                @elseif($isPengaduan)
                    @include('pages.pengguna-asn.submission.partials._detail_pengaduan')
                @else
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        Detail form untuk layanan ini tidak tersedia atau sedang dikembangkan.
                    </div>
                @endif
            </div>
        </div>

        @if(!$isPengaduan)
            @if(($ticket->status == 'belum diajukan' && empty($ticket->lampiran)) || $ticket->status == 'ditolak')
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-8 text-center">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Unduh Dokumen Sistem</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Anda dapat mengunduh ulang dokumen persuratan (DOCX) yang telah di-generate oleh sistem melalui tombol di bawah ini.</p>
                @php
                    $downloadUrl = '#';
                    if (in_array($namaLayanan, ['email gov', 'email e-gov'])) {
                        $downloadUrl = url('services/email-gov/download/' . $ticket->uuid); 
                    } elseif ($namaLayanan == 'subdomain') {
                        $downloadUrl = url('services/subdomain/download/' . $ticket->uuid);
                    } elseif (in_array($namaLayanan, ['pembuatan aplikasi', 'pembuatan & pengembangan apps'])) {
                        $downloadUrl = url('services/apps-creation/download/' . $ticket->uuid);
                    }
                @endphp
                <div class="flex justify-center items-center">
                    <div class="w-full sm:w-auto">
                        <a href="{{ $downloadUrl }}" class="inline-flex items-center justify-center w-full px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition-all shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Download Ulang DOCX
                        </a>
                    </div>
                </div>
            </div>
            @endif
        @endif

    </div>
</div>

@push('scripts')
    @vite('resources/js/submission.js')
@endpush
@endsection