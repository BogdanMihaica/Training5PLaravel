<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Fetches and displays the items that are in the cart
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $cartItems = session('cart');
        $products = Product::whereIn('id', $cartItems ? array_keys($cartItems) : [])->get();

        return view('cart', compact('products'));
    }

    /**
     * Stores an item in the session cart
     * 
     * @param integer $id
     * @param integer $quantity
     * 
     * @return mixed
     */
    public function store($id, $quantity)
    {
        if (!session()->has('cart')) {
            session()->put('cart', []);
        }

        $product = Product::find($id);

        if (!$product) {
            abort(404);
        }

        $cartItems = session('cart');

        if (array_key_exists($id, $cartItems)) {
            abort(403);
        }

        $cartItems[$id] = $quantity;
        session()->put('cart', $cartItems);

        return redirect('/');
    }

    /**
     * Tries to remove an item from the cart
     * 
     * @param integer $id
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $cartItems = session('cart');

        if (!session()->has('cart') || !$product) {
            abort(404);
        }

        if (!array_key_exists($id, $cartItems)) {
            abort(403);
        }

        unset($cartItems[$id]);
        session()->put('cart', $cartItems);

        return redirect('/cart');
    }
}
