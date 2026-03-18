<x-customer>
    <x-slot name="header">
        <h2 class="font-serif text-xl text-gray-800 leading-tight">
            {{ __('Sản phẩm') }}
        </h2>
    </x-slot>

    <!-- Google Fonts for Luxury Feel -->
    <style>
        .font-serif { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Inter', sans-serif; }
        
        .bg-luxury-dark { background-color: #1a1e24; }
        .text-luxury-dark { color: #1a1e24; }
        .bg-luxury-gold { background-color: #d4af37; }
        .text-luxury-gold { color: #d4af37; }
        .border-luxury-gold { border-color: #d4af37; }
        .hover-bg-luxury-gold:hover { background-color: #bfa136; }
    </style>

    <div class="font-sans text-gray-800 bg-[#fbfbfb] py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- 1. Breadcrumb -->
            <nav class="flex mb-8 text-sm" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-luxury-gold transition-colors">
                            Trang chủ
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{ route('products.index', ['category_id' => $product->category_id]) }}" class="ml-1 text-gray-500 hover:text-luxury-gold transition-colors md:ml-2">
                                {{ $product->category->name }}
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-luxury-dark font-medium md:ml-2">{{ $product->name }}</span>
                        </div>
                    </li>
                </ol>
                
                <!-- Previous/Next Product Navigation -->
                <div class="ml-auto flex space-x-4 border-l pl-4 border-gray-300">
                    @if($prevProduct)
                        <a href="{{ route('products.show', $prevProduct->slug) }}" class="flex items-center text-gray-500 hover:text-luxury-gold transition-colors" title="{{ $prevProduct->name }}">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                            <span class="hidden sm:inline">Trước</span>
                        </a>
                    @endif
                    
                    @if($nextProduct)
                        <a href="{{ route('products.show', $nextProduct->slug) }}" class="flex items-center text-gray-500 hover:text-luxury-gold transition-colors" title="{{ $nextProduct->name }}">
                            <span class="hidden sm:inline">Tiếp</span>
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </a>
                    @endif
                </div>
            </nav>

            <!-- 2. Main Product Section -->
            <div class="flex flex-col md:flex-row gap-10 lg:gap-16 mb-20" x-data="{ 
                mainImg: '{{ $mainImage ? Storage::url($mainImage->image_url) : ($product->image ? Storage::url($product->image) : asset('images/no-image.jpg')) }}',
                quantity: 1,
                maxStock: {{ $product->stock }}
            }">
                
                <!-- Left Column: Images -->
                <div class="w-full md:w-1/2 flex flex-col gap-4">
                    <!-- Main Image -->
                    <div class="aspect-square bg-white border border-gray-100 flex items-center justify-center p-4">
                        <img :src="mainImg" alt="{{ $product->name }}" class="max-w-full max-h-full object-contain">
                    </div>
                    
                    <!-- Thumbnails -->
                    @if($thumbs->count() > 0 || $mainImage)
                        <div class="grid grid-cols-5 gap-2 sm:gap-4">
                            <!-- Main image as thumb -->
                            @if($mainImage || $product->image)
                                @php
                                    $mainImgUrl = $mainImage ? Storage::url($mainImage->image_url) : Storage::url($product->image);
                                @endphp
                                <button type="button" @click="mainImg = '{{ $mainImgUrl }}'" 
                                    :class="mainImg === '{{ $mainImgUrl }}' ? 'border-luxury-gold border-2' : 'border-gray-200 border'"
                                    class="aspect-square bg-white p-2 hover:border-luxury-gold transition-colors">
                                    <img src="{{ $mainImgUrl }}" alt="Thumb" class="w-full h-full object-cover">
                                </button>
                            @endif
                            
                            <!-- Other thumbs -->
                            @foreach($thumbs as $thumb)
                                <button type="button" @click="mainImg = '{{ Storage::url($thumb->image_url) }}'"
                                    :class="mainImg === '{{ Storage::url($thumb->image_url) }}' ? 'border-luxury-gold border-2' : 'border-gray-200 border'"
                                    class="aspect-square bg-white p-2 hover:border-luxury-gold transition-colors">
                                    <img src="{{ Storage::url($thumb->image_url) }}" alt="Thumb" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Right Column: Product Info -->
                <div class="w-full md:w-1/2 flex flex-col">
                    <span class="text-xs text-gray-500 uppercase tracking-widest mb-2 font-medium">{{ $product->brand->name ?? 'Exclusive' }}</span>
                    <h1 class="font-serif text-3xl md:text-4xl text-luxury-dark mb-4 leading-tight">{{ $product->name }}</h1>
                    
                    <!-- Price -->
                    <div class="mb-6 flex items-end gap-4">
                        <span class="text-2xl font-bold text-luxury-dark">{{ number_format($product->price, 0, ',', '.') }} ₫</span>
                        <!-- Placeholder for Old Price if you add sale price later -->
                        <!-- <span class="text-lg text-gray-400 line-through">0 ₫</span> -->
                    </div>

                    <!-- Stock Status -->
                    <div class="mb-6">
                        @if($product->stock > 0)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg>
                                Còn hàng ({{ $product->stock }})
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg>
                                Hết hàng
                            </span>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="prose prose-sm text-gray-600 mb-8 border-t border-b border-gray-100 py-6">
                        {!! nl2br(e($product->description ?? 'Đang cập nhật giới thiệu chi tiết cho sản phẩm này.')) !!}
                    </div>

                    <!-- Add to Cart Form -->
                    <form action="{{ route('cart.add') }}" method="POST" class="mt-auto" @submit.prevent="
                        fetch('{{ route('cart.add') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                product_id: {{ $product->id }},
                                quantity: quantity
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.success) {
                                // Find the cart badge and update it
                                const cartBadge = document.getElementById('cart-badge');
                                if(cartBadge) {
                                    cartBadge.textContent = data.cartCount;
                                    cartBadge.classList.remove('hidden');
                                    cartBadge.classList.add('flex');
                                }
                                
                                // Show success toast/notification instead of reload
                                alert('Đã thêm sản phẩm vào giỏ hàng!');
                            } else {
                                alert(data.message || 'Có lỗi xảy ra!');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Có lỗi xảy ra khi thêm vào giỏ hàng.');
                        });
                    ">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="flex items-center gap-4 mb-6">
                            <span class="text-sm font-medium text-gray-700">Số lượng:</span>
                            <div class="flex items-center border border-gray-300 w-32">
                                <button type="button" @click="if(quantity > 1) quantity--" class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition focus:outline-none" :disabled="maxStock <= 0">-</button>
                                <input type="number" name="quantity" x-model.number="quantity" class="w-full text-center border-0 focus:ring-0 p-0 text-sm" min="1" :max="maxStock" :disabled="maxStock <= 0">
                                <button type="button" @click="if(quantity < maxStock) quantity++" class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition focus:outline-none" :disabled="maxStock <= 0">+</button>
                            </div>
                        </div>

                        <button type="submit" 
                                class="w-full py-4 px-8 bg-luxury-dark text-white font-medium tracking-widest uppercase text-sm hover:bg-luxury-gold transition-colors duration-300 focus:outline-none disabled:bg-gray-300 disabled:cursor-not-allowed"
                                :disabled="maxStock <= 0">
                            Thêm vào giỏ hàng
                        </button>
                    </form>
                </div>
            </div>

            <!-- 3. Specs Section -->
            <div class="mb-20">
                <div class="flex flex-col items-center mb-8 text-center">
                    <h2 class="font-serif text-2xl md:text-3xl text-luxury-dark mb-4">Thông Số Kỹ Thuật</h2>
                    <div class="w-12 h-0.5 bg-luxury-gold"></div>
                </div>

                <div class="max-w-3xl mx-auto bg-white border border-gray-200">
                    <dl class="divide-y divide-gray-200">
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Thương hiệu</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $product->brand->name ?? 'N/A' }}</dd>
                        </div>
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50/50 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Đường kính mặt</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $specs->case_size ?? 'Đang cập nhật' }}</dd>
                        </div>
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Độ chịu nước</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $specs->water_resistance ?? 'Đang cập nhật' }}</dd>
                        </div>
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50/50 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Chất liệu dây</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $specs->strap_material ?? 'Đang cập nhật' }}</dd>
                        </div>
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Loại máy</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $specs->movement ?? 'Đang cập nhật' }}</dd>
                        </div>
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50/50 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Mặt kính</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $specs->glass_type ?? 'Đang cập nhật' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- 4. Related Products -->
            @if($relatedProducts->count() > 0)
                <section aria-labelledby="related-heading">
                    <div class="flex justify-between items-end mb-8">
                        <div>
                            <h2 id="related-heading" class="font-serif text-2xl md:text-3xl text-luxury-dark mb-4">Sản Phẩm Tương Tự</h2>
                            <div class="w-12 h-0.5 bg-luxury-gold"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-x-4 gap-y-10 sm:gap-x-8">
                        @foreach($relatedProducts as $related)
                            <div class="group relative bg-white flex flex-col h-full hover:shadow-xl transition-shadow duration-300 border border-gray-100">
                                <!-- Image Container 1:1 -->
                                <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-100 relative">
                                    <a href="{{ route('products.show', $related->slug) }}">
                                        @if($related->image)
                                            <img src="{{ Storage::url($related->image) }}" alt="{{ $related->name }}" class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-700">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400 font-serif">View Details</div>
                                        @endif
                                    </a>
                                    
                                    <!-- Stock Badge -->
                                    @if($related->stock > 0)
                                        <span class="absolute top-3 right-3 bg-white text-luxury-dark text-[10px] font-bold tracking-wider px-2 py-1 uppercase z-10 shadow-sm">Còn hàng</span>
                                    @else
                                        <span class="absolute top-3 right-3 bg-gray-200 text-gray-600 text-[10px] font-bold tracking-wider px-2 py-1 uppercase z-10 shadow-sm">Hết hàng</span>
                                    @endif
                                </div>
                                
                                <!-- Product Details -->
                                <div class="p-4 flex-grow flex flex-col text-center">
                                    <span class="text-xs text-gray-500 uppercase tracking-widest mb-2 font-medium">{{ $related->brand->name ?? 'Exclusive' }}</span>
                                    <h3 class="font-serif text-lg text-luxury-dark mb-2 line-clamp-2">
                                        <a href="{{ route('products.show', $related->slug) }}" class="hover:text-luxury-gold transition-colors">{{ $related->name }}</a>
                                    </h3>
                                    <div class="mt-auto pt-2">
                                        <span class="text-sm font-semibold text-luxury-dark">{{ number_format($related->price, 0, ',', '.') }} ₫</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

        </div>
    </div>
</x-customer>