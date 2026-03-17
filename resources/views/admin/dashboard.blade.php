@extends('admin.layouts.app')

@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
    <!-- Card 1: Total Products -->
    <div class="flex items-center p-4 bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600">Total Products</p>
            <p class="text-lg font-semibold text-gray-700">{{ $totalProducts }}</p>
        </div>
    </div>

    <!-- Card 2: Total Orders -->
    <div class="flex items-center p-4 bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600">Total Orders</p>
            <p class="text-lg font-semibold text-gray-700">{{ $totalOrders }}</p>
        </div>
    </div>

    <!-- Card 3: Total Revenue -->
    <div class="flex items-center p-4 bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600">Total Revenue</p>
            <p class="text-lg font-semibold text-gray-700">{{ number_format($totalRevenue, 0, ',', '.') }} VND</p>
        </div>
    </div>

    <!-- Card 4: Total Customers -->
    <div class="flex items-center p-4 bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600">Total Customers</p>
            <p class="text-lg font-semibold text-gray-700">{{ $totalCustomers }}</p>
        </div>
    </div>
</div>

<!-- Recent Orders Table -->
<div class="bg-white rounded-lg shadow-sm border border-gray-100">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800">Recent Orders</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Customer</th>
                    <th class="px-6 py-3">Total (VND)</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y">
                @forelse($recentOrders as $order)
                <tr class="text-gray-700">
                    <td class="px-6 py-3 text-sm font-medium">#{{ $order->id }}</td>
                    <td class="px-6 py-3 text-sm">
                        {{ $order->user ? $order->user->name : 'Guest' }}
                    </td>
                    <td class="px-6 py-3 text-sm">
                        {{ number_format($order->total_price, 0, ',', '.') }} ₫
                    </td>
                    <td class="px-6 py-3 text-sm">
                        @if($order->status === 'completed' || $order->status === \App\Enums\OrderStatus::COMPLETED)
                            <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">Completed</span>
                        @elseif($order->status === 'pending' || $order->status === \App\Enums\OrderStatus::PENDING)
                            <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full">Pending</span>
                        @elseif($order->status === 'canceled' || $order->status === \App\Enums\OrderStatus::CANCELED)
                            <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full">Canceled</span>
                        @else
                            <span class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full">
                                {{ ucfirst(is_string($order->status) ? $order->status : $order->status->value ?? 'Unknown') }}
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-sm">
                        {{ $order->created_at->format('d/m/Y H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No recent orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
