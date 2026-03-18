<x-customer>
    <x-slot name="header">
        <div class="bg-white border-b border-gray-100 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('orders.index') }}" class="text-gray-400 hover:text-luxury-dark transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <h2 class="font-serif text-3xl text-luxury-dark tracking-tight">
                        {{ __('Order Details') }}
                    </h2>
                </div>
                <div class="w-12 h-0.5 bg-luxury-gold mt-4"></div>
            </div>
        </div>
    </x-slot>

    @php
        $statuses = [
            'pending' => 'Pending',
            'processing' => 'Processing',
            'shipping' => 'Shipping',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled'
        ];

        function getStatusColorClass($status) {
            return match($status) {
                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                'processing' => 'bg-blue-100 text-blue-800 border-blue-200',
                'shipping' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                'completed' => 'bg-green-100 text-green-800 border-green-200',
                'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                default => 'bg-gray-100 text-gray-800 border-gray-200'
            };
        }
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Order Status & Actions -->
            <div class="bg-white border border-gray-100 shadow-sm p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h3 class="text-xl font-serif text-luxury-dark mb-1">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h3>
                    <p class="text-sm text-gray-500">Placed on {{ $order->created_at->format('F d, Y \a\t H:i') }}</p>
                </div>
                <div class="flex items-center gap-4">
                    <span class="px-4 py-2 text-xs uppercase tracking-widest font-semibold border rounded-sm {{ getStatusColorClass($order->status) }}">
                        {{ $statuses[$order->status] ?? ucfirst($order->status) }}
                    </span>
                    @if($order->status === 'pending')
                         <!-- Optional: Add cancel order logic if required in the future -->
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Main Content: Products List -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white border border-gray-100 shadow-sm">
                        <div class="p-6 border-b border-gray-100">
                            <h4 class="font-serif text-lg text-luxury-dark tracking-wide">Ordered Items</h4>
                        </div>
                        
                        <div class="p-6 space-y-6">
                            @foreach($order->items as $item)
                                <div class="flex flex-col sm:flex-row gap-6 pb-6 border-b border-gray-50 last:border-0 last:pb-0">
                                    <div class="w-24 h-24 flex-shrink-0 bg-gray-50 border border-gray-100">
                                        @if($item->product && $item->product->images->isNotEmpty())
                                            @php
                                                $imagePath = $item->product->images->first()->image_url;
                                                $imageUrl = \Illuminate\Support\Str::startsWith($imagePath, 'http') ? $imagePath : Storage::url($imagePath);
                                            @endphp
                                            <img src="{{ $imageUrl }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-xs text-gray-400">No Image</div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex-1 flex flex-col justify-center">
                                        <h5 class="font-semibold text-luxury-dark text-base mb-1">
                                            @if($item->product)
                                                <a href="{{ route('products.show', $item->product->slug) }}" class="hover:text-luxury-gold transition-colors">
                                                    {{ $item->product->name }}
                                                </a>
                                            @else
                                                Product Unavailable
                                            @endif
                                        </h5>
                                        <div class="text-sm text-gray-500 space-y-1">
                                            <p>Price: {{ number_format($item->price, 0, ',', '.') }} ₫</p>
                                            <p>Quantity: {{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="sm:text-right flex flex-col justify-center">
                                        <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Subtotal</p>
                                        <p class="font-semibold text-luxury-dark whitespace-nowrap">
                                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }} ₫
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Sidebar: Order Details & Address -->
                <div class="space-y-6">
                    
                    <!-- Order Summary -->
                    <div class="bg-white border border-gray-100 shadow-sm p-6">
                        <h4 class="font-serif text-lg text-luxury-dark tracking-wide mb-6 border-b border-gray-100 pb-4">Order Summary</h4>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Subtotal</span>
                                <span>{{ number_format($order->items->sum(fn($item) => $item->price * $item->quantity), 0, ',', '.') }} ₫</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Shipping</span>
                                <span>Free</span> <!-- Adjust if you have shipping costs -->
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-100 pt-4 flex justify-between items-center">
                            <span class="text-sm font-semibold uppercase tracking-widest text-luxury-dark">Total</span>
                            <span class="text-xl font-serif text-luxury-gold">
                                {{ number_format($order->total_price, 0, ',', '.') }} ₫
                            </span>
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Payment Method</p>
                            <p class="text-sm font-semibold text-luxury-dark">
                                {{ $order->payment_method === 'cod' ? 'Cash on Delivery (COD)' : strtoupper($order->payment_method) }}
                            </p>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-white border border-gray-100 shadow-sm p-6">
                        <h4 class="font-serif text-lg text-luxury-dark tracking-wide mb-6 border-b border-gray-100 pb-4">Shipping Info</h4>
                        
                        @if($order->address)
                            <div class="space-y-2 text-sm text-gray-600">
                                <p class="font-semibold text-luxury-dark">{{ $order->address->receiver_name }}</p>
                                <p>{{ $order->address->phone }}</p>
                                <div class="text-gray-500 mt-2">
                                    <p>{{ $order->address->full_address }}</p>
                                    <p>{{ $order->address->ward }}, {{ $order->address->district }}</p>
                                    <p>{{ $order->address->city }}</p>
                                </div>
                            </div>
                        @else
                            <div class="text-sm text-gray-500">
                                <p>{{ $order->receiver_name ?? 'N/A' }}</p>
                                <p>{{ $order->receiver_phone ?? 'N/A' }}</p>
                                <p class="mt-2">{{ $order->shipping_address ?? 'Shipping address not found.' }}</p>
                            </div>
                        @endif

                        @if($order->note)
                            <div class="mt-6 pt-4 border-t border-gray-100">
                                <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Order Notes</p>
                                <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-sm italic">
                                    "{{ $order->note }}"
                                </p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-customer>

