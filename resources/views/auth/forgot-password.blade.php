@extends('layouts.app')

@section('content')
<!-- ✅ reviewed -->
<div class="mb-6 text-center">
    <h2 class="text-3xl font-serif text-luxury-dark mt-6 mb-2">Khôi phục mật khẩu</h2>
    <p class="text-sm text-gray-500 uppercase tracking-widest">Cập nhật thông tin của bạn</p>
    <div class="w-12 h-0.5 bg-luxury-gold mx-auto mt-4"></div>
</div>

<div class="mb-6 text-sm text-gray-600 text-center">
    {{ __('Bạn quên mật khẩu? Không vấn đề gì. Chỉ cần cho chúng tôi biết địa chỉ email của bạn và chúng tôi sẽ gửi cho bạn một liên kết đặt lại mật khẩu để bạn có thể chọn một mật khẩu mới.') }}
</div>

<!-- Session Status -->
<x-auth-session-status class="mb-4" :status="session('status')" />

<form method="POST" action="{{ route('password.email') }}" class="space-y-6">
    @csrf

    <!-- Email Address -->
    <div>
        <label for="email" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Địa chỉ Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-2 block w-full px-4 py-3 border border-gray-300 bg-white text-sm placeholder-gray-400 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition-colors">
        @error('email')
            <p class="mt-1 flex items-center text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-end mt-6">
        <button type="submit" class="w-full flex justify-center py-4 px-4 shadow-sm text-sm font-medium text-white bg-luxury-dark hover:bg-luxury-gold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-luxury-gold transition-all uppercase tracking-widest">
            {{ __('Gửi liên kết đặt lại mật khẩu qua Email') }}
        </button>
    </div>
</form>

<p class="mt-8 text-center text-sm text-gray-600">
    Đã nhớ mật khẩu của bạn? 
    <a href="{{ route('login') }}" class="font-medium text-luxury-dark hover:text-luxury-gold uppercase tracking-wider ml-1 transition-colors border-b border-luxury-gold">Quay lại đăng nhập</a>
</p>
@endsection
