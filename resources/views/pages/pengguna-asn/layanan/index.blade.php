@extends('layouts.main') {{-- Sesuaikan dengan nama file layout master Anda --}}

@section('title', 'Daftar Layanan')

@section('content')
<div class="grid grid-cols-1 gap-4 mb-4">
    
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Layanan Digital</h2>
            <p class="text-gray-600 dark:text-gray-400">Pilih layanan yang Anda butuhkan di bawah ini.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 transition-all duration-200 group">
            <div class="w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-900 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <i class="ti ti-mail text-2xl text-blue-600 dark:text-blue-300"></i>
            </div>
            <a href="#">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Email E-Gov</h5>
            </a>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 text-sm">
                Layanan pembuatan dan pengelolaan email resmi pemerintahan untuk korespondensi kedinasan.
            </p>
            <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Akses Layanan
                <i class="ti ti-arrow-right ml-2"></i>
            </a>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 transition-all duration-200 group">
            <div class="w-12 h-12 rounded-lg bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <i class="ti ti-world-www text-2xl text-emerald-600 dark:text-emerald-300"></i>
            </div>
            <a href="#">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Subdomain</h5>
            </a>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 text-sm">
                Pengajuan subdomain resmi daerah untuk website instansi atau unit kerja pemerintah.
            </p>
            <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-emerald-700 rounded-lg hover:bg-emerald-800 focus:ring-4 focus:outline-none focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800">
                Akses Layanan
                <i class="ti ti-arrow-right ml-2"></i>
            </a>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 transition-all duration-200 group">
            <div class="w-12 h-12 rounded-lg bg-purple-100 dark:bg-purple-900 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <i class="ti ti-device-mobile-code text-2xl text-purple-600 dark:text-purple-300"></i>
            </div>
            <a href="#">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Pembuatan App</h5>
            </a>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 text-sm">
                Fasilitasi pengembangan aplikasi sistem informasi berbasis web maupun mobile.
            </p>
            <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-purple-700 rounded-lg hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                Akses Layanan
                <i class="ti ti-arrow-right ml-2"></i>
            </a>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 transition-all duration-200 group">
            <div class="w-12 h-12 rounded-lg bg-rose-100 dark:bg-rose-900 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <i class="ti ti-bug text-2xl text-rose-600 dark:text-rose-300"></i>
            </div>
            <a href="#">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Pengaduan Sistem</h5>
            </a>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 text-sm">
                Pelaporan kendala teknis, bug, atau error pada sistem elektronik yang sedang berjalan.
            </p>
            <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-rose-700 rounded-lg hover:bg-rose-800 focus:ring-4 focus:outline-none focus:ring-rose-300 dark:bg-rose-600 dark:hover:bg-rose-700 dark:focus:ring-rose-800">
                Akses Layanan
                <i class="ti ti-arrow-right ml-2"></i>
            </a>
        </div>

    </div>
</div>
@endsection