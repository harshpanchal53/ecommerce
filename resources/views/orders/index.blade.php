@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Order History</h1>
    @if($orders->isEmpty())
        <div class="alert alert-info">No orders placed yet.</div>
    @else
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>Rs.{{ $order->total_price }}</td>
                    <td><span class="badge bg-primary">{{ $order->status }}</span></td>
                    <td>
                        <ul class="list-unstyled">
                            @foreach($order->orderItems as $item)
                                <li>{{ $item->product->name }} - Rs.{{ $item->price }} x {{ $item->quantity }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
