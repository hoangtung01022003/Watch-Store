@extends('layouts.admin')

@section('header', 'Edit Product')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.products.index') }}" class="hover:text-indigo-600 transition-colors">Products</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">Edit</span>
    </div>
    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Product: {{ $product->name }}</h2>
    <p class="text-sm text-gray-500 mt-1">Update details for this watch product.</p>
</div>

<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Info -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-100 pb-3">Basic Information</h3>
                
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" required>
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                            <select id="category_id" name="category_id" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-1">Brand <span class="text-red-500">*</span></label>
                            <select id="brand_id" name="brand_id" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500" required>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea id="description" name="description" rows="5" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">{{ old('description', $product->description) }}</textarea>
                        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Specifications -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-100 pb-3">Technical Specifications</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="case_size" class="block text-sm font-medium text-gray-700 mb-1">Case Size</label>
                        <input type="text" id="case_size" name="case_size" value="{{ old('case_size', $product->specs->case_size ?? '') }}" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('case_size') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="water_resistance" class="block text-sm font-medium text-gray-700 mb-1">Water Resistance</label>
                        <input type="text" id="water_resistance" name="water_resistance" value="{{ old('water_resistance', $product->specs->water_resistance ?? '') }}" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('water_resistance') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="strap_material" class="block text-sm font-medium text-gray-700 mb-1">Strap Material</label>
                        <input type="text" id="strap_material" name="strap_material" value="{{ old('strap_material', $product->specs->strap_material ?? '') }}" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('strap_material') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="movement" class="block text-sm font-medium text-gray-700 mb-1">Movement</label>
                        <input type="text" id="movement" name="movement" value="{{ old('movement', $product->specs->movement ?? '') }}" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('movement') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="glass_type" class="block text-sm font-medium text-gray-700 mb-1">Glass Type</label>
                        <input type="text" id="glass_type" name="glass_type" value="{{ old('glass_type', $product->specs->glass_type ?? '') }}" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('glass_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Column -->
        <div class="space-y-6">
            <!-- Pricing & Status -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-100 pb-3">Pricing & Inventory</h3>
                
                <div class="space-y-4">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price ($) <span class="text-red-500">*</span></label>
                        <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500" required>
                        @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock <span class="text-red-500">*</span></label>
                        <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500" required>
                        @error('stock') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="status" value="1" class="sr-only peer" {{ old('status', $product->status) ? 'checked' : '' }}>
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                            <span class="ms-3 text-sm font-medium text-gray-700">Product is active</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Media -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-100 pb-3">Media</h3>
                
                <div class="space-y-4">
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Main Image</label>
                        @if($product->image)
                            <div class="mb-3 w-32 h-32 rounded-lg border border-gray-200 overflow-hidden bg-gray-50 flex items-center justify-center">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                        <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-300 rounded-lg p-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                        <p class="mt-1 text-xs text-gray-500">Leave empty to keep current image. JPG, PNG, WEBP up to 2MB.</p>
                        @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="pt-2 border-t border-gray-100">
                        <label for="gallery" class="block text-sm font-medium text-gray-700 mb-1">Add More Gallery Images</label>
                        <input type="file" id="gallery" name="gallery[]" accept="image/jpeg,image/png,image/jpg,image/webp" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 border border-gray-300 rounded-lg p-1.5 focus:ring-gray-500 focus:border-gray-500">
                        @error('gallery.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        
                        @if($product->images->count() > 0)
                            <div class="mt-3 grid grid-cols-4 gap-2">
                                @foreach($product->images as $img)
                                    <div class="relative w-full aspect-square rounded border border-gray-200 overflow-hidden group">
                                        <img src="{{ asset('storage/' . $img->image_url) }}" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-6 bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center justify-end gap-3">
        <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
            Cancel
        </a>
        <button type="submit" class="px-5 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm transition-colors">
            Save Changes
        </button>
    </div>
</form>
@endsection