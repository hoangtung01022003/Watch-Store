<!-- ✅ reviewed -->
@extends('layouts.app')

@section('content')
<div class="mb-6 text-center">
    <h2 class="text-3xl font-serif text-luxury-dark mt-6 mb-2">Chào mừng trở lại</h2>
    <p class="text-sm text-gray-500 uppercase tracking-widest">Đăng nhập vào tài khoản của bạn</p>
    <div class="w-12 h-0.5 bg-luxury-gold mx-auto mt-4"></div>
</div>

<form method="POST" action="{{ route('login') }}" class="space-y-6">
    @csrf

    <div>
        <label for="email" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Địa chỉ Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="mt-2 block w-full px-4 py-3 border border-gray-300 bg-white text-sm placeholder-gray-400 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition-colors">
        @error('email')
            <p class="mt-1 flex items-center text-xs text-red-500">
                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <div>
        <div class="flex items-center justify-between">
            <label for="password" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Mật khẩu</label>
        </div>
        <input id="password" type="password" name="password" required autocomplete="current-password" class="mt-2 block w-full px-4 py-3 border border-gray-300 bg-white text-sm placeholder-gray-400 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition-colors">
        @error('password')
            <p class="mt-1 flex items-center text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-luxury-gold border-gray-300 rounded focus:ring-luxury-gold">
            <label for="remember_me" class="ml-2 block text-sm text-gray-600">Ghi nhớ đăng nhập</label>
        </div>
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-sm font-medium text-luxury-dark hover:text-luxury-gold transition-colors">Quên mật khẩu?</a>
        @endif
    </div>

    <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent shadow-sm text-sm font-medium text-white bg-luxury-dark hover:bg-luxury-gold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-luxury-gold transition-all uppercase tracking-widest">
        Đăng Nhập
    </button>
</form>

<p class="mt-8 text-center text-sm text-gray-600">
    Bạn chưa có tài khoản? 
    <a href="{{ route('register') }}" class="font-medium text-luxury-dark hover:text-luxury-gold uppercase tracking-wider ml-1 transition-colors border-b border-luxury-gold">Tạo tài khoản</a>
</p>
@endsection
