<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

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
        $customer->load(['orders' => function ($query) {
            $query->latest()->take(5);
        }]);

        return view('admin.customers.show', compact('customer'));
    }

    public function changeRole(Request $request, User $customer)
    {
        if (auth()->id() === $customer->id) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $request->validate([
            'role' => 'required|in:user,admin'
        ]);

        $customer->update(['role' => $request->role]);

        return back()->with('success', 'User role updated successfully.');
    }

    public function toggleStatus(User $customer)
    {
        if (auth()->id() === $customer->id) {
            return back()->with('error', 'You cannot modify your own status.');
        }

        $customer->update(['status' => !$customer->status]);

        $message = $customer->status ? 'Customer account has been unblocked.' : 'Customer account has been blocked.';
        
        return back()->with('success', $message);
    }
}
