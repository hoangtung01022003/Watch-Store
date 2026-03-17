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
        $query = Product::where('status', true)->with(['category', 'brand']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        $products = $query->paginate(12)->appends($request->query());

        $categories = Category::all();
        $brands = Brand::all();

        return view('products.index', compact('products', 'categories', 'brands'));
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

        return view('products.show', compact('product', 'mainImage', 'thumbs', 'specs', 'relatedProducts'));
    }
}
