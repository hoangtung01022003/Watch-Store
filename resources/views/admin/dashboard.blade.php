@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Tổng quan Bảng điều khiển</h2>
        <p class="text-sm text-gray-500 mt-1">Những gì đang diễn ra với cửa hàng của bạn hôm nay.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm transition-colors">
            Quản lý Danh mục
        </a>
        <a href="{{ route('admin.brands.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm transition-colors">
            Quản lý Thương hiệu
        </a>
        <button class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm transition-colors flex items-center">
            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Thêm Sản phẩm
        </button>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat Card 1 -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-medium text-gray-500">Tổng doanh thu</h3>
            <span class="p-2 bg-green-50 text-green-600 rounded-lg">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
        </div>
        <div class="mt-4 flex items-baseline">
            <p class="text-3xl font-bold text-gray-900">${{ number_format($totalRevenue ?? 0, 2) }}</p>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-medium text-gray-500">Sản phẩm</h3>
            <span class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </span>
        </div>
        <div class="mt-4 flex items-baseline">
            <p class="text-3xl font-bold text-gray-900">{{ number_format($totalProducts ?? 0) }}</p>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-medium text-gray-500">Danh mục & Thương hiệu</h3>
            <span class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
            </span>
        </div>
        <div class="mt-4 flex items-baseline">
             <p class="text-3xl font-bold text-gray-900">{{ number_format($totalCategories ?? 0) }} / {{ number_format($totalBrands ?? 0) }}</p>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-medium text-gray-500">Đơn hàng chờ xử lý</h3>
            <span class="p-2 bg-amber-50 text-amber-600 rounded-lg">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
        </div>
        <div class="mt-4 flex items-baseline">
            <p class="text-3xl font-bold text-gray-900">{{ number_format($pendingOrdersCount ?? 0) }}</p>
        </div>
    </div>
</div>

<!-- Main Table Section -->
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
        <h3 class="text-base font-semibold text-gray-900">Đơn hàng gần đây</h3>
        <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors">Xem tất cả</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã ĐH</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khách hàng</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tổng tiền</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($recentOrders ?? [] as $order)
                <tr class="hover:bg-gray-50 transition-colors cursor-pointer">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @php
                                $initials = collect(explode(' ', $order->user->name ?? 'Khách không tên'))->map(function($word) { return strtoupper(substr($word, 0, 1)); })->take(2)->join('');
                            @endphp
                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">{{ $initials }}</div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $order->user->name ?? 'Người dùng không xác định' }}</p>
                                <p class="text-xs text-gray-500">{{ $order->user->email ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${{ number_format($order->total_price, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusColor = match($order->status) {
                                'completed', 'delivered' => 'bg-green-100 text-green-800',
                                'pending' => 'bg-amber-100 text-amber-800',
                                'processing', 'shipped' => 'bg-blue-100 text-blue-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-100 text-gray-800',
                            };
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Không tìm thấy đơn hàng gần đây.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
