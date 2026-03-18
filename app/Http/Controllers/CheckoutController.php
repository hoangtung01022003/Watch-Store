<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function show()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $addresses = Auth::user()
            ->addresses()
            ->orderBy('is_default', 'desc')
            ->get();

        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        return view('checkout.index', compact('cart', 'total', 'addresses'));
    }

    public function processCheckout(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $request->validate([
            'payment_method' => 'required|string',
            'note' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        
        // Handle address selection or creation
        if ($request->input('use_new_address') === '1') {
            $request->validate([
                'receiver_name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'full_address' => 'required|string|max:255',
                'city' => 'required|string|max:100',
                'district' => 'required|string|max:100',
                'ward' => 'required|string|max:100',
            ]);

            $address = new Address([
                'user_id' => $user->id,
                'receiver_name' => $request->receiver_name,
                'phone' => $request->phone,
                'full_address' => $request->full_address,
                'city' => $request->city,
                'district' => $request->district,
                'ward' => $request->ward,
                'is_default' => $user->addresses()->count() === 0, // Make default if it's the first one
            ]);
            $address->save();
            $addressId = $address->id;
        } else {
            $request->validate([
                'address_id' => 'required|exists:addresses,id',
            ]);
            // Verify address belongs to user
            $address = Address::where('id', $request->address_id)->where('user_id', $user->id)->firstOrFail();
            $addressId = $address->id;
        }

        try {
            DB::beginTransaction();

            $totalPrice = 0;
            foreach ($cart as $item) {
                $totalPrice += $item['price'] * $item['quantity'];
            }

            // Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $addressId,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'note' => $request->note,
            ]);

            // Add Order Items
            foreach ($cart as $productId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
                
                // Optional: Update product stock
                $product = Product::find($productId);
                if ($product && $product->stock >= $item['quantity']) {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            DB::commit();

            // Clear session cart
            session()->forget('cart');

            return redirect()->route('checkout.success', $order->id)->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Error: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong while processing your order. Please try again.');
        }
    }
    
    public function success($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('checkout.success', compact('order'));
    }
}
