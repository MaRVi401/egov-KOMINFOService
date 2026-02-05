<nav class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-200 dark:border-gray-800">
    <div class="max-w-7xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('assets/images/landingPages/logo-diskominfo.png') }}" class="h-8 hidden md:block" alt="Logo" />
            <span class="self-center text-2xl font-bold whitespace-nowrap">E-Gov Kominfo</span>
        </a>
        <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            @auth
                <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 transition">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-gray-900 dark:text-white border border-gray-200 dark:border-gray-700 hover:bg-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 transition">Login</a>
            @endauth
            <button data-collapse-toggle="navbar-cta" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 17 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/></svg>
            </button>
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-cta">
            <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900">
                <li><a href="#beranda" class="nav-link block py-2 px-3 md:p-0" id="link-beranda">Beranda</a></li>
                <li><a href="#layanan" class="nav-link block py-2 px-3 md:p-0" id="link-layanan">Layanan</a></li>
                <li><a href="#informasi" class="nav-link block py-2 px-3 md:p-0" id="link-informasi">Informasi</a></li>
            </ul>
        </div>
    </div>
</nav>