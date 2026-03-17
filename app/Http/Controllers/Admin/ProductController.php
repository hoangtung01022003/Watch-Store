<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use App\Models\ProductSpec;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand']);
        
        if ($request->has('trashed')) {
            $query->onlyTrashed();
        }

        $products = $query->latest()->paginate(10);
        
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'boolean',
            'case_size' => 'nullable|string|max:255',
            'water_resistance' => 'nullable|string|max:255',
            'strap_material' => 'nullable|string|max:255',
            'movement' => 'nullable|string|max:255',
            'glass_type' => 'nullable|string|max:255',
        ]);

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;
        while (Product::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => $request->has('status'),
        ]);

        $product->specs()->create([
            'case_size' => $request->case_size,
            'water_resistance' => $request->water_resistance,
            'strap_material' => $request->strap_material,
            'movement' => $request->movement,
            'glass_type' => $request->glass_type,
        ]);

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $galleryPath = $file->store('products/gallery', 'public');
                $product->images()->create([
                    'image_url' => $galleryPath,
                    'is_main' => false,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::withTrashed()->with(['specs', 'images'])->findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'boolean',
            'case_size' => 'nullable|string|max:255',
            'water_resistance' => 'nullable|string|max:255',
            'strap_material' => 'nullable|string|max:255',
            'movement' => 'nullable|string|max:255',
            'glass_type' => 'nullable|string|max:255',
        ]);

        $slug = $product->slug;
        if ($product->name !== $request->name) {
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $count = 1;
            while (Product::withTrashed()->where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
        }

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'status' => $request->has('status'),
        ]);

        $product->specs()->updateOrCreate(
            ['product_id' => $product->id],
            [
                'case_size' => $request->case_size,
                'water_resistance' => $request->water_resistance,
                'strap_material' => $request->strap_material,
                'movement' => $request->movement,
                'glass_type' => $request->glass_type,
            ]
        );

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $galleryPath = $file->store('products/gallery', 'public');
                $product->images()->create([
                    'image_url' => $galleryPath,
                    'is_main' => false,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete(); // Soft delete
        return redirect()->route('admin.products.index')->with('success', 'Product moved to trash.');
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('admin.products.index')->with('success', 'Product restored successfully.');
    }

    public function toggleStatus($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->update(['status' => !$product->status]);
        return back()->with('success', 'Product status updated.');
    }
}
