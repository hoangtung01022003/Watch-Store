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
                
                <form action="{{ route('products.index') }}" method="GET" class="space-y-8">
                    <!-- Maintain search if it exists -->
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <!-- Categories Filter -->
                    <div>
                        <h4 class="text-xs font-bold text-gray-800 uppercase tracking-widest mb-4">Categories</h4>
                        <div class="space-y-3">
                            <div class="flex items-center group">
                                <input type="radio" id="cat_all" name="category_id" value="" class="h-4 w-4 text-luxury-gold focus:ring-luxury-gold border-gray-300 transition-colors" {{ !request('category_id') ? 'checked' : '' }}>
                                <label for="cat_all" class="ml-3 text-sm text-gray-600 group-hover:text-luxury-dark cursor-pointer transition-colors">All Categories</label>
                            </div>
                            @foreach($categories as $category)
                                <div class="flex items-center group">
                                    <input type="radio" id="cat_{{ $category->id }}" name="category_id" value="{{ $category->id }}" class="h-4 w-4 text-luxury-gold focus:ring-luxury-gold border-gray-300 transition-colors" {{ request('category_id') == $category->id ? 'checked' : '' }}>
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
                                <input type="radio" id="brand_all" name="brand_id" value="" class="h-4 w-4 text-luxury-gold focus:ring-luxury-gold border-gray-300 transition-colors" {{ !request('brand_id') ? 'checked' : '' }}>
                                <label for="brand_all" class="ml-3 text-sm text-gray-600 group-hover:text-luxury-dark cursor-pointer transition-colors">All Brands</label>
                            </div>
                            @foreach($brands as $brand)
                                <div class="flex items-center group">
                                    <input type="radio" id="brand_{{ $brand->id }}" name="brand_id" value="{{ $brand->id }}" class="h-4 w-4 text-luxury-gold focus:ring-luxury-gold border-gray-300 transition-colors" {{ request('brand_id') == $brand->id ? 'checked' : '' }}>
                                    <label for="brand_{{ $brand->id }}" class="ml-3 text-sm text-gray-600 group-hover:text-luxury-dark cursor-pointer transition-colors">{{ $brand->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <button type="submit" class="w-full bg-luxury-dark text-white py-3 px-4 text-xs font-semibold uppercase tracking-widest hover:bg-luxury-gold transition-colors duration-300 focus:outline-none">
                            Apply Filters
                        </button>
                        @if(request()->hasAny(['category_id', 'brand_id', 'search']))
                            <a href="{{ route('products.index') }}" class="block text-center text-xs uppercase tracking-widest font-semibold text-gray-400 hover:text-luxury-dark transition-colors mt-4">Clear All Filters</a>
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
                <div class="text-sm text-gray-500 hidden sm:block">
                    Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }}
                </div>
            </div>

            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-8">
                    @foreach($products as $product)
                        <div class="bg-white border border-gray-100 hover:border-luxury-gold hover:shadow-xl transition-all duration-300 group flex flex-col h-full">
                            <div class="relative w-full aspect-w-4 aspect-h-5 overflow-hidden bg-gray-50 p-6">
                                <a href="#">
                                    @if($product->image)
                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain mix-blend-darken group-hover:scale-105 transition-transform duration-700">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs font-serif italic group-hover:scale-105 transition-transform duration-700">No Image</div>
                                    @endif
                                    
                                    <!-- Overlay action -->
                                    <div class="absolute inset-0 bg-white/40 backdrop-blur-[2px] flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <button class="bg-luxury-dark text-white text-xs uppercase tracking-widest font-semibold py-3 px-6 hover:bg-luxury-gold transition-colors transform translate-y-4 group-hover:translate-y-0 duration-300">
                                            Quick View
                                        </button>
                                    </div>
                                </a>
                            </div>
                            <div class="p-6 text-center flex flex-col flex-grow border-t border-gray-50">
                                <div class="text-[10px] text-gray-400 mb-2 font-bold tracking-widest uppercase">{{ $product->brand->name ?? 'Premium' }}</div>
                                <h3 class="text-base font-serif text-luxury-dark mb-3 line-clamp-2 leading-relaxed">
                                    <a href="#" class="hover:text-luxury-gold transition-colors">{{ $product->name }}</a>
                                </h3>
                                <div class="mt-auto pt-4 flex flex-col items-center justify-center">
                                    <span class="text-sm font-semibold text-luxury-dark mb-4">{{ number_format($product->price, 0, ',', '.') }} ₫</span>
                                    <button class="text-xs uppercase tracking-widest font-semibold border-b border-gray-300 pb-1 hover:text-luxury-gold hover:border-luxury-gold transition-colors" title="Add to cart">
                                        Add to Cart
                                    </button>
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
