@extends('layouts.admin')

@section('header', 'Edit Banner')

@section('content')
<div class="mb-6 flex items-center gap-2 text-sm text-gray-500">
    <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
    <span>/</span>
    <a href="{{ route('admin.banners.index') }}" class="hover:text-indigo-600 transition-colors">Banners</a>
    <span>/</span>
    <span class="text-gray-900 font-medium">Edit</span>
</div>

<div class="max-w-3xl">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Banner: {{ $banner->title }}</h2>
        <p class="text-sm text-gray-500 mt-1">Update details for this promotional banner.</p>
    </div>

    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-6">
        @csrf
        @method('PUT')
        
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Banner Title <span class="text-red-500">*</span></label>
            <input type="text" id="title" name="title" value="{{ old('title', $banner->title) }}" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500" required>
            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="link_url" class="block text-sm font-medium text-gray-700 mb-1">Target Link URL</label>
            <input type="url" id="link_url" name="link_url" value="{{ old('link_url', $banner->link_url) }}" placeholder="https://example.com/promo" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
            @error('link_url') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}" min="0" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
                <p class="text-xs text-gray-500 mt-1">Lower numbers appear first.</p>
                @error('sort_order') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center pt-6">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    <span class="ms-3 text-sm font-medium text-gray-700">Banner is Active</span>
                </label>
            </div>
        </div>

        <div x-data="bannerEditUpload('{{ $banner->image_url ? Storage::url($banner->image_url) : '' }}')">
            <label class="block text-sm font-medium text-gray-700 mb-1">Banner Image <span class="text-red-500">*</span></label>
            
            <div x-show="preview || existingImage" class="mb-4 relative rounded-lg border border-gray-200 overflow-hidden w-full max-w-lg aspect-[21/9]" style="display: none;">
                <img :src="preview || existingImage" class="w-full h-full object-cover">
                <button type="button" @click="removePreview()" class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center shadow hover:bg-red-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div x-show="!(preview || existingImage)">
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" @change="handleFileChange" x-ref="fileInput" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-300 rounded-lg p-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                <p class="text-xs text-gray-500 mt-1">Recommended size: 1920x820px, Max 4MB. Leave empty to keep current image.</p>
            </div>
            @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
            <a href="{{ route('admin.banners.index') }}" class="px-5 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">Cancel</a>
            <button type="submit" class="px-5 py-2.5 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-sm">Update Banner</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('bannerEditUpload', (existingUrl) => ({
            existingImage: existingUrl,
            preview: null,
            handleFileChange(event) {
                const file = event.target.files[0];
                if (file) {
                    if (this.preview) URL.revokeObjectURL(this.preview);
                    this.preview = URL.createObjectURL(file);
                    this.existingImage = null; // hide existing if new is picked
                }
            },
            removePreview() {
                if (this.preview) URL.revokeObjectURL(this.preview);
                this.preview = null;
                this.existingImage = null;
                if(this.$refs.fileInput) this.$refs.fileInput.value = '';
            }
        }));
    });
</script>
@endpush
@endsection