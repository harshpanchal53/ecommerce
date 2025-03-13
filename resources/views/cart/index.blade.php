@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Shopping Cart</h1>
    @if($cartItems->isEmpty())
        <div class="alert alert-warning">Your cart is empty.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>Rs.{{ $item->product->price }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <form action="{{ route('orders.checkout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Proceed to Checkout</button>
        </form>
    @endif
</div>
@endsection