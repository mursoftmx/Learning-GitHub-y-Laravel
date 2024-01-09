@extends('layouts.app')

@section('content')
    <h1>Wellcome</h1>
    @empty($products)
        <div class="alert alert-danger">
            The cart is empty, no items yet!
        </div>
    @else
        <div class="row">
            {{-- @dump($products) --}}

            @foreach ($products as $product)
                <div class="col-3">
                    @include('components.product-card')
                </div>
            @endforeach

            {{-- @dump($products) --}}

            {{-- @dd(DB::getQueryLog()) --}}
        </div>
    @endif
@endsection
