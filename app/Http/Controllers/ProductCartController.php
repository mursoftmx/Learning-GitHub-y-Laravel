<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\ValidationException;

class ProductCartController extends Controller
{
    public CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product)
    {
        $cart = $this->cartService->getFromCookieOrCreate();

        $quantity = $cart->products()
            ->find($product->id)
            ->pivot
            ->quantity ?? 0;
        
        if ($product->stock < $quantity + 1) 
        {
            throw ValidationException::withMessages([
                'product' => "There is not enough stock for the quantity you require of {$product->title}"
            ]);
        }

        $cart->products()->syncWithoutDetaching([$product->id => ["quantity" => $quantity + 1]]);

        // $cookie = cookie()->make('cart', $cart->id, 7 * 24 * 60);
        // $cookie = Cookie::make('cart', $cart->id, 7 * 24 * 60);

        $cookie = $this->cartService->makeCookie($cart);

        return redirect()->back()->withCookie($cookie);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product, Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, Cart $cart)
    {
        $cart->products()->detach($product->id);

        $cookie = $this->cartService->makeCookie($cart);

        return redirect()->back()->withCookie($cookie);
    }
}
