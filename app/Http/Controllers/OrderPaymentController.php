<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Support\Facades\DB;

class OrderPaymentController extends Controller
{
    public $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->middleware("auth");
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Order $order)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Order $order)
    {
        return view('payments.create')->with(['order' => $order]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Order $order)
    {
        return DB::transaction(function () use ($request, $order) {
            // PaymentService::HandlePayment

            $this->cartService->getFromCookie()->products()->detach();

            $order->payment()->create([
                'amount'=> $order->total,
                'payed_at'=> now()
            ]);

            $order->status = 'payed';
            $order->save();

            return redirect()->route('main')->withSuccess("Thanks! your payment for \${$order->total} was successful");
        }, 5);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order, Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order, Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order, Payment $payment)
    {
        //
    }
}
