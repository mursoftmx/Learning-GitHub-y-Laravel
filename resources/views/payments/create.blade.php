@extends('layouts.app')

@section('content')
    <h1>Payment details</h1>
    <h4 class="text-center">Grand Total: <strong>${{ $order->total }}</strong></h4>
    <div class="text-center mb-3">
        <form method="POST" class="d-inline" action="{{ route('orders.payments.store', ['order' => $order->id]) }}">
            @csrf
            <button type="submit" class="btn btn-success">Pay</button>
        </form>
    </div>
@endsection