@extends('layouts.admin')

@section('header', 'Edit Brand')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.brands.index') }}" class="hover:text-indigo-600 transition-colors">Brands</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">Edit</span>
    </div>
    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Brand</h2>
    <p class="text-sm text-gray-500 mt-1">Update details for the brand.</p>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden max-w-3xl">
    <form action="{{ route('admin.brands.update', $brand) }}" method="POST" class="p-6 sm:p-8">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Brand Name <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $brand->name) }}" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" required>
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                <input type="text" id="country" name="country" value="{{ old('country', $brand->country) }}" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                @error('country') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description" name="description" rows="4" class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">{{ old('description', $brand->description) }}</textarea>
                @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-8 pt-5 border-t border-gray-200 flex items-center justify-end gap-3">
            <a href="{{ route('admin.brands.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm transition-colors">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
