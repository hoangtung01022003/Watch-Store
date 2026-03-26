<x-customer>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="bg-white border border-gray-100 shadow-sm p-10 text-center">

            <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h1 class="text-3xl font-serif text-luxury-dark mb-4">Cảm ơn bạn đã đặt hàng!</h1>

            <p class="text-gray-600 mb-8">
                Đơn hàng của bạn đã được đặt thành công và hiện đang được xử lý.
            </p>

            <div class="bg-gray-50 py-4 px-6 inline-block mb-10 border border-gray-100">
                <p class="text-sm text-gray-500 uppercase tracking-widest mb-1">Mã số đơn hàng</p>
                <p class="text-xl font-semibold text-luxury-dark">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('orders.index') }}"
                    class="px-8 py-4 border border-luxury-dark text-luxury-dark uppercase tracking-widest text-sm hover:bg-luxury-dark hover:text-white transition-colors duration-300">
                    Xem đơn hàng của tôi
                </a>
                <a href="{{ route('products.index') }}"
                    class="px-8 py-4 bg-luxury-dark text-white uppercase tracking-widest text-sm hover:bg-luxury-gold transition-colors duration-300">
                    Tiếp tục mua sắm
                </a>
            </div>

        </div>
    </div>
</x-customer>