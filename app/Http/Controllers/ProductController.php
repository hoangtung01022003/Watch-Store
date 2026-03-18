<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Normalize arrays for category_id and brand_id
        $categoryIds = $request->has('category_id') ? (array) $request->category_id : [];
        $brandIds = $request->has('brand_id') ? (array) $request->brand_id : [];

        $filters = [
            'search' => $request->search,
            'category_id' => $categoryIds,
            'brand_id' => $brandIds,
            'min_price' => $request->min_price,
            'max_price' => $request->max_price,
            'sort' => $request->sort,
        ];

        $query = Product::query()
            ->where('status', true)
            ->with(['category', 'brand'])
            ->filter($filters);

        // Sorting logic
        if ($filters['sort'] === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($filters['sort'] === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->appends($request->query());

        $categories = Category::all();
        $brands = Brand::all();

        return view('products.index', compact('products', 'categories', 'brands', 'filters'));
    }

    public function show($slug)
    {
        $product = Product::with(['images', 'specs', 'category', 'brand'])
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        // Find main image or fallback to the first available image
        $mainImage = $product->images->where('is_main', true)->first() 
            ?? $product->images->first();

        // Exclude the main image from the thumbnail gallery
        $thumbs = $product->images->reject(function ($image) use ($mainImage) {
            return $mainImage && $image->id === $mainImage->id;
        });

        // Specs (assuming it's a hasMany or hasOne, we get the first record)
        $specs = $product->specs->first();

        // Related products in the same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', true)
            ->with(['brand'])
            ->limit(4)
            ->get();

        // Previous and Next Product Navigation
        $prevProduct = Product::where('category_id', $product->category_id)
            ->where('id', '<', $product->id)
            ->where('status', true)
            ->orderBy('id', 'desc')
            ->first();

        $nextProduct = Product::where('category_id', $product->category_id)
            ->where('id', '>', $product->id)
            ->where('status', true)
            ->orderBy('id', 'asc')
            ->first();

        return view('products.show', compact('product', 'mainImage', 'thumbs', 'specs', 'relatedProducts', 'prevProduct', 'nextProduct'));
    }
}
