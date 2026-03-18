<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CartController extends Controller
{
    const FALLBACK_URL = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRZmcUItX_aN4WIAvYj6eChM5cWQw2dOwntqA&s';

    public function viewCart()
    {
        $cart = session('cart', []);
        $total = collect($cart)->sum(fn($i) => floatval($i['price']) * intval($i['quantity']));

        return view('cart.index', compact('cart', 'total'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $product = Product::findOrFail($productId);

        if (!$product->status || $product->stock <= 0) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Product is currently unavailable or out of stock.']);
            }
            return back()->with('error', 'Product is currently unavailable or out of stock.');
        }

        $cart = session()->get('cart', []);

        $image = !empty($product->image) ? $product->image : self::FALLBACK_URL;

        if (isset($cart[$productId])) {
            $newQuantity = $cart[$productId]['quantity'] + $quantity;
            if ($newQuantity > $product->stock) {
                if ($request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => 'Requested quantity exceeds available stock.']);
                }
                 return back()->with('error', 'Requested quantity exceeds available stock.');
            }
            $cart[$productId]['quantity'] = $newQuantity;
        } else {
            if ($quantity > $product->stock) {
                if ($request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => 'Requested quantity exceeds available stock.']);
                }
                 return back()->with('error', 'Requested quantity exceeds available stock.');
            }
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $image,
                'stock' => $product->stock
            ];
        }

        session()->put('cart', $cart);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true, 
                'message' => 'Product added to cart successfully!',
                'cartCount' => count($cart)
            ]);
        }

        return back()->with('success', 'Product added to cart successfully!');
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            $product = Product::find($productId);
            if ($product && $quantity <= $product->stock) {
                $cart[$productId]['quantity'] = $quantity;
                session()->put('cart', $cart);
                return back()->with('success', 'Cart updated successfully!');
            }
            return back()->with('error', 'Requested quantity exceeds available stock.');
        }

        return back()->with('error', 'Product not found in cart.');
    }

    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Product removed from cart.');
    }
}
