@extends('layouts.app')

@section('content')
<!-- ✅ reviewed -->
<div class="mb-6 text-center">
    <h2 class="text-3xl font-serif text-luxury-dark mt-6 mb-2">Secure Area</h2>
    <p class="text-sm text-gray-500 uppercase tracking-widest">Confirm Password</p>
    <div class="w-12 h-0.5 bg-luxury-gold mx-auto mt-4"></div>
</div>

<div class="mb-6 text-sm text-gray-600 text-center">
    {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
</div>

<form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
    @csrf

    <!-- Password -->
    <div>
        <label for="password" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Password</label>
        <input id="password" type="password" name="password" required autocomplete="current-password" class="mt-2 block w-full px-4 py-3 border border-gray-300 bg-white text-sm placeholder-gray-400 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition-colors">
        @error('password')
            <p class="mt-1 flex items-center text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end mt-6">
        <button type="submit" class="w-full flex justify-center py-4 px-4 shadow-sm text-sm font-medium text-white bg-luxury-dark hover:bg-luxury-gold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-luxury-gold transition-all uppercase tracking-widest">
            {{ __('Confirm') }}
        </button>
    </div>
</form>
@endsection
