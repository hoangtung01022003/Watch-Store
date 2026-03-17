<x-customer>
    <!-- ✅ reviewed -->
    <x-slot name="header">
        <div class="bg-white border-b border-gray-100 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="font-serif text-3xl text-luxury-dark tracking-tight">
                    {{ __('My Addresses') }}
                </h2>
                <div class="w-12 h-0.5 bg-luxury-gold mt-4"></div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 py-12">
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-none relative text-sm" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="p-6 sm:p-10 bg-white shadow-sm border border-gray-100">
            <h3 class="text-lg font-serif text-luxury-dark mb-6 tracking-wide">Add New Address</h3>
            <form method="POST" action="{{ route('profile.addresses.store') }}" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="receiver_name" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">{{ __('Receiver Name') }}</label>
                        <input id="receiver_name" name="receiver_name" type="text" class="block w-full px-4 py-3 border border-gray-300 bg-white text-sm placeholder-gray-400 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition-colors" value="{{ old('receiver_name') }}" required />
                        @error('receiver_name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">{{ __('Phone') }}</label>
                        <input id="phone" name="phone" type="text" class="block w-full px-4 py-3 border border-gray-300 bg-white text-sm placeholder-gray-400 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition-colors" value="{{ old('phone') }}" required />
                        @error('phone')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="city" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">{{ __('City/Province') }}</label>
                        <input id="city" name="city" type="text" class="block w-full px-4 py-3 border border-gray-300 bg-white text-sm placeholder-gray-400 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition-colors" value="{{ old('city') }}" required />
                        @error('city')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="district" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">{{ __('District') }}</label>
                        <input id="district" name="district" type="text" class="block w-full px-4 py-3 border border-gray-300 bg-white text-sm placeholder-gray-400 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition-colors" value="{{ old('district') }}" required />
                        @error('district')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="ward" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">{{ __('Ward') }}</label>
                        <input id="ward" name="ward" type="text" class="block w-full px-4 py-3 border border-gray-300 bg-white text-sm placeholder-gray-400 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition-colors" value="{{ old('ward') }}" required />
                        @error('ward')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="full_address" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">{{ __('Full Physical Address') }}</label>
                    <input id="full_address" name="full_address" type="text" class="block w-full px-4 py-3 border border-gray-300 bg-white text-sm placeholder-gray-400 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition-colors" value="{{ old('full_address') }}" required />
                    @error('full_address')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center pt-2">
                    <button type="submit" class="py-3 px-6 border border-transparent shadow-sm text-xs font-semibold uppercase tracking-widest text-white bg-luxury-dark hover:bg-luxury-gold transition-colors focus:outline-none">
                        {{ __('Save Address') }}
                    </button>
                </div>
            </form>
        </div>

        <div class="p-6 sm:p-10 bg-white shadow-sm border border-gray-100">
            <h3 class="text-lg font-serif text-luxury-dark mb-6 tracking-wide">Saved Addresses</h3>
            <div class="space-y-4">
                @forelse ($addresses as $addr)
                    <div class="border p-5 transition-colors duration-300 {{ $addr->is_default ? 'border-luxury-gold bg-luxury-gold/5' : 'border-gray-200 hover:border-gray-300' }}">
                        <div class="flex flex-col sm:flex-row justify-between items-start">
                            <div class="mb-4 sm:mb-0">
                                <h4 class="font-semibold text-luxury-dark flex items-center gap-3">
                                    {{ $addr->receiver_name }}
                                    @if($addr->is_default)
                                        <span class="px-2 py-0.5 text-[10px] uppercase tracking-widest bg-luxury-dark text-luxury-gold font-bold">Default</span>
                                    @endif
                                </h4>
                                <p class="text-sm text-gray-600 mt-2">{{ $addr->phone }}</p>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ $addr->full_address }}, {{ $addr->ward }}, {{ $addr->district }}, {{ $addr->city }}
                                </p>
                            </div>
                            <div class="flex flex-row sm:flex-col space-x-4 sm:space-x-0 sm:space-y-3 text-sm text-right w-full sm:w-auto">
                                @if(!$addr->is_default)
                                    <form method="POST" action="{{ route('profile.addresses.setDefault', $addr) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-xs uppercase tracking-widest font-semibold text-gray-500 hover:text-luxury-gold transition-colors">Set Default</button>
                                    </form>
                                @endif
                                
                                <form method="POST" action="{{ route('profile.addresses.destroy', $addr) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs uppercase tracking-widest font-semibold text-red-500 hover:text-red-700 transition-colors" onclick="return confirm('Are you sure you want to delete this address?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 italic">No addresses saved yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-customer>