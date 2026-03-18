@extends('layouts.admin')

@section('title', 'Order details #' . $order->id)

@section('header')
<div class="flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.orders.index') }}" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h1>Order details #{{ $order->id }}</h1>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium capitalize
            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
            @elseif($order->status === 'shipping') bg-purple-100 text-purple-800
            @elseif($order->status === 'completed') bg-green-100 text-green-800
            @else bg-red-100 text-red-800 @endif">
            {{ $order->status }}
        </span>
    </div>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Order Items & Notes -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Order Items -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 font-medium text-gray-900">
                Order Items
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($order->items as $item)
                <div class="flex items-center p-6 gap-4">
                    <img src="{{ $item->product->images->first()->image_path ?? asset('images/placeholder.jpg') }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-lg border border-gray-100">
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-900">{{ $item->product->name }}</h4>
                        <div class="text-sm text-gray-500 mt-1">Quantity: {{ $item->quantity }}</div>
                    </div>
                    <div class="text-right">
                        <div class="font-medium text-gray-900">${{ number_format($item->price, 2) }}</div>
                        <div class="text-sm text-gray-500 mt-1">Total: ${{ number_format($item->price * $item->quantity, 2) }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
                <div class="flex justify-between items-center text-lg font-bold text-gray-900">
                    <span>Total Amount</span>
                    <span>${{ number_format($order->total_price, 2) }}</span>
                </div>
            </div>
        </div>

        @if($order->note)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-medium text-gray-900 mb-2">Customer Note</h3>
            <p class="text-gray-600 bg-gray-50 rounded-lg p-4">{{ $order->note }}</p>
        </div>
        @endif
    </div>

    <!-- Right Column: Customer Info & Actions -->
    <div class="space-y-6">
        <!-- Update Status -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-medium text-gray-900 mb-4">Update Status</h3>
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <select name="status" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {{ in_array($order->status, ['completed', 'cancelled']) ? 'disabled' : '' }}>
                    @foreach(['pending' => 'Pending', 'processing' => 'Processing', 'shipping' => 'Shipping', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $value => $label)
                        <option value="{{ $value }}" {{ $order->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if(!in_array($order->status, ['completed', 'cancelled']))
                <button type="submit" class="w-full bg-indigo-600 text-white rounded-lg px-4 py-2 font-medium hover:bg-indigo-700 transition-colors">
                    Update Order Status
                </button>
                @else
                <div class="text-sm text-center text-gray-500 bg-gray-50 rounded-lg py-2">
                    Cannot change status of a final order
                </div>
                @endif
            </form>
        </div>

        <!-- Customer & Delivery Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-medium text-gray-900 mb-4">Customer Details</h3>
            
            <div class="space-y-4">
                <div>
                    <div class="text-sm text-gray-500">Name</div>
                    <div class="font-medium">{{ $order->user->name ?? 'Guest' }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Email</div>
                    <div>{{ $order->user->email ?? 'N/A' }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Phone</div>
                    <div>{{ $order->address->phone ?? 'N/A' }}</div>
                </div>
                <div class="pt-4 border-t border-gray-100">
                    <div class="text-sm text-gray-500 mb-1">Delivery Address</div>
                    <div class="text-gray-900">
                        @if($order->address)
                            {{ $order->address->address }}<br>
                            {{ $order->address->city }}, {{ $order->address->state }}<br>
                            {{ $order->address->zip_code }}
                        @else
                            No address provided
                        @endif
                    </div>
                </div>
                <div class="pt-4 border-t border-gray-100">
                    <div class="text-sm text-gray-500 mb-1">Payment Method</div>
                    <div class="font-medium capitalize">{{ $order->payment_method }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

