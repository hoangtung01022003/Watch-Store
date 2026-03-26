@extends('layouts.app')

@section('content')
<!-- ✅ reviewed -->
<div class="mb-6 text-center">
    <h2 class="text-3xl font-serif text-luxury-dark mt-6 mb-2">Đặt lại mật khẩu</h2>
    <p class="text-sm text-gray-500 uppercase tracking-widest">Tạo mật khẩu mới</p>
    <div class="w-12 h-0.5 bg-luxury-gold mx-auto mt-4"></div>
</div>

<form method="POST" action="{{ route('password.store') }}" class="space-y-6">
    @csrf

    <!-- Password Reset Token -->
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <!-- Email Address -->
    <div>
        <label for="email" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Địa chỉ Email</label>
        <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" class="mt-2 block w-full px-4 py-3 border border-gray-300 bg-white text-sm placeholder-gray-400 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition-colors">
        @error('email')
            <p class="mt-1 flex items-center text-xs text-red-500">
                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <!-- Password -->
    <div class="mt-4">
        <label for="password" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Mật khẩu</label>
        <input id="password" type="password" name="password" required autocomplete="new-password" class="mt-2 block w-full px-4 py-3 border border-gray-300 bg-white text-sm placeholder-gray-400 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition-colors">
        @error('password')
            <p class="mt-1 flex items-center text-xs text-red-500">
                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
        <label for="password_confirmation" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Xác nhận mật khẩu</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="mt-2 block w-full px-4 py-3 border border-gray-300 bg-white text-sm placeholder-gray-400 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition-colors">
        @error('password_confirmation')
            <p class="mt-1 flex items-center text-xs text-red-500">
                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="flex items-center justify-end mt-6">
        <button type="submit" class="w-full flex justify-center py-4 px-4 shadow-sm text-sm font-medium text-white bg-luxury-dark hover:bg-luxury-gold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-luxury-gold transition-all uppercase tracking-widest">
            {{ __('Đặt lại mật khẩu') }}
        </button>
    </div>
</form>
@endsection
