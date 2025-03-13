@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Shop</h1>
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ asset($product->image) }}" class="card-img-top">
                    <div class="card-body">
                        <h5>{{ $product->name }}</h5>
                        <p>Rs.{{ $product->price }}</p>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="number" name="quantity" value="1" min="1">
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
