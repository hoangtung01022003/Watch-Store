<section>
    <header>
        <h2 class="text-2xl font-serif text-luxury-dark">
            {{ __('Thông tin hồ sơ') }}
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            {{ __("Cập nhật thông tin hồ sơ tài khoản và địa chỉ email của bạn.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">{{ __('Tên') }}</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" class="mt-2 block w-full px-4 py-3 border border-gray-300 bg-white text-sm placeholder-gray-400 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition-colors" />
            @error('name')<p class="mt-1 flex items-center text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="phone" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">{{ __('Số điện thoại') }}</label>
            <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" autocomplete="tel" class="mt-2 block w-full px-4 py-3 border border-gray-300 bg-white text-sm placeholder-gray-400 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition-colors" />
            @error('phone')<p class="mt-1 flex items-center text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="email" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username" class="mt-2 block w-full px-4 py-3 border border-gray-300 bg-white text-sm placeholder-gray-400 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition-colors" />
            @error('email')<p class="mt-1 flex items-center text-xs text-red-500">{{ $message }}</p>@enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Địa chỉ email của bạn chưa được xác minh.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-luxury-gold">
                            {{ __('Bấm vào đây để gửi lại email xác minh.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Một liên kết xác minh mới vừa được gửi tới địa chỉ email của bạn.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-3 bg-luxury-dark text-white text-sm font-semibold uppercase tracking-wider hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-luxury-dark transition-colors">{{ __('Lưu') }}</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Đã lưu.') }}</p>
            @endif
        </div>
    </form>
</section>
