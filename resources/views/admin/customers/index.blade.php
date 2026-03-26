@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Khách hàng</h2>
        <p class="text-sm text-gray-500 mt-1">Quản lý tài khoản người dùng và xem lịch sử đơn hàng của họ.</p>
    </div>
</div>

@if(session('success'))
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-6">
    <div class="p-4 border-b border-gray-200 bg-gray-50 flex flex-col sm:flex-row justify-between gap-4">
        <form action="{{ route('admin.customers.index') }}" method="GET" class="w-full sm:w-1/2 md:w-1/3">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm bằng tên hoặc email..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-700 text-sm border-b border-gray-200">
                    <th class="px-6 py-4 font-semibold">Tên</th>
                    <th class="px-6 py-4 font-semibold">Email & Điện thoại</th>
                    <th class="px-6 py-4 font-semibold">Ngày đăng ký</th>
                    <th class="px-6 py-4 font-semibold text-center">Vai trò</th>
                    <th class="px-6 py-4 font-semibold text-center">Trạng thái</th>
                    <th class="px-6 py-4 font-semibold text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse($customers as $customer)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $customer->name }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        <div>{{ $customer->email }}</div>
                        @if($customer->phone)
                            <div class="text-xs text-gray-500 mt-1">{{ $customer->phone }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $customer->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($customer->role === 'admin')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                Quản trị viên
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Người dùng
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($customer->status)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Hoạt động
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Đã khóa
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            @if(auth()->id() !== $customer->id)
                            <form action="{{ route('admin.customers.change-role', $customer) }}" method="POST" class="inline-block" onsubmit="return confirm('Thay đổi vai trò thành {{ $customer->role === 'admin' ? 'người dùng' : 'quản trị viên' }}?');">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="role" value="{{ $customer->role === 'admin' ? 'user' : 'admin' }}">
                                <button type="submit" class="text-sm font-medium text-blue-600 hover:text-blue-900">
                                    Cấp quyền {{ $customer->role === 'admin' ? 'Người dùng' : 'Quản trị viên' }}
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.customers.toggle-status', $customer) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn {{ $customer->status ? 'khóa' : 'mở khóa' }} khách hàng này?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-sm font-medium {{ $customer->status ? 'text-orange-600 hover:text-orange-900' : 'text-green-600 hover:text-green-900' }}">
                                    {{ $customer->status ? 'Khóa' : 'Mở khóa' }}
                                </button>
                            </form>
                            @else
                            <span class="text-sm text-gray-400 italic">Là bạn</span>
                            @endif
                            <a href="{{ route('admin.customers.show', $customer) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Xem</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                        Không tìm thấy khách hàng nào phù hợp với tìm kiếm của bạn.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($customers->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $customers->links() }}
    </div>
    @endif
</div>
@endsection

