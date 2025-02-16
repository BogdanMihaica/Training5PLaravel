<?php

namespace App\Http\Controllers\SPA;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartProductsCollection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SPACartController extends Controller
{
    /**
     * Returns a collection of products that are present in the session cart variable
     * 
     * @return CartProductsCollection
     */
    public function index()
    {
        $cartItems = Session::get('cart', []);
        $products = Product::whereIn('id', $cartItems ? array_keys($cartItems) : [])->get();

        return new CartProductsCollection($products);
    }

    /**
     * Stores an item in the cart if it doesn't already exist
     * 
     * @param Product $product
     */
    public function store(Request $request)
    {
        $cartItems = Session::get('cart', []);
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'id' => ['required', Rule::notIn(array_keys($cartItems))],
        ]);

        $cartItems[$validated['id']] = $validated['quantity'];
        Session::put('cart', $cartItems);
    }

    /**
     * Removes an item from the session cart variable if it exists
     * 
     * @param Product $product
     */
    public function destroy(Request $request, Product $product)
    {
        $cartItems = Session::get('cart');

        Validator::make(
            ['id' => $product->getKey()],
            ['id' => ['required', Rule::in(array_keys($cartItems))]],
        );

        unset($cartItems[$product->getKey()]);
        Session::put('cart', $cartItems);
    }
}
