<header class="flex items-center justify-between p-4 bg-white border-b border-gray-200">
    <div class="flex items-center">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @yield('header', 'Admin Area')
        </h2>
    </div>
    
    <div class="flex items-center space-x-4">
        <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'Admin' }}</span>
        <!-- Logout form -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-900">
                Logout
            </button>
        </form>
    </div>
</header>
