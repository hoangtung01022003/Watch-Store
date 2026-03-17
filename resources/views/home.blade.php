<x-customer>
    <!-- ✅ reviewed -->
    <x-slot name="header">
        <!-- We can customize the header per page here if needed, but x-customer provides the base nav -->
    </x-slot>

    <!-- Google Fonts for Luxury Feel -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap');
        
        .font-serif { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Inter', sans-serif; }
        
        .bg-luxury-dark { background-color: #1a1e24; }
        .text-luxury-dark { color: #1a1e24; }
        .bg-luxury-gold { background-color: #d4af37; }
        .text-luxury-gold { color: #d4af37; }
        .border-luxury-gold { border-color: #d4af37; }
        .hover-bg-luxury-gold:hover { background-color: #bfa136; }
    </style>

    <div class="font-sans text-gray-800 bg-[#fbfbfb]">
        
        <!-- 2. Hero Banner Slider -->
        <section class="relative w-full overflow-hidden aspect-[16/5] min-h-[400px]" x-data="{ 
            activeSlide: 0, 
            slides: {{ $sliderBanners ? $sliderBanners->count() : 0 }},
            init() {
                if(this.slides > 1) {
                    setInterval(() => {
                        this.activeSlide = (this.activeSlide + 1) % this.slides;
                    }, 4000);
                }
            }
        }">
            @if($sliderBanners && $sliderBanners->count() > 0)
                <div class="relative w-full h-full">
                    @foreach($sliderBanners as $index => $banner)
                        <div x-show="activeSlide === {{ $index }}"
                             x-transition:enter="transition-opacity duration-700"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition-opacity duration-700"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="absolute inset-0 w-full h-full">
                            
                            <img src="{{ Storage::url($banner->image_url) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover object-center">
                            
                            <!-- Overlay Gradient -->
                            <div class="absolute inset-0 bg-gradient-to-r from-luxury-dark/80 to-transparent flex items-center">
                                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                                    <div class="max-w-xl text-left text-white">
                                        <h2 class="font-serif text-4xl sm:text-5xl md:text-6xl text-white mb-4 leading-tight">{{ $banner->title }}</h2>
                                        @if($banner->link_url)
                                            <a href="{{ $banner->link_url }}" class="inline-block mt-6 px-8 py-3 bg-white text-luxury-dark font-medium tracking-wide uppercase text-sm hover:bg-luxury-gold hover:text-white transition-colors duration-300">
                                                Shop Now
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($sliderBanners->count() > 1)
                    <!-- Indicators -->
                    <div class="absolute bottom-6 left-0 right-0 flex justify-center space-x-3 z-10">
                        @foreach($sliderBanners as $index => $banner)
                            <button @click="activeSlide = {{ $index }}" 
                                    :class="{'bg-luxury-gold w-8': activeSlide === {{ $index }}, 'bg-white bg-opacity-50 w-2': activeSlide !== {{ $index }}}"
                                    class="h-2 rounded-full focus:outline-none transition-all duration-300"
                                    aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                @endif
            @else
                <div class="w-full h-full bg-slate-900 flex items-center justify-center text-white">
                    <h2 class="font-serif text-4xl">Timeless Elegance</h2>
                </div>
            @endif
        </section>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-24">
            
            <!-- 3. Category Grid Section -->
            <section aria-labelledby="category-heading">
                <div class="flex flex-col items-center mb-10 text-center">
                    <h2 id="category-heading" class="font-serif text-3xl md:text-4xl text-luxury-dark mb-4">Shop by Category</h2>
                    <div class="w-12 h-0.5 bg-luxury-gold"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($categories->take(4) as $category)
                        <a href="{{ route('products.index', ['category' => $category->id]) }}" class="group block relative overflow-hidden bg-white shadow-sm border border-gray-100 h-[280px] hover:shadow-lg transition-all duration-300">
                            <!-- Placeholder for category image if none exists -->
                            <div class="absolute inset-0 bg-gray-50 flex items-center justify-center">
                                <span class="font-serif text-6xl text-gray-200 group-hover:text-luxury-gold transition-colors duration-500 opacity-20 capitalize">{{ substr($category->name, 0, 1) }}</span>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 focus:outline-none"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6 flex items-end">
                                <div>
                                    <h3 class="font-serif text-2xl text-white mb-1 group-hover:-translate-y-1 transition-transform duration-300">{{ $category->name }}</h3>
                                    <p class="text-gray-300 text-sm line-clamp-2 opacity-0 group-hover:opacity-100 group-hover:-translate-y-1 transition-all duration-300">{{ $category->description ?? 'Explore our distinctive collection.' }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>

            <!-- 4. Featured Products Grid -->
            <section aria-labelledby="featured-heading">
                <div class="flex justify-between items-end mb-10">
                    <div>
                        <h2 id="featured-heading" class="font-serif text-3xl md:text-4xl text-luxury-dark mb-4">Featured Watches</h2>
                        <div class="w-12 h-0.5 bg-luxury-gold"></div>
                    </div>
                    <a href="{{ route('products.index') }}" class="text-sm font-semibold text-luxury-dark hover:text-luxury-gold transition-colors tracking-widest uppercase flex items-center gap-2">
                        View Collection <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-x-4 gap-y-10 sm:gap-x-8">
                    @foreach($featuredProducts as $product)
                        <div class="group relative bg-white flex flex-col h-full hover:shadow-xl transition-shadow duration-300 border border-gray-100">
                            <!-- Image Container 1:1 -->
                            <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-100 relative">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    @if($product->image)
                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-700">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 font-serif">View Details</div>
                                    @endif
                                </a>
                                
                                <!-- Stock Badge -->
                                @if($product->stock > 0)
                                    <span class="absolute top-3 right-3 bg-white text-luxury-dark text-[10px] font-bold tracking-wider px-2 py-1 uppercase z-10 shadow-sm">In Stock</span>
                                @else
                                    <span class="absolute top-3 right-3 bg-gray-200 text-gray-600 text-[10px] font-bold tracking-wider px-2 py-1 uppercase z-10 shadow-sm">Out of Stock</span>
                                @endif
                                
                                
                            </div>
                            
                            <!-- Product Details -->
                            <div class="p-4 flex-grow flex flex-col text-center">
                                <span class="text-xs text-gray-500 uppercase tracking-widest mb-2 font-medium">{{ $product->brand->name ?? 'Exclusive' }}</span>
                                <h3 class="font-serif text-lg text-luxury-dark mb-2 line-clamp-2">
                                    <a href="{{ route('products.show', $product->slug) }}" class="hover:text-luxury-gold transition-colors">{{ $product->name }}</a>
                                </h3>
                                <div class="mt-auto pt-2">
                                    <span class="text-sm font-semibold text-luxury-dark">{{ number_format($product->price, 0, ',', '.') }} ₫</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-12 text-center sm:hidden">
                    <a href="{{ route('products.index') }}" class="inline-block border border-luxury-dark px-8 py-3 text-luxury-dark hover:bg-luxury-dark hover:text-white transition-colors uppercase tracking-widest text-xs font-semibold">
                        View Collection
                    </a>
                </div>
            </section>

            <!-- 5. Brand Showcase Strip -->
            <section aria-labelledby="brands-heading" class="border-y border-gray-200 py-12">
                <h2 id="brands-heading" class="sr-only">Our Brands</h2>
                <div class="text-center mb-8">
                    <span class="text-xs text-gray-400 uppercase tracking-[0.2em]">Official Retailer For</span>
                </div>
                <div class="flex overflow-x-auto pb-4 sm:pb-0 hide-scrollbar space-x-8 md:space-x-12 items-center justify-center opacity-70">
                    @foreach($brands as $brand)
                        <div class="flex-shrink-0 group cursor-pointer px-4">
                            <h3 class="font-serif text-xl sm:text-2xl text-gray-500 group-hover:text-luxury-dark transition-colors duration-300">{{ $brand->name }}</h3>
                            <div class="h-0.5 w-0 bg-luxury-gold mx-auto mt-2 transition-all duration-300 group-hover:w-full"></div>
                        </div>
                    @endforeach
                </div>
            </section>

        </div>

        <!-- 6. Promotional Banner (Full-width CTA) -->
        <section class="w-full relative py-24 sm:py-32 overflow-hidden bg-luxury-dark">
            @if($promoBanner)
                <div class="absolute inset-0">
                    <img src="{{ Storage::url($promoBanner->image_url) }}" alt="Promotion" class="w-full h-full object-cover object-center opacity-40">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-luxury-dark via-transparent to-transparent"></div>
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white z-10">
                    <span class="block text-luxury-gold text-sm tracking-[0.2em] uppercase mb-4">{{ $promoBanner->title }}</span>
                    <h2 class="font-serif text-4xl sm:text-5xl md:text-6xl mb-8 leading-tight max-w-3xl mx-auto">Discover the Art of Horology.</h2>
                    @if($promoBanner->link_url)
                        <a href="{{ $promoBanner->link_url }}" class="inline-block bg-luxury-gold text-white px-10 py-4 font-medium tracking-widest uppercase hover:bg-white hover:text-luxury-dark transition-all duration-300 shadow-xl">
                            Explore Now
                        </a>
                    @endif
                </div>
            @else
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white z-10">
                    <span class="block text-luxury-gold text-sm tracking-[0.2em] uppercase mb-4">Limited Edition</span>
                    <h2 class="font-serif text-4xl sm:text-5xl md:text-6xl mb-8 leading-tight max-w-3xl mx-auto">A Legacy of Precision.</h2>
                    <a href="{{ route('products.index') }}" class="inline-block bg-luxury-gold text-white px-10 py-4 font-medium tracking-widest uppercase hover:bg-white hover:text-luxury-dark transition-all duration-300">
                        View All Collections
                    </a>
                </div>
            @endif
        </section>

    </div>
    
    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</x-customer>
