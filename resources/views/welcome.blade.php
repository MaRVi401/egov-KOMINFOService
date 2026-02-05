@extends('layouts.app')

@section('title', 'E-Gov Kominfo - Portal Layanan Digital')

@section('content')
    <section id="beranda" class="flex items-center justify-center py-20 lg:py-32 scroll-mt-20">
        <div class="grid max-w-7xl px-4 mx-auto lg:gap-8 xl:gap-0 lg:grid-cols-12 items-center">
            <div class="mr-auto place-self-center lg:col-span-7 text-center lg:text-left">
                <h1 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl uppercase">
                    Portal Layanan Digital Diskominfo
                </h1>
                <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">
                    Akses mudah dan cepat untuk berbagai layanan sistem elektronik pemerintah daerah dalam satu platform terintegrasi.
                </p>
            </div>
            <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
                <img src="{{ asset('assets/images/landingPages/logo-jumbotron.svg') }}" alt="Illustration" class="w-full h-auto">
            </div>
        </div>
    </section>

    <hr class="border-gray-200 dark:border-gray-800">

    <section id="layanan" class="py-20 bg-gray-50 dark:bg-gray-800/50 scroll-mt-20">
        <div class="max-w-7xl px-4 mx-auto text-center">
            <h2 class="mb-4 text-3xl font-bold text-gray-900 dark:text-white">Layanan Kami</h2>
            <p class="mb-8 text-gray-500 dark:text-gray-400">Daftar layanan publik dan internal yang tersedia.</p>
            <div class="grid gap-8 md:grid-cols-3">
                <div class="p-6 bg-white rounded-lg border border-gray-200 dark:bg-gray-900 dark:border-gray-700">
                    <h3 class="text-xl font-bold mb-2">E-Filling</h3>
                    <p class="text-gray-500">Pengisian dokumen secara digital.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="informasi" class="py-20 scroll-mt-20">
        <div class="max-w-7xl px-4 mx-auto text-center">
            <h2 class="mb-4 text-3xl font-bold text-gray-900 dark:text-white">Pusat Informasi</h2>
            <p class="text-gray-500 dark:text-gray-400">Dapatkan berita dan pengumuman terbaru seputar E-Gov Kominfo di sini.</p>
        </div>
    </section>
@endsection