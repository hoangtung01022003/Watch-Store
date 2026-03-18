<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $statusCounts = Order::selectRaw('status, count(*) as count')->groupBy('status')->pluck('count', 'status');

        $orders = Order::with('user')
            ->when($request->status && $request->status !== 'all', function ($q) use ($request) {
                return $q->where('status', $request->status);
            })
            ->withSum('items', 'quantity')
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders', 'statusCounts'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipping,completed,cancelled'
        ]);

        $order = Order::findOrFail($id);

        if (in_array($order->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'Cannot update status of a final order');
        }

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated successfully');
    }
}
