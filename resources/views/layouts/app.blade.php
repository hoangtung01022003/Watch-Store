<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WatchStore') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50">
    <div class="min-h-screen flex flex-col items-center justify-center pt-6 sm:pt-0">
        <div>
            <a href="/">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight cursor-pointer">
                    Watch<span class="text-indigo-600">Store</span>
                </h1>
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white shadow-xl sm:rounded-2xl border border-gray-100">
            @yield('content')
        </div>
    </div>
</body>
</html>
