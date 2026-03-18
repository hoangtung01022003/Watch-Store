<x-customer>
    <x-slot name="header">
        <div class="bg-white border-b border-gray-100 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="font-serif text-3xl text-luxury-dark tracking-tight">
                    {{ __('Order History') }}
                </h2>
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

        function getStatusColor($status) {
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Filters -->
            <div class="bg-white shadow-sm border border-gray-100 p-4">
                <div class="flex flex-wrap gap-2 items-center">
                    <span class="text-sm font-semibold text-gray-600 uppercase tracking-widest mr-2">Filter Status:</span>
                    <a href="{{ route('orders.index') }}" 
                       class="px-4 py-2 text-xs uppercase tracking-widest transition-colors border {{ !request('status') ? 'bg-luxury-dark border-luxury-dark text-white' : 'border-gray-200 text-gray-600 hover:border-luxury-gold hover:text-luxury-gold' }}">
                        All
                    </a>
                    @foreach($statuses as $key => $label)
                        <a href="{{ route('orders.index', ['status' => $key]) }}" 
                           class="px-4 py-2 text-xs uppercase tracking-widest transition-colors border {{ request('status') === $key ? 'bg-luxury-dark border-luxury-dark text-white' : 'border-gray-200 text-gray-600 hover:border-luxury-gold hover:text-luxury-gold' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Orders List -->
            @if($orders->isEmpty())
                <div class="bg-white border border-gray-100 shadow-sm p-12 text-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-serif text-luxury-dark mb-2">No Orders Found</h3>
                    <p class="text-gray-500 mb-6">You haven't placed any orders yet or no orders match your filter.</p>
                    <a href="{{ route('products.index') }}" class="inline-block px-8 py-4 bg-luxury-dark text-white uppercase tracking-widest text-sm hover:bg-luxury-gold transition-colors duration-300">
                        Start Shopping
                    </a>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($orders as $order)
                        <div class="bg-white border border-gray-100 shadow-sm hover:border-gray-300 transition-colors duration-300">
                            <!-- Order Header -->
                            <div class="bg-gray-50 p-4 border-b border-gray-100 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                                <div class="flex flex-col sm:flex-row sm:gap-8">
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Order Placed</p>
                                        <p class="text-sm font-semibold text-luxury-dark">{{ $order->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div class="mt-2 sm:mt-0">
                                        <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Total</p>
                                        <p class="text-sm font-semibold text-luxury-dark">{{ number_format($order->total_price, 0, ',', '.') }} ₫</p>
                                    </div>
                                    <div class="mt-2 sm:mt-0">
                                        <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Order #</p>
                                        <p class="text-sm font-semibold text-luxury-dark">{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                    <span class="px-3 py-1 text-xs uppercase tracking-widest font-semibold border rounded-sm {{ getStatusColor($order->status) }}">
                                        {{ $statuses[$order->status] ?? ucfirst($order->status) }}
                                    </span>
                                    <a href="{{ route('orders.show', $order) }}" class="text-xs text-luxury-dark uppercase tracking-widest border-b border-luxury-dark hover:text-luxury-gold hover:border-luxury-gold transition-colors pb-0.5">
                                        View Details
                                    </a>
                                </div>
                            </div>

                            <!-- Order Items Preview -->
                            <div class="p-6">
                                <div class="flex flex-col gap-4">
                                    @foreach($order->items->take(2) as $item)
                                        <div class="flex items-center gap-4 border-b border-gray-50 pb-4 last:border-0 last:pb-0">
                                            @if($item->product && $item->product->images->isNotEmpty())
                                                @php
                                                    $imagePath = $item->product->images->first()->image_url;
                                                    $imageUrl = \Illuminate\Support\Str::startsWith($imagePath, 'http') ? $imagePath : Storage::url($imagePath);
                                                @endphp
                                                <img src="{{ $imageUrl }}" alt="{{ $item->product->name }}" class="w-20 h-20 object-cover border border-gray-100">
                                            @else
                                                <div class="w-20 h-20 bg-gray-100 flex items-center justify-center border border-gray-100">
                                                    <span class="text-xs text-gray-400">No Img</span>
                                                </div>
                                            @endif
                                            
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-luxury-dark text-sm">
                                                    {{ $item->product ? $item->product->name : 'Product Unavailable' }}
                                                </h4>
                                                <p class="text-xs text-gray-500 mt-1">Qty: {{ $item->quantity }} x {{ number_format($item->price, 0, ',', '.') }} ₫</p>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    @if($order->items->count() > 2)
                                        <div class="pt-2 text-center sm:text-left">
                                            <p class="text-xs text-gray-500 italic">+ {{ $order->items->count() - 2 }} more item(s)</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @endif

        </div>
    </div>
</x-customer>

