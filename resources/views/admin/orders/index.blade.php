@extends('layouts.admin')

@section('title', 'Quản lý Đơn hàng')

@section('header')
    Quản lý Đơn hàng
@endsection

@section('content')
<div class="mb-6 flex flex-wrap gap-2">
    <a href="{{ route('admin.orders.index', ['status' => 'all']) }}" 
       class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status', 'all') === 'all' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200' }}">
        Tất cả đơn hàng
    </a>
    @foreach(['pending' => 'Chờ xử lý', 'processing' => 'Đang xử lý', 'shipping' => 'Đang giao', 'completed' => 'Hoàn thành', 'cancelled' => 'Đã hủy'] as $status => $label)
    <a href="{{ route('admin.orders.index', ['status' => $status]) }}" 
       class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === $status ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200' }}">
        {{ $label }}
        <span class="ml-2 px-2 py-0.5 rounded-full text-xs {{ request('status') === $status ? 'bg-indigo-500 text-white' : 'bg-gray-100 text-gray-600' }}">
            {{ $statusCounts[$status] ?? 0 }}
        </span>
    </a>
    @endforeach
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50/50 text-gray-500 font-medium border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4">Mã ĐH</th>
                    <th class="px-6 py-4">Khách hàng</th>
                    <th class="px-6 py-4">Trạng thái</th>
                    <th class="px-6 py-4">Tổng SP</th>
                    <th class="px-6 py-4">Tổng tiền</th>
                    <th class="px-6 py-4">Ngày đặt</th>
                    <th class="px-6 py-4 text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-900">#{{ $order->id }}</td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $order->user->name ?? 'Khách' }}</div>
                        <div class="text-xs text-gray-500">{{ $order->user->email ?? '' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                            @elseif($order->status === 'shipping') bg-purple-100 text-purple-800
                            @elseif($order->status === 'completed') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ match($order->status) {
                                'pending' => 'Chờ xử lý',
                                'processing' => 'Đang xử lý',
                                'shipping' => 'Đang giao',
                                'completed' => 'Hoàn thành',
                                'cancelled' => 'Đã hủy',
                                default => $order->status
                            } }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">{{ $order->items_sum_quantity ?? 0 }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">${{ number_format($order->total_price, 2) }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $order->created_at->format('M d, Y H:i') }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-medium">
                            Xem chi tiết
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                        Không tìm thấy đơn hàng nào
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($orders->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $orders->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection

