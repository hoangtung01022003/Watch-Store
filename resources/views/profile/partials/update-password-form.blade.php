<section>
    <header>
        <h2 class="text-2xl font-serif text-luxury-dark">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="mt-2 block w-full px-4 py-3 border border-gray-300 bg-white text-sm placeholder-gray-400 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition-colors" autocomplete="current-password" />
            @error('current_password', 'updatePassword')<p class="mt-1 flex items-center text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="update_password_password" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" class="mt-2 block w-full px-4 py-3 border border-gray-300 bg-white text-sm placeholder-gray-400 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition-colors" autocomplete="new-password" />
            @error('password', 'updatePassword')<p class="mt-1 flex items-center text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-2 block w-full px-4 py-3 border border-gray-300 bg-white text-sm placeholder-gray-400 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition-colors" autocomplete="new-password" />
            @error('password_confirmation', 'updatePassword')<p class="mt-1 flex items-center text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="inline-flex justify-center py-3 px-8 border border-transparent shadow-sm text-sm font-medium text-white bg-luxury-dark hover:bg-luxury-gold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-luxury-gold transition-all uppercase tracking-widest">
                {{ __('Save Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-green-600 font-medium"
                >{{ __('Saved successfully.') }}</p>
            @endif
        </div>
    </form>
</section>
