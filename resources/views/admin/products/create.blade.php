@extends('layouts.admin')

@section('header', 'Add Product')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.products.index') }}" class="hover:text-indigo-600 transition-colors">Products</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">Create</span>
    </div>
    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Add New Product</h2>
    <p class="text-sm text-gray-500 mt-1">Create a new watch product for your store.</p>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Info -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-100 pb-3">Basic Information</h3>
                
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="e.g. Rolex Submariner" required>
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                            <select id="category_id" name="category_id" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="" disabled selected>Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-1">Brand <span class="text-red-500">*</span></label>
                            <select id="brand_id" name="brand_id" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="" disabled selected>Select a brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea id="description" name="description" rows="5" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="Detailed product description...">{{ old('description') }}</textarea>
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
                        <input type="text" id="case_size" name="case_size" value="{{ old('case_size') }}" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g. 40mm">
                        @error('case_size') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="water_resistance" class="block text-sm font-medium text-gray-700 mb-1">Water Resistance</label>
                        <input type="text" id="water_resistance" name="water_resistance" value="{{ old('water_resistance') }}" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g. 50m">
                        @error('water_resistance') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="strap_material" class="block text-sm font-medium text-gray-700 mb-1">Strap Material</label>
                        <input type="text" id="strap_material" name="strap_material" value="{{ old('strap_material') }}" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g. Stainless Steel">
                        @error('strap_material') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="movement" class="block text-sm font-medium text-gray-700 mb-1">Movement</label>
                        <input type="text" id="movement" name="movement" value="{{ old('movement') }}" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g. Automatic">
                        @error('movement') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="glass_type" class="block text-sm font-medium text-gray-700 mb-1">Glass Type</label>
                        <input type="text" id="glass_type" name="glass_type" value="{{ old('glass_type') }}" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g. Sapphire Crystal">
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
                        <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500" required>
                        @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Initial Stock <span class="text-red-500">*</span></label>
                        <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}" min="0" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500" required>
                        @error('stock') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="status" value="1" class="sr-only peer" {{ old('status', true) ? 'checked' : '' }}>
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
                    <div x-data="mainImageUpload()">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Main Image</label>
                        
                        <div x-show="preview" class="mb-3 rounded-lg overflow-hidden border border-gray-200 w-32 h-32 relative group" style="display: none;">
                            <img :src="preview" alt="Preview image" class="w-full h-full object-cover">
                            <button type="button" @click="removePreview()" class="absolute top-1 right-1 bg-gray-700/80 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-500 focus:outline-none shadow-sm m-0 p-0 transition-colors opacity-0 group-hover:opacity-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <div x-show="!preview">
                            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" @change="handleFileChange" x-ref="fileInput" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-300 rounded-lg p-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                            <p class="mt-1 text-xs text-gray-500">JPG, PNG, WEBP up to 2MB.</p>
                        </div>
                        @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="pt-2 border-t border-gray-100" x-data="galleryUpload()">
                        <label for="gallery" class="block text-sm font-medium text-gray-700 mb-1">Additional Images</label>
                        
                        <div class="mb-3 flex flex-wrap pb-2 gap-3" x-show="previewImages.length > 0" style="display: none;">
                            <template x-for="(img, index) in previewImages" :key="'preview-'+index">
                                <div class="relative w-20 h-20 flex-none rounded-md overflow-hidden border border-green-300 group">
                                    <img :src="img.url" alt="Preview image" class="w-full h-full object-cover">
                                    <button type="button" @click="removePreview(index)" class="absolute top-1 right-1 bg-gray-700/80 text-white rounded-full w-5 h-5 flex items-center justify-center hover:bg-red-500 focus:outline-none shadow-sm m-0 p-0 transition-colors opacity-0 group-hover:opacity-100">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            </template>
                        </div>

                        <div>
                            <input type="file" id="gallery" name="gallery[]" accept="image/jpeg,image/png,image/jpg,image/webp" multiple @change="handleFileChange" x-ref="fileInput" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 border border-gray-300 rounded-lg p-1.5 focus:ring-gray-500 focus:border-gray-500">
                            <p class="mt-1 text-xs text-gray-500">You can upload multiple additional images.</p>
                        </div>

                        @error('gallery.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
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
            Save Product
        </button>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        if (!Alpine.data('mainImageUpload')) {
            Alpine.data('mainImageUpload', () => ({
                preview: null,
                
                handleFileChange(event) {
                    const file = event.target.files[0];
                    if (file) {
                        if (this.preview) URL.revokeObjectURL(this.preview);
                        this.preview = URL.createObjectURL(file);
                    }
                },
                
                removePreview() {
                    if (this.preview) {
                        URL.revokeObjectURL(this.preview);
                    }
                    this.preview = null;
                    if(this.$refs.fileInput) this.$refs.fileInput.value = '';
                }
            }));
        }

        if (!Alpine.data('galleryUpload')) {
            Alpine.data('galleryUpload', (initialImages = []) => ({
                existingImages: initialImages,
                previewImages: [],
                files: [],

                handleFileChange(event) {
                    const selectedFiles = Array.from(event.target.files);
                    
                    selectedFiles.forEach(file => {
                        const isDuplicate = this.files.some(f => f.name === file.name && f.size === file.size && f.lastModified === file.lastModified);
                        
                        if (!isDuplicate) {
                            this.files.push(file);
                            this.previewImages.push({
                                url: URL.createObjectURL(file),
                                file: file
                            });
                        }
                    });
                    
                    this.updateFileInput();
                },

                removePreview(index) {
                    URL.revokeObjectURL(this.previewImages[index].url);
                    this.previewImages.splice(index, 1);
                    this.files.splice(index, 1);
                    this.updateFileInput();
                },

                updateFileInput() {
                    const dataTransfer = new DataTransfer();
                    this.files.forEach(file => dataTransfer.items.add(file));
                    this.$refs.fileInput.files = dataTransfer.files;
                }
            }));
        }
    });
</script>
@endpush
@endsection