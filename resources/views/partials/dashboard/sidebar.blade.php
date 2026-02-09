{{-- SIDEBAR --}}
<aside id="top-bar-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-full pt-20 transition-transform -translate-x-full bg-neutral-primary-soft border-e border-default dark:border-default-medium sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto">
        <ul class="space-y-2 font-medium">

            {{-- MENU DASHBOARD --}}
            <li>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center p-2 rounded-base group {{ request()->routeIs('dashboard') ? 'bg-neutral-secondary-medium text-heading' : 'text-body hover:bg-neutral-secondary-medium hover:text-heading' }}">

                    {{-- Icon Dashboard --}}
                    <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('dashboard') ? 'text-heading' : 'text-neutral-tertiary-medium group-hover:text-heading' }}"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
                    </svg>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>

            {{-- MENU PERMOHONAN --}}
            <li>
                <a href="#"
                    class="flex items-center p-2 rounded-base group {{ request()->routeIs('permohonan') ? 'bg-neutral-secondary-medium text-heading' : 'text-body hover:bg-neutral-secondary-medium hover:text-heading' }}">

                    {{-- Icon Permohonan --}}
                    <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('permohonan') ? 'text-heading' : 'text-neutral-tertiary-medium group-hover:text-heading' }}"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                        <path fill-rule="evenodd"
                            d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="ms-3">Permohonan</span>
                </a>
            </li>

        </ul>
    </div>
</aside>
