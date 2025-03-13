<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{
    public function index()
    {
        // harsh
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        return view('cart.index', compact('cartItems'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        if (!Auth::check()) {
            return redirect()->route('loginregister')->with('error', 'You need to log in to add items to the cart.');
        }

        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('product_id', $request->product_id)
                        ->first();

        if ($cartItem) {
            // If the product is already in the cart, increase the quantity
            $cartItem->increment('quantity', $request->quantity ?? 1);
        } else {
            // If not, create a new cart item
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity ?? 1
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    public function removeFromCart(Cart $cart)
    {
        if ($cart->user_id === Auth::id()) {
            $cart->delete();
        }
        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }

    public function store(Request $request) {
        Cart::updateOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $request->product_id],
            ['quantity' => $request->quantity]
        );
        return redirect()->route('cart.index');
    }

    public function destroy(Cart $cart) {
        $cart->delete();
        return redirect()->route('cart.index');
    }
}
