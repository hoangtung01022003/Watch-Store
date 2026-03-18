<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');
        $totalCustomers = User::where('role', 'user')->count();
        $totalCategories = Category::count();
        $totalBrands = Brand::count();
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts', 
            'totalOrders', 
            'totalRevenue', 
            'totalCustomers', 
            'totalCategories',
            'totalBrands',
            'pendingOrdersCount',
            'recentOrders'
        ));
    }
}
