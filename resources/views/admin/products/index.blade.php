@extends('layouts.admin')

@section('header', 'Products')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Products</h2>
        <p class="text-sm text-gray-500 mt-1">Manage your catalog, stock, and pricing.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.products.index', ['trashed' => request('trashed') ? null : '1']) }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 shadow-sm transition-colors">
            {{ request('trashed') ? 'Show Active' : 'Show Trashed' }}
        </a>
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm transition-colors">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Add Product
        </a>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-700 text-sm border-b border-gray-200">
                    <th class="px-6 py-4 font-semibold w-24">Image</th>
                    <th class="px-6 py-4 font-semibold">Product Info</th>
                    <th class="px-6 py-4 font-semibold text-center">Category/Brand</th>
                    <th class="px-6 py-4 font-semibold text-right">Price</th>
                    <th class="px-6 py-4 font-semibold text-center">Stock</th>
                    <th class="px-6 py-4 font-semibold text-center">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition-colors group {{ $product->trashed() ? 'opacity-70 bg-gray-50' : '' }}">
                    <td class="px-6 py-4">
                        <div class="w-12 h-12 rounded-lg border border-gray-200 overflow-hidden flex items-center justify-center bg-gray-50">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://img.icons8.com/color/1200/no-image.jpg" alt="No image" class="w-full h-full object-cover opacity-50">
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900 line-clamp-2" title="{{ $product->name }}">{{ $product->name }}</div>
                        <div class="text-xs text-gray-500 mt-1">#{{ $product->id }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="text-sm text-gray-900">{{ $product->category->name ?? 'N/A' }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ $product->brand->name ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="font-semibold text-gray-900 whitespace-nowrap">${{ number_format($product->price, 0, '.', ',') }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($product->trashed())
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Deleted
                            </span>
                        @else
                            <form action="{{ route('admin.products.toggle', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="relative inline-flex items-center h-6 rounded-full w-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors ease-in-out duration-200 {{ $product->status ? 'bg-green-500' : 'bg-gray-200' }}">
                                    <span class="sr-only">Toggle Status</span>
                                    <span class="inline-block w-4 h-4 transform bg-white rounded-full transition ease-in-out duration-200 {{ $product->status ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                </button>
                            </form>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors tooltip-trigger" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            
                            @if($product->trashed())
                                <form action="{{ route('admin.products.restore', $product->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors tooltip-trigger" title="Restore">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to move this product to trash?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors tooltip-trigger" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            <p class="text-base font-medium text-gray-900 mb-1">No products found</p>
                            <p class="text-sm text-gray-500 mb-4">Get started by creating a new product.</p>
                            <a href="{{ route('admin.products.create') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Add your first product</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(isset($products) && method_exists($products, 'hasPages') && $products->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection