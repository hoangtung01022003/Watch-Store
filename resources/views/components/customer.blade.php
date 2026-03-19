<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'WatchStore') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600|playfair-display:400,600,700&display=swap" rel="stylesheet" />

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
            .hover-bg-luxury-gold:hover { background-color: #bfa136; }
        </style>
    </head>
    <body class="font-sans antialiased bg-[#fbfbfb] text-gray-800">
        <div class="min-h-screen flex flex-col">
            <!-- Top Bar -->
            <div class="bg-luxury-dark text-white text-xs text-center py-2 uppercase tracking-widest font-medium">
                Complimentary Shipping on all orders
            </div>

            <!-- Sticky Navbar -->
            <header class="bg-white/95 backdrop-blur-sm shadow-sm relative z-40 sticky top-0 border-b border-gray-100" x-data="{ mobileMenuOpen: false }">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-20 items-center">
                        <!-- Mobile Menu Button -->
                        <div class="flex items-center md:hidden">
                            <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 hover:text-luxury-gold focus:outline-none p-2">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>

                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center justify-center flex-1 md:flex-none md:justify-start">
                            <a href="{{ route('home') ?? url('/') }}" class="text-3xl font-serif font-bold tracking-tight text-luxury-dark hover:text-luxury-gold transition-colors duration-300">
                                WatchStore
                            </a>
                        </div>
                        
                        <!-- Desktop Navigation -->
                        <nav class="hidden md:flex space-x-8 items-center flex-1 justify-center">
                            <a href="{{ route('home') ?? url('/') }}" class="text-sm uppercase tracking-widest font-semibold text-gray-700 hover:text-luxury-gold transition-colors duration-300">Home</a>
                            <a href="{{ route('products.index') ?? '#' }}" class="text-sm uppercase tracking-widest font-semibold text-gray-700 hover:text-luxury-gold transition-colors duration-300">Collection</a>
                            
                            <!-- Categories Dropdown using Alpine -->
                            <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                <button class="text-sm uppercase tracking-widest font-semibold text-gray-700 hover:text-luxury-gold flex items-center transition-colors duration-300 py-4">
                                    Categories
                                    <svg class="ml-1 h-4 w-4 fill-current transition-transform duration-300" :class="{'rotate-180': open}" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                </button>
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 translate-y-1"
                                     class="absolute left-1/2 -translate-x-1/2 mt-0 w-64 pt-2 shadow-xl bg-white border border-gray-100 focus:outline-none z-50">
                                    <div class="py-2">
                                        @foreach(\App\Models\Category::all() as $category)
                                            <a href="{{ route('products.index', ['category' => $category->id]) ?? '#' }}" class="block px-6 py-3 text-sm text-gray-600 hover:bg-gray-50 hover:text-luxury-gold transition-colors duration-200">{{ $category->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Brands Dropdown -->
                            <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                <button class="text-sm uppercase tracking-widest font-semibold text-gray-700 hover:text-luxury-gold flex items-center transition-colors duration-300 py-4">
                                    Brands
                                    <svg class="ml-1 h-4 w-4 fill-current transition-transform duration-300" :class="{'rotate-180': open}" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                </button>
                                <div x-show="open"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 translate-y-1" 
                                     class="absolute left-1/2 -translate-x-1/2 mt-0 w-64 pt-2 shadow-xl bg-white border border-gray-100 focus:outline-none z-50">
                                    <div class="py-2 grid grid-cols-2 gap-1 p-2">
                                        @foreach(\App\Models\Brand::all() as $brand)
                                            <a href="{{ route('products.index', ['brand' => $brand->id]) ?? '#' }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-luxury-gold transition-colors duration-200">{{ $brand->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </nav>

                        <!-- Right Actions -->
                        <div class="flex items-center space-x-6 text-sm font-medium md:flex-1 justify-end">
                            <form action="{{ route('products.index') ?? '#' }}" method="GET" class="hidden lg:block relative">
                                <input type="text" name="search" placeholder="Search..." class="border-b border-gray-300 bg-transparent focus:border-luxury-gold text-sm pl-2 pr-8 py-1 focus:outline-none w-40 transition-colors placeholder-gray-400 font-sans" value="{{ request('search') }}">
                                <button type="submit" class="absolute right-0 top-1 text-gray-400 hover:text-luxury-gold transition-colors">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </button>
                            </form>

                            <!-- User Auth -->
                            @auth
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="flex items-center text-gray-700 hover:text-luxury-gold focus:outline-none transition-colors duration-300">
                                            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            <span class="hidden sm:inline-block font-sans">{{ Auth::user()->name }}</span>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        @if(Auth::user()->role === 'admin')
                                            <x-dropdown-link :href="route('admin.dashboard') ?? '#'" class="font-sans hover:text-luxury-gold">{{ __('Admin Dashboard') }}</x-dropdown-link>
                                        @endif
                                        <x-dropdown-link :href="route('orders.index')" class="font-sans hover:text-luxury-gold">
                                            {{ __('Order History') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('profile.edit') ?? '#'" class="font-sans hover:text-luxury-gold">{{ __('Profile') }}</x-dropdown-link>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="font-sans hover:text-luxury-gold">{{ __('Log Out') }}</x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-luxury-gold transition-colors duration-300">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </a>
                            @endauth
                            <!-- Cart -->
                            <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-luxury-gold transition-colors duration-300 flex items-center group">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                @php $cartCount = count(session('cart', [])); @endphp
                                <span id="cart-badge" class="absolute -top-2 -right-2 bg-luxury-dark group-hover:bg-luxury-gold transition-colors duration-300 text-white rounded-full text-[10px] font-bold w-4 h-4 {{ $cartCount > 0 ? 'flex' : 'hidden' }} items-center justify-center shadow-sm">
                                    {{ $cartCount > 0 ? $cartCount : '' }}
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <div x-show="mobileMenuOpen" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="md:hidden bg-white border-t border-gray-100 absolute w-full shadow-lg" x-cloak>
                    <div class="px-4 pt-2 pb-6 space-y-1 h-screen overflow-y-auto">
                        <form action="{{ route('products.index') ?? '#' }}" method="GET" class="my-4 relative">
                            <input type="text" name="search" placeholder="Search..." class="w-full border-b border-gray-300 bg-transparent focus:border-luxury-gold text-sm py-2 pl-2 pr-10 focus:outline-none transition-colors" value="{{ request('search') }}">
                            <button type="submit" class="absolute right-2 top-2 text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>
                        </form>
                        
                        <a href="{{ route('home') ?? url('/') }}" class="block py-3 text-base uppercase tracking-widest font-semibold text-gray-800 border-b border-gray-50">Home</a>
                        <a href="{{ route('products.index') ?? '#' }}" class="block py-3 text-base uppercase tracking-widest font-semibold text-gray-800 border-b border-gray-50">Collection</a>
                        
                        <div x-data="{ open: false }">
                            <button @click="open = !open" class="w-full flex justify-between items-center py-3 text-base uppercase tracking-widest font-semibold text-gray-800 border-b border-gray-50">
                                Categories
                                <svg class="h-4 w-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open" class="pl-4 py-2 space-y-2 bg-gray-50">
                                @foreach(\App\Models\Category::all() as $category)
                                    <a href="{{ route('products.index', ['category' => $category->id]) ?? '#' }}" class="block py-2 text-sm text-gray-600">{{ $category->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-grow flex flex-col">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-luxury-dark text-gray-300 py-12 border-t border-gray-800 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h2 class="font-serif text-3xl text-white mb-6">WatchStore</h2>
                    <p class="text-sm font-sans mb-8">Elevate your style with our curated luxury timepieces.</p>
                    <div class="text-xs uppercase tracking-widest text-gray-500">
                        &copy; {{ date('Y') }} WatchStore. All rights reserved.
                    </div>
                </div>
            </footer>
        </div>

        <x-social-floating />
    </body>
</html>