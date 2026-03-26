<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-100">
        <div class="flex h-screen overflow-hidden bg-gray-100">

            <!-- Sidebar -->
            <aside class="flex flex-col w-64 text-white bg-gray-800 transition-all duration-300">
                <div class="flex items-center justify-center h-16 bg-gray-900">
                    <span class="text-xl font-bold uppercase">Bảng điều khiển</span>
                </div>
                
                <div class="overflow-y-auto overflow-x-hidden flex-grow">
                    <ul class="flex flex-col py-4 space-y-1">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-700 text-gray-300 hover:text-white border-l-4 border-transparent hover:border-indigo-500 pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Tổng quan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.categories.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-700 text-gray-300 hover:text-white border-l-4 border-transparent hover:border-indigo-500 pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Danh mục</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.brands.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-700 text-gray-300 hover:text-white border-l-4 border-transparent hover:border-indigo-500 pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Thương hiệu</span>
                            </a>
                        </li>
                        <!-- Add more nav items here -->
                    </ul>
                </div>
            </aside>

            <!-- Content wrapper -->
            <div class="flex flex-col flex-1 overflow-hidden">
                <!-- Header -->
                @include('admin.layouts.header')

                <!-- Main content area -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                    <div class="container px-6 py-8 mx-auto">
                        @if(session('error'))
                            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        @yield('content')
                        
                        {{ $slot ?? '' }}
                    </div>
                </main>
            </div>
            
        </div>
    </body>
</html>