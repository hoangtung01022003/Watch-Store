<x-customer>
    <x-slot name="header">
        <div class="bg-white border-b border-gray-100 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="font-serif text-3xl text-luxury-dark tracking-tight">
                    {{ __('Profile') }}
                </h2>
                <div class="w-12 h-0.5 bg-luxury-gold mt-4"></div>
            </div>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ tab: 'addresses', showCreateForm: {{ $errors->any() && !old('_method') ? 'true' : 'false' }}, editingId: {{ old('_method') === 'PUT' ? old('address_id', 'null') : 'null' }} }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Navigation Tabs -->
            <div class="bg-white shadow-sm border border-gray-100">
                <div class="border-b border-gray-100">
                    <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                        <button @click="window.location.href='{{ route('profile.edit') }}'"
                                class="border-transparent text-gray-500 hover:text-luxury-dark hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-semibold text-xs uppercase tracking-widest transition-colors">
                            Personal Info
                        </button>
                        <button @click="window.location.href='{{ route('profile.edit') }}'"
                                class="border-transparent text-gray-500 hover:text-luxury-dark hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-semibold text-xs uppercase tracking-widest transition-colors">
                            Change Password
                        </button>
                        <button class="border-luxury-gold text-luxury-gold whitespace-nowrap py-4 px-1 border-b-2 font-semibold text-xs uppercase tracking-widest transition-colors cursor-default">
                            Address Book
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Tab Contents -->
            <div>
                <!-- Addresses Tab -->
                <div x-show="tab === 'addresses'" class="space-y-6">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-serif text-luxury-dark">Your Addresses</h3>
                        <button @click="showCreateForm = !showCreateForm; editingId = null" class="bg-luxury-dark text-white uppercase tracking-widest text-xs px-6 py-3 hover:bg-luxury-gold transition-colors duration-300">
                            Create New Address
                        </button>
                    </div>

                    <!-- Create Form -->
                    <div x-show="showCreateForm" x-transition class="bg-white border border-gray-100 shadow-sm p-6 mb-8">
                        <h4 class="text-lg font-serif text-luxury-dark mb-4 border-b pb-2">Add New Address</h4>
                        <form action="{{ route('profile.addresses.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Receiver Name *</label>
                                    <input type="text" name="receiver_name" value="{{ old('receiver_name') }}" class="w-full border-gray-300 focus:border-luxury-gold focus:ring-0 text-sm">
                                    @error('receiver_name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Phone Number *</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border-gray-300 focus:border-luxury-gold focus:ring-0 text-sm">
                                    @error('phone')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Full Address *</label>
                                <input type="text" name="full_address" value="{{ old('full_address') }}" placeholder="Street name, building, house number" class="w-full border-gray-300 focus:border-luxury-gold focus:ring-0 text-sm">
                                @error('full_address')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">City/Province *</label>
                                    <input type="text" name="city" value="{{ old('city') }}" class="w-full border-gray-300 focus:border-luxury-gold focus:ring-0 text-sm">
                                    @error('city')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">District *</label>
                                    <input type="text" name="district" value="{{ old('district') }}" class="w-full border-gray-300 focus:border-luxury-gold focus:ring-0 text-sm">
                                    @error('district')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Ward *</label>
                                    <input type="text" name="ward" value="{{ old('ward') }}" class="w-full border-gray-300 focus:border-luxury-gold focus:ring-0 text-sm">
                                    @error('ward')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="flex items-center mt-4">
                                <button type="submit" class="bg-luxury-dark text-white uppercase tracking-widest text-xs px-6 py-3 hover:bg-luxury-gold transition-colors duration-300">
                                    Save Address
                                </button>
                                <button type="button" @click="showCreateForm = false" class="ml-4 text-sm text-gray-600 hover:text-luxury-dark uppercase tracking-widest transition-colors font-medium">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Addresses List -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($addresses as $address)
                            <div class="bg-white border border-gray-200 shadow-sm p-6 relative group overflow-hidden">
                                @if($address->is_default)
                                    <div class="absolute top-0 right-0 bg-green-50 text-green-700 text-[10px] font-bold px-3 py-1 uppercase tracking-widest rounded-bl">
                                        Default
                                    </div>
                                @endif
                                
                                <!-- View Mode -->
                                <div x-show="editingId !== {{ $address->id }}">
                                    <div class="mb-4">
                                        <h4 class="font-semibold text-luxury-dark text-lg">{{ $address->receiver_name }}</h4>
                                        <p class="text-gray-500 text-sm mt-1">{{ $address->phone }}</p>
                                    </div>
                                    <div class="text-gray-600 text-sm space-y-1 mb-6 h-16">
                                        <p>{{ $address->full_address }}</p>
                                        <p>{{ $address->ward }}, {{ $address->district }}</p>
                                        <p>{{ $address->city }}</p>
                                    </div>
                                    
                                    <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
                                        <div class="flex space-x-3">
                                            <button @click="editingId = {{ $address->id }}; showCreateForm = false" class="text-luxury-dark hover:text-luxury-gold text-xs uppercase tracking-widest font-semibold transition-colors">
                                                Edit
                                            </button>
                                            <form action="{{ route('profile.addresses.destroy', $address) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this address?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs uppercase tracking-widest font-semibold transition-colors">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                        
                                        @if(!$address->is_default)
                                            <form action="{{ route('profile.addresses.setDefault', $address) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded transition-colors uppercase tracking-wider border border-gray-200">
                                                    Set Default
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Edit Form -->
                                <div x-show="editingId === {{ $address->id }}" x-cloak>
                                    <form action="{{ route('profile.addresses.update', $address) }}" method="POST" class="space-y-4">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="address_id" value="{{ $address->id }}">
                                        
                                        <div class="grid grid-cols-1 gap-3">
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-700 uppercase tracking-wider mb-1">Name *</label>
                                                <input type="text" name="receiver_name" value="{{ old('receiver_name', $address->receiver_name) }}" class="w-full border-gray-300 focus:border-luxury-gold focus:ring-0 py-2 text-sm">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-700 uppercase tracking-wider mb-1">Phone *</label>
                                                <input type="text" name="phone" value="{{ old('phone', $address->phone) }}" class="w-full border-gray-300 focus:border-luxury-gold focus:ring-0 py-2 text-sm">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-700 uppercase tracking-wider mb-1">Address *</label>
                                                <input type="text" name="full_address" value="{{ old('full_address', $address->full_address) }}" class="w-full border-gray-300 focus:border-luxury-gold focus:ring-0 py-2 text-sm">
                                            </div>
                                            <div class="grid grid-cols-3 gap-2">
                                                <div>
                                                    <label class="block text-[10px] font-semibold text-gray-700 uppercase tracking-wider mb-1">City *</label>
                                                    <input type="text" name="city" value="{{ old('city', $address->city) }}" class="w-full border-gray-300 focus:border-luxury-gold focus:ring-0 py-2 text-sm">
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-semibold text-gray-700 uppercase tracking-wider mb-1">District *</label>
                                                    <input type="text" name="district" value="{{ old('district', $address->district) }}" class="w-full border-gray-300 focus:border-luxury-gold focus:ring-0 py-2 text-sm">
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-semibold text-gray-700 uppercase tracking-wider mb-1">Ward *</label>
                                                    <input type="text" name="ward" value="{{ old('ward', $address->ward) }}" class="w-full border-gray-300 focus:border-luxury-gold focus:ring-0 py-2 text-sm">
                                                </div>
                                            </div>
                                            <!-- Note: Validation errors are somewhat shared per field name across the page if multiple errors exist open on single edit, handled ideally by keeping forms simple. -->
                                        </div>

                                        <div class="flex items-center space-x-3 mt-4 pt-3 border-t border-gray-100">
                                            <button type="submit" class="bg-luxury-dark text-white uppercase tracking-widest text-[10px] px-4 py-2 hover:bg-luxury-gold transition-colors duration-300">
                                                Update
                                            </button>
                                            <button type="button" @click="editingId = null" class="text-xs text-gray-600 hover:text-luxury-dark uppercase tracking-widest border border-gray-300 px-4 py-2 hover:border-gray-500 transition-colors">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                
                            </div>
                        @endforeach
                    </div>
                    
                    @if($addresses->isEmpty())
                        <div class="py-12 bg-gray-50 border border-gray-100 text-center rounded">
                            <p class="text-gray-500 mb-4">You haven't saved any addresses yet.</p>
                            <button @click="showCreateForm = true" class="text-luxury-dark hover:text-luxury-gold uppercase tracking-widest font-semibold text-sm transition-colors border-b border-luxury-dark hover:border-luxury-gold pb-1">
                                Add your first address
                            </button>
                        </div>
                    @endif

                </div>
            </div>
            
        </div>
    </div>
</x-customer>

