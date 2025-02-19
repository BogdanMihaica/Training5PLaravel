<?php

namespace App\Http\Controllers\SPA;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Models\Order;
use App\Notifications\OrderSent;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class SPAOrderController extends Controller
{
    /**
     * Returns all the orders from the database
     * 
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $orders = Order::orderBy("created_at","desc")->paginate(10);

        return JsonResource::collection($orders);
    }

    /**
     * Attempts to store an order in the orders table, then maps all the products in the cart to it's corresponding order id
     * in the order_products table. After all these sql operations, attempt to send an email to the admin with details about the order
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return JsonResource
     */
    public function store()
    {
        $cartItems = Session::get('cart', []);

        $validated = request()->merge(['cart' => $cartItems])->validate([
            'cart' => ['required'],
            'customer_name' => ['required', 'max:100'],
            'customer_email' => ['required', 'email'],
        ]);

        $order = new Order();
        $order->fill($validated);
        $order->save();
        
        $order
            ->products()
            ->sync(
                collect($cartItems)->map(fn($quantity) => ['quantity' => $quantity])->toArray()
            );

        Notification::route('mail', config('mail.from.address'))->notify(new OrderSent($order));

        Session::forget('cart');

        return new JsonResource($order);
    }

    /**
     * Returns the details of a specified order
     * 
     * @param int $id
     * 
     * @return JsonResource
     */
    public function show(Order $order)
    {
        return new JsonResource($order);
    }

    /**
     * Get the products of a specific order
     * 
     * @param \App\Models\Order $order
     * 
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function listProducts(Order $order)
    {
        $products = $order->products()->paginate(12);

        return ProductResource::collection($products);
    }
}
