@extends('layouts.app')

@section('content')
<div class="mb-6 text-center">
    <h2 class="text-2xl font-semibold text-gray-900">Create an Account</h2>
    <p class="text-sm text-gray-500 mt-1">Join us to manage your shopping effortlessly</p>
</div>

<form method="POST" action="{{ route('register') ?? '#' }}" class="space-y-5">
    @csrf

    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="mt-1 block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
        @error('name')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="mt-1 block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
        @error('email')
            <p class="mt-1 flex items-center text-sm text-red-500">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input id="password" type="password" name="password" required autocomplete="new-password" class="mt-1 block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
        @error('password')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="mt-1 block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
    </div>

    <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
        Create Account
    </button>
</form>

<p class="mt-8 text-center text-sm text-gray-600">
    Already have an account? 
    <a href="{{ route('login') ?? '#' }}" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">Sign in here</a>
</p>
@endsection
