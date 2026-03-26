<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WatchStore') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600|playfair-display:400,600,700&display=swap"
        rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .font-sans {
            font-family: 'Inter', sans-serif;
        }

        .bg-luxury-dark {
            background-color: #1a1e24;
        }

        .text-luxury-dark {
            color: #1a1e24;
        }

        .bg-luxury-gold {
            background-color: #d4af37;
        }

        .text-luxury-gold {
            color: #d4af37;
        }

        .border-luxury-gold {
            border-color: #d4af37;
        }

        .hover-bg-luxury-gold:hover {
            background-color: #bfa136;
        }
    </style>
</head>

<body class="font-sans antialiased bg-[#fbfbfb] text-gray-800">
    <div class="min-h-screen flex flex-col">
        <!-- Top Bar -->
        <div class="bg-luxury-dark text-white text-xs text-center py-2 uppercase tracking-widest font-medium">
            Miễn phí vận chuyển cho tất cả đơn hàng
        </div>

        <!-- Sticky Navbar -->
        <header class="bg-white/95 backdrop-blur-sm shadow-sm relative z-40 sticky top-0 border-b border-gray-100"
            x-data="{ mobileMenuOpen: false }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <!-- Mobile Menu Button -->
                    <div class="flex items-center md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen"
                            class="text-gray-600 hover:text-luxury-gold focus:outline-none p-2">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>

                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center justify-center flex-1 md:flex-none md:justify-start">
                        <a href="{{ route('home') ?? url('/') }}"
                            class="font-serif font-bold tracking-tight text-luxury-dark hover:text-luxury-gold transition-colors duration-300 text-center leading-tight">

                            <span class="block text-xL tracking-widest">ĐỒNG HỒ</span>
                            <span class="block text-2xl">XUÂN GIANG</span>

                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <nav class="hidden md:flex space-x-4 lg:space-x-8 items-center flex-1 justify-center">
                        <a href="{{ route('home') ?? url('/') }}"
                            class="text-sm uppercase tracking-widest font-semibold text-gray-700 hover:text-luxury-gold transition-colors duration-300 whitespace-nowrap">Trang
                            chủ</a>
                        <a href="{{ route('products.index') ?? '#' }}"
                            class="text-sm uppercase tracking-widest font-semibold text-gray-700 hover:text-luxury-gold transition-colors duration-300 whitespace-nowrap">Bộ
                            Sưu Tập</a>

                        <!-- Categories Dropdown using Alpine -->
                        <div class="relative group" x-data="{ open: false }" @mouseenter="open = true"
                            @mouseleave="open = false">
                            <button
                                class="text-sm uppercase tracking-widest font-semibold text-gray-700 hover:text-luxury-gold flex items-center transition-colors duration-300 py-4 whitespace-nowrap">
                                Danh Mục
                                <svg class="ml-1 h-4 w-4 fill-current transition-transform duration-300"
                                    :class="{'rotate-180': open}" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-1"
                                class="absolute left-1/2 -translate-x-1/2 mt-0 w-64 pt-2 shadow-xl bg-white border border-gray-100 focus:outline-none z-50">
                                <div class="py-2">
                                    @foreach(\App\Models\Category::all() as $category)
                                        <a href="{{ route('products.index', ['category' => $category->id]) ?? '#' }}"
                                            class="block px-6 py-3 text-sm text-gray-600 hover:bg-gray-50 hover:text-luxury-gold transition-colors duration-200">{{ $category->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Brands Dropdown -->
                        <div class="relative group" x-data="{ open: false }" @mouseenter="open = true"
                            @mouseleave="open = false">
                            <button
                                class="text-sm uppercase tracking-widest font-semibold text-gray-700 hover:text-luxury-gold flex items-center transition-colors duration-300 py-4 whitespace-nowrap">
                                Thương Hiệu
                                <svg class="ml-1 h-4 w-4 fill-current transition-transform duration-300"
                                    :class="{'rotate-180': open}" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-1"
                                class="absolute left-1/2 -translate-x-1/2 mt-0 w-64 pt-2 shadow-xl bg-white border border-gray-100 focus:outline-none z-50">
                                <div class="py-2 grid grid-cols-2 gap-1 p-2">
                                    @foreach(\App\Models\Brand::all() as $brand)
                                        <a href="{{ route('products.index', ['brand' => $brand->id]) ?? '#' }}"
                                            class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-luxury-gold transition-colors duration-200">{{ $brand->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </nav>

                    <!-- Right Actions -->
                    <div class="flex items-center space-x-6 text-sm font-medium md:flex-1 justify-end">
                        <form action="{{ route('products.index') ?? '#' }}" method="GET"
                            class="hidden lg:block relative">
                            <input type="text" name="search" placeholder="Tìm kiếm..."
                                class="border-b border-gray-300 bg-transparent focus:border-luxury-gold text-sm pl-2 pr-8 py-1 focus:outline-none w-40 transition-colors placeholder-gray-400 font-sans"
                                value="{{ request('search') }}">
                            <button type="submit"
                                class="absolute right-0 top-1 text-gray-400 hover:text-luxury-gold transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </form>

                        <!-- User Auth -->
                        @auth
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="flex items-center text-gray-700 hover:text-luxury-gold focus:outline-none transition-colors duration-300">
                                        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        <span class="hidden sm:inline-block font-sans">{{ Auth::user()->name }}</span>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    @if(Auth::user()->role === 'admin')
                                        <x-dropdown-link :href="route('admin.dashboard') ?? '#'"
                                            class="font-sans hover:text-luxury-gold">{{ __('Bảng điều khiển Quản trị') }}</x-dropdown-link>
                                    @endif
                                    <x-dropdown-link :href="route('orders.index')" class="font-sans hover:text-luxury-gold">
                                        {{ __('Lịch sử Đơn hàng') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('profile.edit') ?? '#'"
                                        class="font-sans hover:text-luxury-gold">{{ __('Hồ sơ') }}</x-dropdown-link>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                            class="font-sans hover:text-luxury-gold">{{ __('Đăng xuất') }}</x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-gray-700 hover:text-luxury-gold transition-colors duration-300">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </a>
                        @endauth
                        <!-- Cart -->
                        <a href="{{ route('cart.index') }}"
                            class="relative text-gray-700 hover:text-luxury-gold transition-colors duration-300 flex items-center group">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            @php $cartCount = count(session('cart', [])); @endphp
                            <span id="cart-badge"
                                class="absolute -top-2 -right-2 bg-luxury-dark group-hover:bg-luxury-gold transition-colors duration-300 text-white rounded-full text-[10px] font-bold w-4 h-4 {{ $cartCount > 0 ? 'flex' : 'hidden' }} items-center justify-center shadow-sm">
                                {{ $cartCount > 0 ? $cartCount : '' }}
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                class="md:hidden bg-white border-t border-gray-100 absolute w-full shadow-lg" x-cloak>
                <div class="px-4 pt-2 pb-6 space-y-1 h-screen overflow-y-auto">
                    <form action="{{ route('products.index') ?? '#' }}" method="GET" class="my-4 relative">
                        <input type="text" name="search" placeholder="Tìm kiếm..."
                            class="w-full border-b border-gray-300 bg-transparent focus:border-luxury-gold text-sm py-2 pl-2 pr-10 focus:outline-none transition-colors"
                            value="{{ request('search') }}">
                        <button type="submit" class="absolute right-2 top-2 text-gray-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </form>

                    <a href="{{ route('home') ?? url('/') }}"
                        class="block py-3 text-base uppercase tracking-widest font-semibold text-gray-800 border-b border-gray-50">Trang
                        chủ</a>
                    <a href="{{ route('products.index') ?? '#' }}"
                        class="block py-3 text-base uppercase tracking-widest font-semibold text-gray-800 border-b border-gray-50">Bộ
                        Sưu Tập</a>

                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                            class="w-full flex justify-between items-center py-3 text-base uppercase tracking-widest font-semibold text-gray-800 border-b border-gray-50">
                            Danh Mục
                            <svg class="h-4 w-4 transition-transform" :class="{'rotate-180': open}" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" class="pl-4 py-2 space-y-2 bg-gray-50">
                            @foreach(\App\Models\Category::all() as $category)
                                <a href="{{ route('products.index', ['category' => $category->id]) ?? '#' }}"
                                    class="block py-2 text-sm text-gray-600">{{ $category->name }}</a>
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
        <footer class="bg-luxury-dark text-gray-300 py-16 border-t border-luxury-gold/20 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                    <!-- Brand Info -->
                    <div class="col-span-1 md:col-span-2 lg:col-span-1">
                        <h2 class="font-serif text-3xl text-white mb-6">Đồng Hồ Xuân Giang</h2>
                        <p class="text-sm font-sans mb-6 leading-relaxed">Nâng tầm phong cách của bạn với những chiếc
                            đồng hồ sang trọng được chọn lọc.</p>
                        <ul class="text-sm font-sans space-y-3 text-gray-400">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-3 text-luxury-gold shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>Hà Nội</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-luxury-gold shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                                <span>+84 918 429 174</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-luxury-gold shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span>contact@donghoxuangiang.com</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3
                            class="text-white font-serif text-lg mb-6 relative inline-block after:content-[''] after:absolute after:-bottom-2 after:left-0 after:w-1/2 after:h-px after:bg-luxury-gold">
                            Danh Mục</h3>
                        <ul class="space-y-3 text-sm font-sans">
                            <li><a href="#"
                                    class="text-gray-400 hover:text-luxury-gold transition-colors duration-300">Rolex</a></li>
                            <li><a href="#"
                                    class="text-gray-400 hover:text-luxury-gold transition-colors duration-300">Luxury</a></li>
                            <li><a href="#"
                                    class="text-gray-400 hover:text-luxury-gold transition-colors duration-300">Sport</a></li>
                            <li><a href="#"
                                    class="text-gray-400 hover:text-luxury-gold transition-colors duration-300">Classic</a></li>
                        </ul>
                    </div>

                    <!-- Customer Support -->
                    <div>
                        <h3
                            class="text-white font-serif text-lg mb-6 relative inline-block after:content-[''] after:absolute after:-bottom-2 after:left-0 after:w-1/2 after:h-px after:bg-luxury-gold">
                            Hỗ Trợ</h3>
                        <ul class="space-y-3 text-sm font-sans">
                            <li><a href="#"
                                    class="text-gray-400 hover:text-luxury-gold transition-colors duration-300">Chính
                                    sách bảo hành</a></li>
                            <li><a href="#"
                                    class="text-gray-400 hover:text-luxury-gold transition-colors duration-300">Chính
                                    sách đổi trả</a></li>
                            <li><a href="#"
                                    class="text-gray-400 hover:text-luxury-gold transition-colors duration-300">Vận
                                    chuyển & Giao nhận</a></li>
                            <li><a href="#"
                                    class="text-gray-400 hover:text-luxury-gold transition-colors duration-300">Câu hỏi
                                    thường gặp</a></li>
                        </ul>
                    </div>

                    <!-- Newsletter -->
                    <div>
                        <h3
                            class="text-white font-serif text-lg mb-6 relative inline-block after:content-[''] after:absolute after:-bottom-2 after:left-0 after:w-1/2 after:h-px after:bg-luxury-gold">
                            Đăng Ký Nhận Tin</h3>
                        <p class="text-sm font-sans text-gray-400 mb-4">Nhận thông tin cập nhật về các bộ sưu tập mới.
                        </p>
                        <form action="#" class="mb-6 flex">
                            <input type="email" placeholder="Email của bạn..."
                                class="bg-[#242930] text-sm text-white border-none focus:ring-1 focus:ring-luxury-gold w-full px-4 py-2 font-sans placeholder-gray-500">
                            <button type="submit"
                                class="bg-luxury-gold text-luxury-dark px-4 py-2 hover:bg-[#bfa136] transition-colors duration-300 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div class="border-t border-gray-800 pt-8 mt-8 flex flex-col md:flex-row justify-between items-center">
                    <div class="text-xs uppercase tracking-widest text-gray-500 mb-4 md:mb-0">
                        &copy; {{ date('Y') }} Đồng Hồ Xuân Giang. Đã đăng ký Bản quyền.
                    </div>
                    <div class="flex space-x-6 text-xs text-gray-500 uppercase tracking-widest">
                        <a href="#" class="hover:text-luxury-gold transition-colors duration-300">Bảo mật</a>
                        <a href="#" class="hover:text-luxury-gold transition-colors duration-300">Điều khoản</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <x-social-floating />
</body>

</html>