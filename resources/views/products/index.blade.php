<x-customer>
    <!-- ✅ reviewed -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 flex flex-col md:flex-row gap-10">
        <!-- Sidebar Filters -->
        <aside class="w-full md:w-1/4">
            <div class="bg-white p-6 border border-gray-100 shadow-sm relative">
                <!-- Decorative Corner -->
                <div class="absolute top-0 left-0 w-3 h-3 border-t border-l border-luxury-gold"></div>
                <div class="absolute bottom-0 right-0 w-3 h-3 border-b border-r border-luxury-gold"></div>

                <h3 class="text-xl font-serif text-luxury-dark mb-6 tracking-wide">Refine Search</h3>
                
                <form action="{{ route('products.index') }}" method="GET" class="space-y-8" id="filter-form">
                    <!-- Maintain search if it exists -->
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <!-- Sorting -->
                    <div>
                        <h4 class="text-xs font-bold text-gray-800 uppercase tracking-widest mb-4">Sort By</h4>
                        <select name="sort" class="w-full border-gray-300 focus:border-luxury-gold focus:ring-luxury-gold text-sm text-gray-600 transition-colors" onchange="document.getElementById('filter-form').submit()">
                            <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>Newest Arrivals</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </div>

                    <!-- Categories Filter -->
                    <div>
                        <h4 class="text-xs font-bold text-gray-800 uppercase tracking-widest mb-4">Categories</h4>
                        <div class="space-y-3">
                            <div class="flex items-center group">
                                <input type="checkbox" id="cat_all" class="h-4 w-4 text-luxury-gold focus:ring-luxury-gold border-gray-300 transition-colors" {{ empty($filters['category_id']) ? 'checked' : '' }} onclick="document.querySelectorAll('input[name=\'category_id[]\']').forEach(cb => cb.checked = false); this.form.submit();">
                                <label for="cat_all" class="ml-3 text-sm text-gray-600 group-hover:text-luxury-dark cursor-pointer transition-colors">All Categories</label>
                            </div>
                            @foreach($categories as $category)
                                <div class="flex items-center group">
                                    <input type="checkbox" id="cat_{{ $category->id }}" name="category_id[]" value="{{ $category->id }}" class="h-4 w-4 text-luxury-gold focus:ring-luxury-gold border-gray-300 transition-colors category-checkbox" {{ in_array($category->id, $filters['category_id']) ? 'checked' : '' }} onchange="document.getElementById('cat_all').checked = false; this.form.submit();">
                                    <label for="cat_{{ $category->id }}" class="ml-3 text-sm text-gray-600 group-hover:text-luxury-dark cursor-pointer transition-colors">{{ $category->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Brands Filter -->
                    <div>
                        <h4 class="text-xs font-bold text-gray-800 uppercase tracking-widest mb-4">Brands</h4>
                        <div class="space-y-3">
                            <div class="flex items-center group">
                                <input type="checkbox" id="brand_all" class="h-4 w-4 text-luxury-gold focus:ring-luxury-gold border-gray-300 transition-colors" {{ empty($filters['brand_id']) ? 'checked' : '' }} onclick="document.querySelectorAll('input[name=\'brand_id[]\']').forEach(cb => cb.checked = false); this.form.submit();">
                                <label for="brand_all" class="ml-3 text-sm text-gray-600 group-hover:text-luxury-dark cursor-pointer transition-colors">All Brands</label>
                            </div>
                            @foreach($brands as $brand)
                                <div class="flex items-center group">
                                    <input type="checkbox" id="brand_{{ $brand->id }}" name="brand_id[]" value="{{ $brand->id }}" class="h-4 w-4 text-luxury-gold focus:ring-luxury-gold border-gray-300 transition-colors brand-checkbox" {{ in_array($brand->id, $filters['brand_id']) ? 'checked' : '' }} onchange="document.getElementById('brand_all').checked = false; this.form.submit();">
                                    <label for="brand_{{ $brand->id }}" class="ml-3 text-sm text-gray-600 group-hover:text-luxury-dark cursor-pointer transition-colors">{{ $brand->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Filter -->
                    <div>
                        <h4 class="text-xs font-bold text-gray-800 uppercase tracking-widest mb-4">Price Range</h4>
                        <div class="flex items-center gap-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min ₫" class="w-full text-xs border-gray-300 focus:border-luxury-gold focus:ring-luxury-gold transition-colors py-2" min="0" step="100000">
                            <span class="text-gray-400">-</span>
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max ₫" class="w-full text-xs border-gray-300 focus:border-luxury-gold focus:ring-luxury-gold transition-colors py-2" min="0" step="100000">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex flex-col gap-3">
                        <button type="submit" class="w-full bg-luxury-dark text-white py-3 px-4 text-xs font-semibold uppercase tracking-widest hover:bg-luxury-gold transition-colors duration-300 focus:outline-none">
                            Apply Filters
                        </button>
                        @if(request()->hasAny(['category_id', 'brand_id', 'search', 'min_price', 'max_price', 'sort']))
                            <a href="{{ route('products.index') }}" class="block text-center w-full border border-gray-200 text-gray-600 py-3 px-4 text-xs font-semibold uppercase tracking-widest hover:bg-gray-50 hover:text-luxury-dark transition-colors duration-300 focus:outline-none">
                                Clear All Filters
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </aside>

        <!-- Product Grid -->
        <div class="w-full md:w-3/4">
            <!-- Search Results Header -->
            <div class="mb-10 pb-4 border-b border-gray-100 flex justify-between items-end">
                @if(request('search'))
                    <div>
                        <h2 class="text-2xl font-serif text-luxury-dark tracking-tight">Search Results</h2>
                        <p class="mt-1 text-sm text-gray-500">For keyword: <span class="font-bold font-serif text-luxury-gold">"{{ request('search') }}"</span></p>
                    </div>
                @else
                    <div>
                        <h2 class="text-3xl font-serif text-luxury-dark tracking-tight">The Collection</h2>
                        <p class="mt-2 text-xs uppercase tracking-widest text-gray-500 font-semibold">Exquisite Timepieces</p>
                    </div>
                @endif
                <div class="flex items-center gap-6">
                    <!-- Active Filters Display -->
                    @if(request()->hasAny(['category_id', 'brand_id', 'search', 'min_price', 'max_price']))
                        <div class="hidden lg:flex items-center gap-2">
                            <span class="text-xs text-gray-500">Active Filters:</span>
                            @if(request('search'))
                                <span class="inline-flex items-center px-2 py-1 bg-gray-100 text-xs text-gray-600 border border-gray-200">
                                    "{{ request('search') }}"
                                    <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="ml-1 text-gray-400 hover:text-luxury-dark">&times;</a>
                                </span>
                            @endif
                            @foreach($filters['category_id'] as $catId)
                                @php $catName = $categories->firstWhere('id', $catId)?->name; @endphp
                                @if($catName)
                                    <span class="inline-flex items-center px-2 py-1 bg-gray-100 text-xs text-gray-600 border border-gray-200">
                                        {{ $catName }}
                                        <a href="{{ request()->fullUrlWithQuery(['category_id' => array_diff($filters['category_id'], [$catId])]) }}" class="ml-1 text-gray-400 hover:text-luxury-dark">&times;</a>
                                    </span>
                                @endif
                            @endforeach
                            @foreach($filters['brand_id'] as $brandId)
                                @php $brandName = $brands->firstWhere('id', $brandId)?->name; @endphp
                                @if($brandName)
                                    <span class="inline-flex items-center px-2 py-1 bg-gray-100 text-xs text-gray-600 border border-gray-200">
                                        {{ $brandName }}
                                        <a href="{{ request()->fullUrlWithQuery(['brand_id' => array_diff($filters['brand_id'], [$brandId])]) }}" class="ml-1 text-gray-400 hover:text-luxury-dark">&times;</a>
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    @endif
                    <div class="text-sm text-gray-500 hidden sm:block">
                        Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }}
                    </div>
                </div>
            </div>

            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-8">
                    @foreach($products as $product)
                        <div class="bg-white border border-gray-100 hover:border-luxury-gold hover:shadow-xl transition-all duration-300 group flex flex-col h-full">
                            <div class="relative w-full aspect-[3/4] overflow-hidden bg-gray-50 flex items-center justify-center">
                                <a href="{{ route('products.show', $product->slug) }}" class="absolute inset-0 z-10 w-full h-full"></a>
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain mix-blend-darken group-hover:scale-105 transition-transform duration-700 p-4">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs font-serif italic group-hover:scale-105 transition-transform duration-700">No Image</div>
                                @endif
                                
                                <!-- Quick Actions Base -->
                                <div class="absolute inset-x-0 bottom-0 bg-white bg-opacity-95 opacity-0 translate-y-[10px] group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 ease-in-out flex flex-col z-20 shadow-md border-t border-gray-100">
                                    <a href="{{ route('products.show', $product->slug) }}" class="relative z-30 flex-1 py-3 text-center text-xs font-semibold text-luxury-dark uppercase tracking-wider hover:bg-gray-50 hover:text-luxury-gold transition-colors block border-b border-gray-100">
                                        Quick View
                                    </a>
                                </div>
                            </div>
                            <div class="p-6 text-center flex flex-col flex-grow border-t border-gray-50">
                                <div class="text-[10px] text-gray-400 mb-2 font-bold tracking-widest uppercase">{{ $product->brand->name ?? 'Premium' }}</div>
                                <h3 class="text-base font-serif text-luxury-dark mb-3 line-clamp-2 leading-relaxed">
                                    <a href="{{ route('products.show', $product->slug) }}" class="hover:text-luxury-gold transition-colors">{{ $product->name }}</a>
                                </h3>
                                <div class="mt-auto pt-4 flex flex-col items-center justify-center">
                                    <span class="text-sm font-semibold text-luxury-dark mb-4">{{ number_format($product->price, 0, ',', '.') }} ₫</span>
                                    @if($product->stock > 0)
                                    <button class="text-xs uppercase tracking-widest font-semibold border-b border-gray-300 pb-1 hover:text-luxury-gold hover:border-luxury-gold transition-colors" title="Add to cart"
                                            onclick="
                                                event.preventDefault();
                                                fetch('{{ route('cart.add') }}', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                                        'Accept': 'application/json'
                                                    },
                                                    body: JSON.stringify({
                                                        product_id: {{ $product->id }},
                                                        quantity: 1
                                                    })
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    if(data.success) {
                                                        const cartBadge = document.getElementById('cart-badge');
                                                        if(cartBadge) {
                                                            cartBadge.textContent = data.cartCount;
                                                            cartBadge.classList.remove('hidden');
                                                            cartBadge.classList.add('flex');
                                                        }
                                                        alert('Đã thêm sản phẩm vào giỏ hàng!');
                                                    } else {
                                                        alert(data.message || 'Có lỗi xảy ra!');
                                                    }
                                                })
                                                .catch(error => {
                                                    console.error('Error:', error);
                                                    alert('Có lỗi xảy ra khi thêm vào giỏ hàng.');
                                                });
                                            "
                                    >
                                        Add to Cart
                                    </button>
                                    @else
                                    <button class="text-xs uppercase tracking-widest font-semibold border-b border-gray-300 pb-1 text-gray-400 cursor-not-allowed" disabled>
                                        Out of Stock
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-16 border-t border-gray-100 pt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="bg-white p-16 border border-gray-100 shadow-sm text-center relative">
                    <!-- Decorative Corner -->
                    <div class="absolute top-0 left-0 w-4 h-4 border-t border-l border-gray-200"></div>
                    <div class="absolute bottom-0 right-0 w-4 h-4 border-b border-r border-gray-200"></div>

                    <svg class="mx-auto h-16 w-16 text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <h3 class="text-2xl font-serif text-luxury-dark mb-2">No Products Found</h3>
                    <p class="text-gray-500 text-sm mb-6">We couldn't find any timepieces matching your current selection.</p>
                    <a href="{{ route('products.index') }}" class="inline-block border border-luxury-dark text-luxury-dark px-8 py-3 text-xs uppercase tracking-widest font-semibold hover:bg-luxury-dark hover:text-white transition-colors">
                        Clear All Filters
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-customer>
