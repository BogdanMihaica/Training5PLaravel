<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Fetches anddisplays all items from the products table that are not in the shopping cart
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $cartItems = session('cart');
        $products = Product::whereNotIn('id', $cartItems ? array_keys($cartItems) : [])->simplePaginate(8);

        return view('welcome', compact('products'));
    }
}
