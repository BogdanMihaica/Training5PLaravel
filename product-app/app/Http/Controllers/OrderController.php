<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::query()->simplePaginate(12);
        return view('orders.orders', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:100'],
            'email' => ['required', 'email']
        ]);

        $cartItems = session('cart');

        if (!$cartItems) {
            return redirect()->back()->withErrors(['empty' => 'Your cart is empty']);
        }

        $order = new Order();
        $order->customer_name = $request->input('name');
        $order->customer_email = $request->input('email');
        $order->save();

        foreach (array_keys($cartItems) as $itemId) {
            $orderProduct = new OrderProduct();
            $orderProduct->product_id = $itemId;
            $orderProduct->order_id = $order->id;
            $orderProduct->quantity = $cartItems[$itemId];

            $orderProduct->save();
        }

        session()->forget('cart');

        return redirect('/');
    }
}
