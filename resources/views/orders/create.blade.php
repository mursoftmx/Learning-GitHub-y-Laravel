@extends('layouts.app')

@section('content')
    <h1>Order details</h1>
    <h4 class="text-center">Grand Total: <strong>${{ $cart->total }}</strong></h4>
    <div class="text-center mb-3">
        <form method="POST" class="d-inline" action="{{ route('orders.store') }}">
            @csrf
            <button type="submit" class="btn btn-success">Confirm Order</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="thead-light">
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart->products as $product)
                    <tr>
                        <td>
                            <img src="{{ asset($product->images->first()->path) }}" width="100">
                            {{$product->title}}
                        </td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->pivot->quantity}}</td>
                        <td>
                            <!--<strong>{{ $product->pivot->quantity * $product->price }}</strong> texto agregado para pruebas de Git. -->
                            <strong>${{ $product->total }}</strong>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection