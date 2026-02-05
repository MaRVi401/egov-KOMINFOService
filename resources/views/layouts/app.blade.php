<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'E-Gov Kominfo')</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/images/landingPages/logo-kabSubang.webp') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>

<body class="flex flex-col min-h-screen bg-white dark:bg-gray-900 antialiased text-gray-900 dark:text-white">

    @include('partials.navbar')

    <main class="grow">
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    @stack('scripts')
</body>

</html>
