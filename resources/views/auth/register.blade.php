<!-- ✅ reviewed -->
@extends('layouts.app')

@section('content')
<div class="mb-6 text-center">
    <h2 class="text-3xl font-serif text-luxury-dark mt-6 mb-2">Tạo Tài Khoản</h2>
    <p class="text-sm text-gray-500 uppercase tracking-widest">Tham gia để có trải nghiệm cao cấp</p>
    <div class="w-12 h-0.5 bg-luxury-gold mx-auto mt-4"></div>
</div>

<form method="POST" action="{{ route('register') }}" class="space-y-6">
    @csrf

    <div>
        <label for="name" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Họ và Tên</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="mt-2 block w-full px-4 py-3 border border-gray-300 bg-white text-sm placeholder-gray-400 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition-colors">
        @error('name')
            <p class="mt-1 flex items-center text-xs text-red-500">
                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <div>
        <label for="email" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Địa chỉ Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="mt-2 block w-full px-4 py-3 border border-gray-300 bg-white text-sm placeholder-gray-400 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition-colors">
        @error('email')
            <p class="mt-1 flex items-center text-xs text-red-500">
                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <div>
        <label for="password" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Mật khẩu</label>
        <input id="password" type="password" name="password" required autocomplete="new-password" class="mt-2 block w-full px-4 py-3 border border-gray-300 bg-white text-sm placeholder-gray-400 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition-colors">
        @error('password')
            <p class="mt-1 flex items-center text-xs text-red-500">
                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <div>
        <label for="password_confirmation" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Xác nhận mật khẩu</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="mt-2 block w-full px-4 py-3 border border-gray-300 bg-white text-sm placeholder-gray-400 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition-colors">
    </div>

    <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent shadow-sm text-sm font-medium text-white bg-luxury-dark hover:bg-luxury-gold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-luxury-gold transition-all uppercase tracking-widest">
        Đăng Ký
    </button>
</form>

<p class="mt-8 text-center text-sm text-gray-600">
    Đã có tài khoản? 
    <a href="{{ route('login') }}" class="font-medium text-luxury-dark hover:text-luxury-gold uppercase tracking-wider ml-1 transition-colors border-b border-luxury-gold">Đăng nhập tại đây</a>
</p>
@endsection
