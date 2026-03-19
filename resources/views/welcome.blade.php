<x-customer>
    <!-- ✅ reviewed -->
    <!-- Hero Banner Slider -->
    @if($banners->count() > 0)
        <div class="relative w-full overflow-hidden aspect-[16/6] min-h-[400px]" x-data="{ 
            activeSlide: 0, 
            slides: {{ $banners->count() }},
            init() {
                if(this.slides > 1) {
                    setInterval(() => {
                        this.activeSlide = (this.activeSlide + 1) % this.slides;
                    }, 4000);
                }
            }
        }">
            <!-- Slides -->
            <div class="relative w-full h-full">
                @foreach($banners as $index => $banner)
                    <div x-show="activeSlide === {{ $index }}"
                         x-transition:enter="transition-opacity duration-700"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition-opacity duration-700"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="absolute inset-0 w-full h-full">
                        
                        @if($banner->link_url)
                            <a href="{{ $banner->link_url }}" class="block w-full h-full">
                        @endif
                        
                        <img src="{{ Storage::url($banner->image_url) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-luxury-dark/80 to-transparent flex items-end justify-center pb-16">
                            <div class="text-center px-4 max-w-3xl">
                                <h2 class="text-3xl md:text-5xl lg:text-6xl font-serif text-white tracking-wide mb-4">{{ $banner->title }}</h2>
                                @if($banner->link_url)
                                    <span class="inline-block border-b border-luxury-gold text-white pb-1 font-semibold uppercase tracking-widest text-sm hover:text-luxury-gold transition-colors">Discover</span>
                                @endif
                            </div>
                        </div>
                        
                        @if($banner->link_url)
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Controls -->
            @if($banners->count() > 1)
                <button @click="activeSlide = activeSlide === 0 ? slides - 1 : activeSlide - 1" class="absolute left-4 top-1/2 -translate-y-1/2 p-3 bg-white/10 hover:bg-white/20 text-white transition-colors focus:outline-none rounded-full backdrop-blur-sm">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button @click="activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1" class="absolute right-4 top-1/2 -translate-y-1/2 p-3 bg-white/10 hover:bg-white/20 text-white transition-colors focus:outline-none rounded-full backdrop-blur-sm">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"></path></svg>
                </button>
                
                <!-- Indicators -->
                <div class="absolute bottom-6 left-0 right-0 flex justify-center space-x-3">
                    @foreach($banners as $index => $banner)
                        <button @click="activeSlide = {{ $index }}" 
                                :class="{'bg-luxury-gold w-8': activeSlide === {{ $index }}, 'bg-white/50 w-2 hover:bg-white': activeSlide !== {{ $index }}}"
                                class="h-2 rounded-full focus:outline-none transition-all duration-300"></button>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-24">
        
        <!-- Top 5 Most Purchased Products -->
        <section>
            <div class="flex flex-col items-center mb-12 text-center">
                <h2 class="text-3xl md:text-4xl font-serif text-luxury-dark tracking-tight mb-4">Top Best Sellers</h2>
                <div class="w-12 h-0.5 bg-luxury-gold"></div>
                <p class="mt-6 text-gray-500 uppercase tracking-widest text-xs font-semibold max-w-2xl">Proven classics for the modern connoisseur</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach($topPurchasedProducts as $index => $product)
                    <div class="bg-white group flex flex-col h-full relative border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                        <!-- Rank Badge -->
                        <div class="absolute top-0 right-0 z-10 w-8 h-8 bg-luxury-dark text-luxury-gold flex items-center justify-center font-serif text-sm">
                            #{{ $index + 1 }}
                        </div>

                        <div class="relative w-full aspect-[4/3] overflow-hidden bg-gray-50">
                            <a href="#">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover mix-blend-darken group-hover:scale-105 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 group-hover:scale-105 transition-transform duration-700 font-serif">View Details</div>
                                @endif
                            </a>
                        </div>
                        <div class="p-5 flex flex-col flex-grow text-center">
                            <div class="text-[10px] text-gray-500 mb-2 font-bold tracking-widest uppercase">{{ $product->brand->name ?? 'Premium' }}</div>
                            <h3 class="text-base font-serif text-luxury-dark mb-3 line-clamp-2 leading-snug">
                                <a href="#" class="hover:text-luxury-gold transition-colors">{{ $product->name }}</a>
                            </h3>
                            <div class="mt-auto pt-4 border-t border-gray-100 flex flex-col items-center">
                                <span class="text-sm font-semibold text-luxury-dark mb-3">{{ number_format($product->price, 0, ',', '.') }} ₫</span>
                                <button class="text-xs uppercase tracking-widest font-semibold border-b border-luxury-dark pb-1 hover:text-luxury-gold hover:border-luxury-gold transition-colors" title="Add to cart">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- New Arrivals -->
        <section class="bg-luxury-dark py-16 px-4 sm:px-6 lg:px-8 -mx-4 sm:-mx-6 lg:-mx-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col md:flex-row justify-between items-end mb-12">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-serif text-white tracking-tight mb-4">New Arrivals</h2>
                        <div class="w-12 h-0.5 bg-luxury-gold"></div>
                        <p class="mt-6 text-gray-400 uppercase tracking-widest text-xs font-semibold">Fresh additions to our collection</p>
                    </div>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center text-xs font-semibold text-luxury-gold hover:text-white uppercase tracking-widest transition-colors mt-6 md:mt-0">
                        View All <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($newestProducts as $product)
                        <div class="bg-white/5 border border-white/10 group flex flex-col text-center hover:bg-white/10 transition-colors duration-300">
                            <div class="relative w-full aspect-[4/3] overflow-hidden p-6 bg-white/5">
                                <a href="#" class="block w-full h-full relative">
                                    @if($product->image)
                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-700 drop-shadow-lg">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-500 font-serif">No Image</div>
                                    @endif
                                </a>
                                <!-- Quick Add Overlay Button -->
                                <div class="absolute inset-x-0 bottom-0 p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-4 group-hover:translate-y-0">
                                    <button class="w-full bg-luxury-gold text-white py-3 px-4 text-xs font-semibold uppercase tracking-widest hover:bg-white hover:text-luxury-dark transition-colors duration-300">Quick Add</button>
                                </div>
                            </div>
                            <div class="p-6 w-full flex flex-col flex-grow">
                                <div class="text-[10px] text-gray-400 mb-2 font-bold tracking-widest uppercase">{{ $product->category->name ?? 'Uncategorized' }}</div>
                                <h3 class="text-base font-serif text-white mb-3 line-clamp-1">
                                    <a href="#" class="hover:text-luxury-gold transition-colors">{{ $product->name }}</a>
                                </h3>
                                <div class="mt-auto">
                                    <span class="text-sm font-semibold text-luxury-gold">{{ number_format($product->price, 0, ',', '.') }} ₫</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Top 10 Most Viewed Products -->
        <section>
            <div class="flex flex-col items-center mb-12 text-center">
                <h2 class="text-3xl md:text-4xl font-serif text-luxury-dark tracking-tight mb-4">Trending Now</h2>
                <div class="w-12 h-0.5 bg-luxury-gold"></div>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-6">
                @foreach($mostViewedProducts as $product)
                    <div class="bg-white border border-gray-100 hover:border-luxury-gold hover:shadow-lg transition-all duration-300 group flex flex-col">
                        <div class="relative w-full aspect-[4/3] overflow-hidden bg-gray-50 p-4">
                            <a href="#">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain mix-blend-darken group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs uppercase tracking-widest">No Image</div>
                                @endif
                                
                                <!-- Hover Eye Icon -->
                                <div class="absolute inset-0 bg-white/40 backdrop-blur-[2px] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="bg-luxury-dark p-3 rounded-full shadow-xl text-white">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="p-4 text-center flex flex-col flex-grow">
                            <div class="text-[9px] text-gray-400 mb-1 uppercase tracking-widest font-bold">{{ $product->brand->name ?? '' }}</div>
                            <h3 class="text-sm font-serif text-luxury-dark mb-2 px-1 line-clamp-1">
                                <a href="#" class="hover:text-luxury-gold transition-colors">{{ $product->name }}</a>
                            </h3>
                            <div class="mt-auto text-sm font-semibold text-luxury-dark">{{ number_format($product->price, 0, ',', '.') }} ₫</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        
    </div>
</x-customer>
