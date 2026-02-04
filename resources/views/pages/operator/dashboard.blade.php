<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-md text-center">
        <h1 class="text-2xl font-bold mb-4">
            Selamat Datang 👋
        </h1>

        <p class="text-gray-700 mb-2">
            <strong>Nama:</strong> {{ auth()->user()->nama }}
        </p>

        <p class="text-gray-700 mb-6">
            <strong>Role:</strong>
            <span class="px-2 py-1 rounded bg-blue-100 text-blue-700 text-sm">
                {{ auth()->user()->role }}
            </span>
        </p>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg">
                Logout
            </button>
        </form>
    </div>

</body>
</html>
