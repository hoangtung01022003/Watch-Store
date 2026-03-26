<x-customer>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-serif text-luxury-dark mb-8">Giỏ Hàng</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if(count($cart) > 0)
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Cart Items -->
                <div class="w-full lg:w-2/3">
                    <div class="bg-white border border-gray-100 shadow-sm overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100 text-sm uppercase tracking-widest text-gray-500">
                                    <th class="py-4 px-6 font-semibold">Sản phẩm</th>
                                    <th class="py-4 px-6 font-semibold">Giá</th>
                                    <th class="py-4 px-6 font-semibold">Số lượng</th>
                                    <th class="py-4 px-6 font-semibold text-right">Tổng</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($cart as $id => $item)
                                    <tr>
                                        <td class="py-6 px-6 flex items-center gap-4">
                                            <div class="w-20 h-20 bg-gray-50 flex-shrink-0 border border-gray-100 overflow-hidden relative">
                                                @php
                                                    $imageUrl = $item['image'] ?? \App\Http\Controllers\CartController::FALLBACK_URL;
                                                    // if it's our fallback url, use as is, else use Storage::url safely
                                                    if (!Str::startsWith($imageUrl, 'http')) {
                                                        $imageUrl = Storage::url($imageUrl);
                                                    }
                                                @endphp
                                                <img src="{{ $imageUrl }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <h3 class="font-serif text-lg text-luxury-dark">{{ $item['name'] }}</h3>
                                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="mt-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-xs text-red-500 hover:text-red-700 uppercase tracking-widest transition-colors">Xóa</button>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="py-6 px-6 align-top pt-8 text-luxury-dark">
                                            {{ number_format($item['price'], 0, ',', '.') }} ₫
                                        </td>
                                        <td class="py-6 px-6 align-top pt-8">
                                            <form action="{{ route('cart.update') }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="product_id" value="{{ $id }}">
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] }}" class="w-16 border-gray-300 focus:border-luxury-gold focus:ring-0 text-center py-1 text-sm" onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <td class="py-6 px-6 align-top pt-8 text-right font-semibold text-luxury-dark">
                                            {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} ₫
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-white border border-gray-100 shadow-sm p-6">
                        <h2 class="font-serif text-xl text-luxury-dark mb-6 border-b border-gray-100 pb-4">Tóm tắt Đơn hàng</h2>
                        
                        <div class="space-y-4 mb-6 text-sm text-gray-600">
                            <div class="flex justify-between">
                                <span>Tạm tính</span>
                                <span>{{ number_format($total, 0, ',', '.') }} ₫</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Giao hàng</span>
                                <span class="text-green-600">Miễn phí</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-4 mb-8 flex justify-between items-center">
                            <span class="font-serif text-lg text-luxury-dark">Tổng cộng</span>
                            <span class="font-semibold text-xl text-luxury-dark">{{ number_format($total, 0, ',', '.') }} ₫</span>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="block w-full text-center bg-luxury-dark text-white uppercase tracking-widest text-sm py-4 hover:bg-luxury-gold transition-colors duration-300">
                            Tiến hành Thanh toán
                        </a>
                        
                        <a href="{{ route('products.index') }}" class="block w-full text-center mt-4 text-sm text-luxury-dark hover:text-luxury-gold uppercase tracking-widest transition-colors duration-300 border border-luxury-dark py-3">
                            Tiếp tục Mua sắm
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-20 bg-white border border-gray-100 shadow-sm">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                <h2 class="font-serif text-2xl text-luxury-dark mb-4">Giỏ hàng của bạn đang trống</h2>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">Khám phá các bộ sưu tập độc quyền của chúng tôi và tìm cho mình chiếc đồng hồ hoàn hảo.</p>
                <a href="{{ route('products.index') }}" class="inline-block bg-luxury-dark text-white uppercase tracking-widest text-sm px-8 py-4 hover:bg-luxury-gold transition-colors duration-300">
                    Khám phá Bộ sưu tập
                </a>
            </div>
        @endif
    </div>
</x-customer>

