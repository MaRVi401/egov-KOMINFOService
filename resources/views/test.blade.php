<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Gov Dashboard | Final Test</title>
    
    {{-- Logic Dark Mode (Cegah Flicker) --}}
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white dark:bg-neutral-primary-soft antialiased transition-colors duration-200">

    {{-- NAVBAR --}}
    <nav class="fixed top-0 z-50 w-full bg-neutral-primary-soft border-b border-default dark:border-default-medium">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    {{-- Toggle Mobile --}}
                    <button data-drawer-target="top-bar-sidebar" data-drawer-toggle="top-bar-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-body rounded-base sm:hidden hover:bg-neutral-secondary-medium focus:outline-none focus:ring-2 focus:ring-neutral-tertiary">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"></path></svg>
                    </button>
                    <a href="#" class="flex ms-2 md:me-24">
                        <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 me-3" alt="Logo" />
                        <span class="self-center text-xl font-bold whitespace-nowrap text-heading">E-Gov Service</span>
                    </a>
                </div>

                <div class="flex items-center gap-2">
                    {{-- Button Toggle Dark Mode --}}
                    <button id="theme-toggle" type="button" class="text-body hover:bg-neutral-secondary-medium focus:outline-none focus:ring-4 focus:ring-neutral-tertiary rounded-lg text-sm p-2.5">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path></svg>
                    </button>

                    {{-- User Dropdown --}}
                    <div class="flex items-center ms-3">
                        <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-neutral-tertiary" data-dropdown-toggle="dropdown-user">
                            <img class="w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name=Ahmad+Yassin" alt="user photo">
                        </button>
                        <div class="z-50 hidden my-4 text-base list-none bg-white dark:bg-neutral-primary-medium divide-y divide-default border border-default dark:border-default-medium rounded-base shadow-lg" id="dropdown-user">
                            <div class="px-4 py-3">
                                <p class="text-sm font-medium text-heading">Ahmad Yassin</p>
                                <p class="text-sm text-body truncate">ahmad.yassin@polindra.ac.id</p>
                            </div>
                            <ul class="py-1">
                                <li><a href="#" class="block px-4 py-2 text-sm text-body hover:bg-neutral-secondary-soft dark:hover:text-heading">Settings</a></li>
                                <li><a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Sign out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- SIDEBAR --}}
    <aside id="top-bar-sidebar" class="fixed top-0 left-0 z-40 w-64 h-full pt-20 transition-transform -translate-x-full bg-neutral-primary-soft border-e border-default dark:border-default-medium sm:translate-x-0" aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="#" class="flex items-center p-2 text-heading bg-neutral-secondary-medium rounded-base group">
                        <svg class="w-5 h-5 transition duration-75" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"/><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"/></svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-body rounded-base hover:bg-neutral-secondary-medium hover:text-heading group">
                        <svg class="w-5 h-5 text-neutral-tertiary-medium group-hover:text-heading" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/></svg>
                        <span class="ms-3">Permohonan</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    {{-- MAIN --}}
    <main class="p-4 sm:ml-64 mt-14">
        <div class="p-4 border-2 border-default border-dashed rounded-base dark:border-default-medium">
            <h2 class="text-2xl font-bold text-heading mb-6">Overview Project Kominfo</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div class="flex flex-col items-center justify-center h-32 rounded-base bg-neutral-secondary-soft border border-default dark:border-default-medium">
                   <p class="text-3xl font-bold text-heading">24</p>
                   <p class="text-sm text-body uppercase tracking-wider">Layanan Aktif</p>
                </div>
                <div class="flex flex-col items-center justify-center h-32 rounded-base bg-neutral-secondary-soft border border-default dark:border-default-medium">
                   <p class="text-3xl font-bold text-heading">3.81</p>
                   <p class="text-sm text-body uppercase tracking-wider">Indeks Kepuasan</p>
                </div>
                <div class="flex flex-col items-center justify-center h-32 rounded-base bg-neutral-secondary-soft border border-default dark:border-default-medium">
                   <p class="text-3xl font-bold text-heading">100%</p>
                   <p class="text-sm text-body uppercase tracking-wider">Uptime Sistem</p>
                </div>
            </div>

            <div class="w-full bg-neutral-primary-medium rounded-base border border-default dark:border-default-medium p-6 h-96 flex items-center justify-center">
                <span class="text-neutral-tertiary-medium italic text-lg text-center">
                    Visualisasi Data Document Scanner YOLOv8 & Pathfinding Visualizer akan tampil di sini.
                </span>
            </div>
        </div>
    </main>

    {{-- Script Logic Dark Mode Toggle --}}
    <script>
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }
        });
    </script>
</body>
</html>