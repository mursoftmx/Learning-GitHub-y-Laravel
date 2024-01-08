<div class="card">
    <div id="carousel{{ $product->id }}" class="carousel slide carousel-fade">
        <div class="carousel-inner">
            @foreach ($product->images as $image)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <img class="d-block w-100 card-img-top" src="{{ asset($image->path) }}" height="500">
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" data-bs-target="#carousel{{ $product->id }}" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" data-bs-target="#carousel{{ $product->id }}" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>
    <div class="card-body">
        <h4 class="text-right"><strong>${{ $product->price }}</strong></h4>
        <h5 class="card-title">{{ $product->title }}</h5>
        <p class="card-text">{{ $product->description }}</p>
        <p class="card-text"><strong>{{ $product->stock }} left</strong></p>
        @if (isset($cart))
            <p class="card-text">{{ $product->pivot->quantity }} in your Cart (<strong>${{ $product->total }}</strong>)</p>
            <form method="POST" class="d-inline" action="{{ route('products.carts.destroy', ['cart' => $cart->id ,'product' => $product->id]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-warning">Remove from Cart</button>
            </form>
        @else
            <form method="POST" class="d-inline" action="{{ route('products.carts.store', ['product' => $product->id]) }}">
                @csrf
                <button type="submit" class="btn btn-success">Add To Cart</button>
            </form>
        @endif
    </div>
</div>
