@extends('layouts.app')

@section('title', 'E-Gov Kominfo - Portal Layanan Digital')

@section('content')
    <section id="beranda" class="flex items-center justify-center py-20 lg:py-32 scroll-mt-20">
        <div class="grid max-w-7xl px-4 mx-auto lg:gap-8 xl:gap-0 lg:grid-cols-12 items-center">
            <div class="mr-auto place-self-center lg:col-span-7 text-center lg:text-left">
                <h1
                    class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl uppercase text-gray-900 dark:text-white">
                    Portal Layanan Digital Diskominfo
                </h1>
                <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">
                    Akses mudah dan cepat untuk berbagai layanan sistem elektronik pemerintah daerah dalam satu platform
                    terintegrasi.
                </p>
            </div>
            <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
                <img src="{{ asset('assets/images/landingPages/logo-jumbotron.svg') }}" alt="Illustration"
                    class="w-full h-auto">
            </div>
        </div>
    </section>

    <hr class="border-gray-200 dark:border-gray-800">

    <section id="layanan" class="py-20 bg-gray-50 dark:bg-gray-800/50 scroll-mt-20">
        <div class="max-w-7xl px-4 mx-auto text-center">
            <h2 class="mb-4 text-3xl font-bold text-gray-900 dark:text-white">Layanan Kami</h2>
            <p class="mb-12 text-gray-500 dark:text-gray-400">Daftar layanan publik dan internal yang tersedia.</p>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

                <div
                    class="bg-white dark:bg-gray-900 flex flex-col border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm overflow-hidden transition-all hover:shadow-md">
                    <div
                        class="p-6 bg-gray-50 dark:bg-gray-800/50 flex justify-center items-center aspect-square overflow-hidden">
                        <img class="w-full h-full object-contain transform transition-transform hover:scale-110"
                            src="{{ asset('assets/images/landingPages/logo-kabSubang.webp') }}" alt="E-Filling" />
                    </div>
                    <div class="p-6 text-center flex flex-col grow">
                        <div>
                            <span
                                class="inline-flex items-center bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-semibold px-2.5 py-1 rounded-full mb-4">
                                <svg class="w-3 h-3 me-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                Populer
                            </span>
                        </div>
                        <h5 class="mb-3 text-xl font-bold tracking-tight text-gray-900 dark:text-white">Email Government
                        </h5>
                        <p class="mb-6 text-sm text-gray-500 dark:text-gray-400 grow">Layanan Email Gov.</p>
                        <a href="#"
                            class="inline-flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-all">
                            Buka Layanan
                            <svg class="w-4 h-4 ms-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 12H5m14 0-4 4m4-4-4-4" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-900 flex flex-col border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm overflow-hidden transition-all hover:shadow-md">
                    <div
                        class="p-6 bg-gray-50 dark:bg-gray-800/50 flex justify-center items-center aspect-square overflow-hidden">
                        <img class="w-full h-full object-contain transform transition-transform hover:scale-110"
                            src="{{ asset('assets/images/landingPages/logo-kabSubang.webp') }}" alt="E-Licensing" />
                    </div>
                    <div class="p-6 text-center flex flex-col grow">
                        <div>
                            <span
                                class="inline-flex items-center bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-semibold px-2.5 py-1 rounded-full mb-4">
                                Layanan Publik
                            </span>
                        </div>
                        <h5 class="mb-3 text-xl font-bold tracking-tight text-gray-900 dark:text-white">Subdomain</h5>
                        <p class="mb-6 text-sm text-gray-500 dark:text-gray-400 grow">Layanan Subdomain.</p>
                        <a href="#"
                            class="inline-flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-all">
                            Buka Layanan
                            <svg class="w-4 h-4 ms-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 12H5m14 0-4 4m4-4-4-4" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-900 flex flex-col border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm overflow-hidden transition-all hover:shadow-md">
                    <div
                        class="p-6 bg-gray-50 dark:bg-gray-800/50 flex justify-center items-center aspect-square overflow-hidden">
                        <img class="w-full h-full object-contain transform transition-transform hover:scale-110"
                            src="{{ asset('assets/images/landingPages/logo-kabSubang.webp') }}" alt="E-Planning" />
                    </div>
                    <div class="p-6 text-center flex flex-col grow">
                        <div>
                            <span
                                class="inline-flex items-center bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 text-xs font-semibold px-2.5 py-1 rounded-full mb-4">
                                Internal
                            </span>
                        </div>
                        <h5 class="mb-3 text-xl font-bold tracking-tight text-gray-900 dark:text-white">Pengembangan Apps
                        </h5>
                        <p class="mb-6 text-sm text-gray-500 dark:text-gray-400 grow">Layanan Pengembangan Aplikasi.</p>
                        <a href="#"
                            class="inline-flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-all">
                            Buka Layanan
                            <svg class="w-4 h-4 ms-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 12H5m14 0-4 4m4-4-4-4" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-900 flex flex-col border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm overflow-hidden transition-all hover:shadow-md">
                    <div
                        class="p-6 bg-gray-50 dark:bg-gray-800/50 flex justify-center items-center aspect-square overflow-hidden">
                        <img class="w-full h-full object-contain transform transition-transform hover:scale-110"
                            src="{{ asset('assets/images/landingPages/logo-kabSubang.webp') }}" alt="Open Data" />
                    </div>
                    <div class="p-6 text-center flex flex-col grow">
                        <div>
                            <span
                                class="inline-flex items-center bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 text-xs font-semibold px-2.5 py-1 rounded-full mb-4">
                                Informasi
                            </span>
                        </div>
                        <h5 class="mb-3 text-xl font-bold tracking-tight text-gray-900 dark:text-white">Pengaduan SE</h5>
                        <p class="mb-6 text-sm text-gray-500 dark:text-gray-400 grow">Layanan Pengaduan Sistem Elektronik.
                        </p>
                        <a href="#"
                            class="inline-flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-all">
                            Buka Layanan
                            <svg class="w-4 h-4 ms-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 12H5m14 0-4 4m4-4-4-4" />
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="informasi" class="py-20 scroll-mt-20">
        <div class="max-w-7xl px-4 mx-auto">
            <div class="text-center mb-12">
                <h2 class="mb-4 text-3xl font-bold text-gray-900 dark:text-white">Pusat Informasi</h2>
                <p class="text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">Dapatkan berita, artikel, dan pengumuman
                    terbaru seputar transformasi digital di lingkungan pemerintah daerah.</p>
            </div>

            <div class="grid gap-8 lg:grid-cols-3">

                <article
                    class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow duration-300">
                    <div class="relative">
                        <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/article/blog-1.png"
                            class="w-full h-52 object-cover" alt="Berita 1">
                        <span
                            class="absolute top-4 left-4 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase">Berita</span>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3 text-sm text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span>05 Feb 2026</span>
                        </div>
                        <h3 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white hover:text-blue-600">
                            <a href="#">Implementasi Tanda Tangan Elektronik di Seluruh OPD</a>
                        </h3>
                        <p class="mb-4 text-gray-500 dark:text-gray-400 line-clamp-2">Upaya percepatan digitalisasi
                            birokrasi kini memasuki tahap integrasi sistem tanda tangan elektronik terpadu.</p>
                        <a href="#" class="inline-flex items-center font-medium text-blue-600 hover:underline">
                            Selengkapnya
                            <svg class="w-4 h-4 ms-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </article>

                <article
                    class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow duration-300">
                    <div class="relative">
                        <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/article/blog-2.png"
                            class="w-full h-52 object-cover" alt="Berita 2">
                        <span
                            class="absolute top-4 left-4 bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase">Pengumuman</span>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3 text-sm text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span>03 Feb 2026</span>
                        </div>
                        <h3 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white hover:text-blue-600">
                            <a href="#">Pemeliharaan Rutin Server Pusat Data Nasional</a>
                        </h3>
                        <p class="mb-4 text-gray-500 dark:text-gray-400 line-clamp-2">Informasi mengenai jadwal maintenance
                            server yang akan berdampak pada beberapa layanan publik digital sementara waktu.</p>
                        <a href="#" class="inline-flex items-center font-medium text-blue-600 hover:underline">
                            Selengkapnya
                            <svg class="w-4 h-4 ms-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </article>

                <article
                    class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow duration-300">
                    <div class="relative">
                        <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/article/blog-3.png"
                            class="w-full h-52 object-cover" alt="Berita 3">
                        <span
                            class="absolute top-4 left-4 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase">E-Gov</span>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3 text-sm text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span>01 Feb 2026</span>
                        </div>
                        <h3 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white hover:text-blue-600">
                            <a href="#">Pencapaian Indeks SPBE Kabupaten Tahun 2025</a>
                        </h3>
                        <p class="mb-4 text-gray-500 dark:text-gray-400 line-clamp-2">Skor Indeks Sistem Pemerintahan
                            Berbasis Elektronik (SPBE) mengalami kenaikan signifikan tahun ini.</p>
                        <a href="#" class="inline-flex items-center font-medium text-blue-600 hover:underline">
                            Selengkapnya
                            <svg class="w-4 h-4 ms-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </article>

            </div>

            <div class="mt-12 text-center">
                <a href="#"
                    class="inline-flex items-center px-6 py-3 text-base font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 8">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7 7.674 1.3a.91.91 0 0 0-1.348 0L1 7" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
@endsection
