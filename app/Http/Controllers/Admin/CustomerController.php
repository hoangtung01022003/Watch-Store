<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        $customers = $query->latest()->paginate(15)->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        // Ensure we only show customers
        if ($customer->role !== 'user') {
            abort(404);
        }

        $customer->load(['orders' => function ($query) {
            $query->latest()->take(5);
        }]);

        return view('admin.customers.show', compact('customer'));
    }

    public function toggleStatus(User $customer)
    {
        // Prevent toggling admins
        if ($customer->role !== 'user') {
            return back()->with('error', 'Cannot modify admin status.');
        }

        $customer->update(['status' => !$customer->status]);

        $message = $customer->status ? 'Customer account has been unblocked.' : 'Customer account has been blocked.';
        
        return back()->with('success', $message);
    }
}
