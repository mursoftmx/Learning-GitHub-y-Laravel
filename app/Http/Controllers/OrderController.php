<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class OrderController extends Controller
{
    public CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->middleware("auth");
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cart = $this->cartService->getFromCookie();

        if (!isset($cart) || $cart->products->isEmpty()) 
        {
            return redirect()->back()->withErrors('Your Cart is Empty!');
        }

        return view('orders.create')->with(['cart' => $cart]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            // $user = Auth::user();
            $user = $request->user();

            $order = $user->orders()->create(['status' => 'pending']);
    
            $cart = $this->cartService->getFromCookie();
    
            $cartProductsWithQuantity = $cart
                ->products
                ->mapWithKeys(function ($product) {
                    $quantity = $product->pivot->quantity;
                
                    if ($product->stock < $quantity) 
                    {
                        throw ValidationException::withMessages([
                            'product' => "There is not enough stock for the quantity you require of {$product->title}"
                        ]);
                    }

                    $product->decrement('stock', $quantity);
                    $element[$product->id] = ['quantity' => $quantity];

                    return $element;
                });
    
            $order->products()->attach($cartProductsWithQuantity->toArray());
    
            return redirect()->route('orders.payments.create', ['order' => $order]);
        }, 5);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
