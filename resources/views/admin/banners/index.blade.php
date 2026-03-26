@extends('layouts.admin')

@section('header', 'Banner')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Banner</h2>
        <p class="text-sm text-gray-500 mt-1">Quản lý slider trang chủ và các banner quảng cáo.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.banners.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm transition-colors">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Thêm Banner
        </a>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-700 text-sm border-b border-gray-200">
                    <th class="px-6 py-4 font-semibold w-32">Hình ảnh</th>
                    <th class="px-6 py-4 font-semibold">Tiêu đề & Liên kết</th>
                    <th class="px-6 py-4 font-semibold text-center w-24">Thứ tự</th>
                    <th class="px-6 py-4 font-semibold text-center w-32">Trạng thái</th>
                    <th class="px-6 py-4 font-semibold text-right w-32">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse($banners as $banner)
                <tr class="hover:bg-gray-50 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="w-24 h-12 rounded-lg bg-gray-100 overflow-hidden border border-gray-200">
                            @if($banner->image_url)
                                <img src="{{ asset('storage/' . $banner->image_url) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://img.icons8.com/color/1200/no-image.jpg" alt="Không có hình" class="w-full h-full object-cover opacity-50">
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $banner->title }}</div>
                        @if($banner->link_url)
                            <a href="{{ $banner->link_url }}" target="_blank" class="text-xs text-indigo-600 hover:text-indigo-800 mt-1 block truncate max-w-xs">{{ $banner->link_url }}</a>
                        @else
                            <div class="text-xs text-gray-500 mt-1">Không có liên kết</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 text-gray-700 font-medium text-xs">
                            {{ $banner->sort_order }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('admin.banners.toggle', $banner->id) }}" method="POST" class="inline-block m-0 p-0">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="focus:outline-none relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 {{ $banner->is_active ? 'bg-indigo-600' : 'bg-gray-200' }}" title="{{ $banner->is_active ? 'Nhấn để vô hiệu hóa' : 'Nhấn để kích hoạt' }}">
                                <span class="sr-only">Chuyển đổi trạng thái</span>
                                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $banner->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.banners.edit', $banner->id) }}" class="p-2 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors tooltip-trigger" title="Sửa">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            
                            <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa banner này không?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors tooltip-trigger" title="Xóa">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <p class="text-base font-medium text-gray-900 mb-1">Không tìm thấy banner nào</p>
                            <p class="text-sm text-gray-500 mb-4">Bắt đầu bằng cách tạo một banner mới.</p>
                            <a href="{{ route('admin.banners.create') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Thêm banner đầu tiên của bạn</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(isset($banners) && $banners->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $banners->links() }}
    </div>
    @endif
</div>
@endsection