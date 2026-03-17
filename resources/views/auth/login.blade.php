@extends('layouts.app')

@section('content')
<div class="mb-6 text-center">
    <h2 class="text-2xl font-semibold text-gray-900">Welcome Back</h2>
    <p class="text-sm text-gray-500 mt-1">Please sign in to your account</p>
</div>

<form method="POST" action="{{ route('login') ?? '#' }}" class="space-y-5">
    @csrf

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="mt-1 block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
        @error('email')
            <p class="mt-1 flex items-center text-sm text-red-500">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <div>
        <div class="flex items-center justify-between">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors">Forgot password?</a>
            @endif
        </div>
        <input id="password" type="password" name="password" required autocomplete="current-password" class="mt-1 block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
        @error('password')
            <p class="mt-1 flex items-center text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center">
        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
        <label for="remember_me" class="ml-2 block text-sm text-gray-700">Remember me</label>
    </div>

    <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
        Sign In
    </button>
</form>

<p class="mt-8 text-center text-sm text-gray-600">
    Don't have an account? 
    <a href="{{ route('register') ?? '#' }}" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">Create one now</a>
</p>
@endsection
