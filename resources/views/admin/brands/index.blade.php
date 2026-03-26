@extends('layouts.admin')

@section('header', 'Thương Hiệu')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Thương Hiệu</h2>
        <p class="text-sm text-gray-500 mt-1">Quản lý các thương hiệu sản phẩm trong cửa hàng của bạn.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.brands.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition-colors">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Thêm Thương Hiệu
        </a>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-700 text-sm border-b border-gray-200">
                    <th class="px-6 py-4 font-semibold w-16">ID</th>
                    <th class="px-6 py-4 font-semibold">Thông tin Thương hiệu</th>
                    <th class="px-6 py-4 font-semibold text-center">Quốc gia</th>
                    <th class="px-6 py-4 font-semibold text-center w-32">Sản phẩm</th>
                    <th class="px-6 py-4 font-semibold text-right w-32">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse($brands as $brand)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-gray-500 font-medium">#{{ $brand->id }}</td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $brand->name }}</div>
                        @if($brand->description)
                            <div class="text-gray-500 text-xs mt-1 truncate max-w-xs">{{ Str::limit($brand->description, 50) }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($brand->country)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                {{ $brand->country }}
                            </span>
                        @else
                            <span class="text-gray-400 text-xs italic">Không có</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center justify-center min-w-[2rem] h-8 rounded-full bg-indigo-50 text-indigo-700 font-semibold px-2">
                            {{ $brand->products_count ?? $brand->products()->count() }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.brands.edit', $brand) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Sửa">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chăn chắn muốn xóa thương hiệu này không?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Xóa">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <p class="text-base font-medium text-gray-900 mb-1">Không tìm thấy thương hiệu nào</p>
                            <a href="{{ route('admin.brands.create') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Tạo thương hiệu đầu tiên của bạn</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(isset($brands) && method_exists($brands, 'hasPages') && $brands->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $brands->links() }}
    </div>
    @endif
</div>
@endsection
