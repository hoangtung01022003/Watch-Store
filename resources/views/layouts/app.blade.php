<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WatchStore') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700|playfair-display:400,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-serif { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Inter', sans-serif; }
        .bg-luxury-dark { background-color: #1a1e24; }
        .text-luxury-dark { color: #1a1e24; }
        .bg-luxury-gold { background-color: #d4af37; }
        .text-luxury-gold { color: #d4af37; }
        .border-luxury-gold { border-color: #d4af37; }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 bg-[#fbfbfb]">
    <!-- ✅ reviewed -->
    <div class="min-h-screen flex flex-col items-center justify-center pt-6 sm:pt-0">
        <div>
            <a href="/">
                <h1 class="text-4xl font-serif font-bold text-luxury-dark tracking-tight cursor-pointer hover:text-luxury-gold transition-colors duration-300">
                    WatchStore
                </h1>
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-8 px-10 py-10 bg-white shadow-xl border border-gray-100 relative">
            <!-- Decorative corner elements -->
            <div class="absolute top-0 left-0 w-4 h-4 border-t border-l border-luxury-gold"></div>
            <div class="absolute top-0 right-0 w-4 h-4 border-t border-r border-luxury-gold"></div>
            <div class="absolute bottom-0 left-0 w-4 h-4 border-b border-l border-luxury-gold"></div>
            <div class="absolute bottom-0 right-0 w-4 h-4 border-b border-r border-luxury-gold"></div>
            
            @yield('content')
        </div>
        
        <div class="mt-8 text-xs text-gray-400 uppercase tracking-widest text-center">
            &copy; {{ date('Y') }} WatchStore. Premium Collection.
        </div>
    </div>
</body>
</html>
