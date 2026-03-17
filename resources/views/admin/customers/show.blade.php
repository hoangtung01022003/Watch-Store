@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.customers.index') }}" class="hover:text-indigo-600">Customers</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">Customer Details</span>
    </div>
</div>

<div class="flex flex-col md:flex-row gap-6">
    <!-- Customer Profile Card -->
    <div class="w-full md:w-1/3">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 text-xl font-bold">
                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $customer->name }}</h2>
                        <div class="mt-1">
                            @if($customer->status)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Blocked</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-4 text-sm mt-6 border-t border-gray-100 pt-6">
                    <div>
                        <span class="block text-gray-500 text-xs mb-1">Email Address</span>
                        <span class="font-medium text-gray-900">{{ $customer->email }}</span>
                    </div>
                    @if($customer->phone)
                    <div>
                        <span class="block text-gray-500 text-xs mb-1">Phone Number</span>
                        <span class="font-medium text-gray-900">{{ $customer->phone }}</span>
                    </div>
                    @endif
                    <div>
                        <span class="block text-gray-500 text-xs mb-1">Registered On</span>
                        <span class="font-medium text-gray-900">{{ $customer->created_at->format('M d, Y H:i') }}</span>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100">
                    <form action="{{ route('admin.customers.toggle-status', $customer) }}" method="POST" onsubmit="return confirm('Change status for this customer?');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full justify-center flex items-center gap-2 px-4 py-2 border rounded-lg text-sm font-medium transition-colors {{ $customer->status ? 'border-red-200 text-red-700 bg-red-50 hover:bg-red-100' : 'border-green-200 text-green-700 bg-green-50 hover:bg-green-100' }}">
                            {{ $customer->status ? 'Lock Account' : 'Unlock Account' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="w-full md:w-2/3">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-medium text-gray-900">Recent Orders</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                            <th class="px-6 py-3 font-medium">Order ID</th>
                            <th class="px-6 py-3 font-medium">Date</th>
                            <th class="px-6 py-3 font-medium">Total Amount</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse($customer->orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-indigo-600">
                                #{{ $order->id }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $order->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-gray-900 font-medium">
                                ${{ number_format($order->total_amount, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                This customer hasn't placed any orders yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

