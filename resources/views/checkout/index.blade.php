<x-customer>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-serif text-luxury-dark mb-8">Checkout</h1>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Column (Address & Details) -->
                <div class="w-full lg:w-2/3 space-y-8">
                    
                    <!-- Delivery Address -->
                    <div class="bg-white border border-gray-100 shadow-sm p-6" id="address-container">
                        <h2 class="font-serif text-xl text-luxury-dark mb-6 border-b border-gray-100 pb-4">Delivery Address</h2>
                        
                        @if($addresses->count() > 0)
                            <div class="space-y-4 mb-6">
                                @foreach($addresses as $address)
                                    <label class="flex items-start p-4 border border-gray-200 cursor-pointer hover:border-luxury-gold transition-colors">
                                        <input type="radio" name="address_id" value="{{ $address->id }}" class="mt-1 text-luxury-gold focus:ring-luxury-gold" {{ $loop->first ? 'checked' : '' }} onchange="toggleNewAddress(false)">
                                        <div class="ml-4">
                                            <div class="font-semibold text-luxury-dark">{{ $address->receiver_name }} <span class="text-sm font-normal text-gray-500">({{ $address->phone }})</span></div>
                                            <div class="text-sm text-gray-600 mt-1">{{ $address->full_address }}</div>
                                            <div class="text-sm text-gray-600">{{ $address->ward }}, {{ $address->district }}, {{ $address->city }}</div>
                                            @if($address->is_default)
                                                <span class="inline-block mt-2 text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Default Address</span>
                                            @endif
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            
                            <label class="flex items-center mb-4 cursor-pointer">
                                <input type="checkbox" name="use_new_address" id="use_new_address" value="1" class="text-luxury-gold focus:ring-luxury-gold" onchange="toggleNewAddress(this.checked)" {{ old('use_new_address') == '1' ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-luxury-dark uppercase tracking-widest">Ship to a different address</span>
                            </label>
                        @else
                            <input type="hidden" name="use_new_address" value="1" id="use_new_address">
                            <p class="text-sm text-gray-500 mb-4">Please provide a delivery address for your first order.</p>
                        @endif

                        <!-- New Address Form -->
                        <div id="new_address_form" class="{{ ($addresses->count() > 0 && old('use_new_address') != '1') ? 'hidden' : '' }} space-y-4 pt-4 border-t border-gray-100">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-700 mb-1">Receiver Name *</label>
                                    <input type="text" name="receiver_name" value="{{ old('receiver_name') }}" class="w-full border-gray-300 focus:border-luxury-gold focus:ring-0">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-700 mb-1">Phone *</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border-gray-300 focus:border-luxury-gold focus:ring-0">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700 mb-1">Full Address *</label>
                                <input type="text" name="full_address" value="{{ old('full_address') }}" class="w-full border-gray-300 focus:border-luxury-gold focus:ring-0" placeholder="Street name, building, house number...">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-700 mb-1">City/Province *</label>
                                    <input type="text" name="city" value="{{ old('city') }}" class="w-full border-gray-300 focus:border-luxury-gold focus:ring-0">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-700 mb-1">District *</label>
                                    <input type="text" name="district" value="{{ old('district') }}" class="w-full border-gray-300 focus:border-luxury-gold focus:ring-0">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-700 mb-1">Ward *</label>
                                    <input type="text" name="ward" value="{{ old('ward') }}" class="w-full border-gray-300 focus:border-luxury-gold focus:ring-0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white border border-gray-100 shadow-sm p-6">
                        <h2 class="font-serif text-xl text-luxury-dark mb-6 border-b border-gray-100 pb-4">Payment Method</h2>
                        <div class="space-y-4">
                            <label class="flex items-center p-4 border border-luxury-gold bg-gray-50 cursor-pointer">
                                <input type="radio" name="payment_method" value="COD" class="text-luxury-gold focus:ring-luxury-gold" checked>
                                <div class="ml-4">
                                    <div class="font-semibold text-luxury-dark">Cash on Delivery (COD)</div>
                                    <div class="text-sm text-gray-500">Pay when you receive your order.</div>
                                </div>
                            </label>
                            <!-- More payment methods can be added here in the future -->
                        </div>
                    </div>

                    <!-- Order Note -->
                    <div class="bg-white border border-gray-100 shadow-sm p-6">
                        <h2 class="font-serif text-xl text-luxury-dark mb-6 border-b border-gray-100 pb-4">Order Note (Optional)</h2>
                        <textarea name="note" rows="3" class="w-full border-gray-300 focus:border-luxury-gold focus:ring-0 text-sm" placeholder="Notes about your order, e.g. special notes for delivery.">{{ old('note') }}</textarea>
                    </div>

                </div>

                <!-- Right Column (Order Summary) -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-white border border-gray-100 shadow-sm p-6 sticky top-6">
                        <h2 class="font-serif text-xl text-luxury-dark mb-6 border-b border-gray-100 pb-4">Your Order</h2>
                        
                        <div class="space-y-4 mb-6">
                            @foreach($cart as $id => $item)
                                <div class="flex justify-between items-start border-b border-gray-50 pb-4 last:border-0 last:pb-0">
                                    <div class="pr-4">
                                        <div class="font-semibold text-sm text-luxury-dark">{{ $item['name'] }}</div>
                                        <div class="text-xs text-gray-500 mt-1">Qty: {{ $item['quantity'] }}</div>
                                    </div>
                                    <div class="text-sm font-semibold text-luxury-dark whitespace-nowrap">
                                        {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} ₫
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-4 mb-6 pt-4 border-t border-gray-100 text-sm text-gray-600">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span>{{ number_format($total, 0, ',', '.') }} ₫</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Shipping</span>
                                <span class="text-green-600">Complimentary</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-4 mb-8 flex justify-between items-center">
                            <span class="font-serif text-lg text-luxury-dark">Total</span>
                            <span class="font-bold text-xl text-luxury-dark">{{ number_format($total, 0, ',', '.') }} ₫</span>
                        </div>

                        <button type="submit" class="w-full text-center bg-luxury-dark text-white uppercase tracking-widest text-sm py-4 hover:bg-luxury-gold transition-colors duration-300">
                            Place Order
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function toggleNewAddress(show) {
            const form = document.getElementById('new_address_form');
            if(form) {
                if (show) {
                    form.classList.remove('hidden');
                    // Uncheck any selected existing addresses
                    const addressRadios = document.querySelectorAll('input[name="address_id"]');
                    addressRadios.forEach(radio => radio.checked = false);
                } else {
                    form.classList.add('hidden');
                    const checkbox = document.getElementById('use_new_address');
                    if(checkbox) checkbox.checked = false;
                }
            }
        }
    </script>
</x-customer>

