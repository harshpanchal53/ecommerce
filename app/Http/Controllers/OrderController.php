<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->with('orderItems.product')->get();
        return view('orders.index', compact('orders'));
    }


    public function store() {
        $cartItems = Cart::where('user_id', auth()->id())->get();
        $order = Order::create(['user_id' => auth()->id(), 'total_price' => $cartItems->sum('price')]);
        foreach ($cartItems as $item) {
            OrderItem::create(['order_id' => $order->id, 'product_id' => $item->product_id, 'quantity' => $item->quantity, 'price' => $item->price]);
        }
        Cart::where('user_id', auth()->id())->delete();
        return redirect()->route('orders.index');
    }

    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            dd("1212");
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $total,
            'status' => 'Pending',
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }
}
