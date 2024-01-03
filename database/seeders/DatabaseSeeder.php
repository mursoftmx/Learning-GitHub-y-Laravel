<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Image;
use App\Models\Cart;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(20)
            ->create()
            ->each(function ($user) {
                $image = Image::factory()
                    ->user()
                    ->make();

                $user->image()->save($image);
            });

        $orders = Order::factory(10)
            ->make()
            ->each(function ($order) use ($users) {
                $order->customer_id = $users->random()->id;
                $order->save();

                $payment = Payment::factory()->make();

                // $payment->order_id = $order->id;
                // $payment->save();

                $order->payment()->save($payment);
            });

        $carts = Cart::factory(20)->create();

        $products = Product::factory(50)
            ->create()
            ->each(function ($product) use($orders, $carts) {
                $order = $orders->random();

                $order->products()->attach([$product->id => ['quantity' => mt_rand(1,3)]]);

                $cart = $carts->random();

                $cart->products()->attach([$product->id => ['quantity' => mt_rand(1,3)]]);

                $images = Image::factory(mt_rand(2,4))->make();
                $product->images()->saveMany($images);
            });
        /*
        Product::factory()->create([
            'title' => 'Avena Quaker',
            'description' => 'Avena entera con mezcla de frutos rojos',
            'price' => 4.5,
            'stock' => 8,
            'status' => 'available'
        ]);
        */
    }
}
