@extends('layouts.app')

@section('content')
    <h1>Your Cart</h1>
    @if (!isset($cart) || $cart->products->isEmpty())
        <div class="alert alert-warning">
            Your car is empty!
        </div>
    @else
        <a class="btn btn-success mb-3" href="{{ route('orders.create') }}">Create Order</a>
        <h4 class="text-center">Grand Total: <strong>${{ $cart->total }}</strong></h4>
        <div class="row">
            @foreach ($cart->products as $product)
                <div class="col-3">
                    @include('components.product-card')
                </div>
            @endforeach
        </div>
    @endif
@endsection