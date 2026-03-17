<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', true)->orderBy('sort_order')->get();
        // Separate banners for slider and promo
        $sliderBanners = $banners->count() > 1 ? $banners->take($banners->count() - 1) : $banners;
        $promoBanner = $banners->count() > 1 ? $banners->last() : $banners->first();
        
        $categories = Category::all();
        $brands = Brand::all();
        
        $featuredProducts = Product::with(['category', 'brand'])
                                   ->where('status', true)
                                   ->latest()
                                   ->take(8)
                                   ->get();

        $newestProducts = Product::with(['category', 'brand'])
                                   ->where('status', true)
                                   ->latest()
                                   ->take(8)
                                   ->get();

        // Top 5 Most Purchased Products joining with order_items
        $topPurchasedIds = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->pluck('product_id');

        // Note: Maintaining strict order based on total_sold requires a manual sort after fetch 
        // or a raw order by case if preferred. We'll simply query them and sort by collection if needed.
        $topPurchasedProducts = $topPurchasedIds->count() > 0 
            ? Product::with(['category', 'brand'])->whereIn('id', $topPurchasedIds)->where('status', true)->get()->sortBy(function($model) use ($topPurchasedIds) {
                return array_search($model->id, $topPurchasedIds->toArray());
            })
            : Product::with(['category', 'brand'])->where('status', true)->inRandomOrder()->take(5)->get();

        // 10 "Most Viewed" (acting as random featured because there's no views count in schema right now)
        $mostViewedProducts = Product::with(['category', 'brand'])
                                   ->where('status', true)
                                   ->inRandomOrder()
                                   ->take(10)
                                   ->get();

        return view('home', compact('sliderBanners', 'promoBanner', 'categories', 'brands', 'featuredProducts', 'newestProducts', 'topPurchasedProducts', 'mostViewedProducts'));
    }
}
