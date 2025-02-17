<?php

namespace App\Http\Controllers\SPA;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Notifications\OrderSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SPAOrderController extends Controller
{
    /**
     * Returns all the orders from the database
     * 
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return OrderResource::collection(Order::orderByDesc('created_at')->get());
    }

    /**
     * Attempts to store an order in the orders table, then maps all the products in the cart to it's corresponding order id
     * in the order_products table. After all these sql operations, attempt to send an email to the admin with details about the order
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|OrderResource
     */
    public function store(Request $request)
    {
        $cartItems = Session::get('cart', []);

        $validated = $request->validate([
            'name' => ['required', 'max:100'],
            'email' => ['required', 'email'],
        ]);

        Validator::make(
            ['cart' => $cartItems],
            ['cart' => 'required']
        )->validate();


        $order = new Order();
        $order->customer_name = $validated['name'];
        $order->customer_email = $validated['email'];

        $order->save();

        $order->products()->sync(
            collect($cartItems)->map(fn($quantity) => ['quantity' => $quantity])->toArray()
        );

        Notification::route('mail', config('mail.from.address'))
            ->notify(new OrderSent($order));

        session()->forget('cart');

        return new OrderResource($order);
    }

    /**
     * Returns the details of a specified order
     * 
     * @param int $id
     * 
     * @return OrderResource
     */
    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    /**
     * Get the products of a specific order
     * 
     * @param \App\Models\Order $order
     * 
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function showProducts(Order $order)
    {
        return ProductResource::collection($order->products);
    }
}
