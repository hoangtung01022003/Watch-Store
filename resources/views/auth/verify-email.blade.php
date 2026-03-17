@extends('layouts.app')

@section('content')
<!-- ✅ reviewed -->
<div class="mb-6 text-center">
    <h2 class="text-3xl font-serif text-luxury-dark mt-6 mb-2">Verify Email</h2>
    <p class="text-sm text-gray-500 uppercase tracking-widest">Almost there</p>
    <div class="w-12 h-0.5 bg-luxury-gold mx-auto mt-4"></div>
</div>

<div class="mb-6 text-sm text-gray-600 text-center">
    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
</div>

@if (session('status') == 'verification-link-sent')
    <div class="mb-6 font-medium text-sm text-green-600 text-center p-4 bg-green-50 border border-green-200">
        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
    </div>
@endif

<div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
    <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
        @csrf
        <button type="submit" class="w-full flex justify-center py-3 px-6 shadow-sm text-sm font-medium text-white bg-luxury-dark hover:bg-luxury-gold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-luxury-gold transition-all uppercase tracking-widest">
            {{ __('Resend Verification Email') }}
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto text-center">
        @csrf
        <button type="submit" class="font-medium text-luxury-dark hover:text-luxury-gold uppercase tracking-wider text-sm transition-colors border-b border-transparent hover:border-luxury-gold pb-0.5">
            {{ __('Log Out') }}
        </button>
    </form>
</div>
@endsection
