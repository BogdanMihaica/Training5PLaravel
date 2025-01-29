<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Session;

class ProductController extends Controller
{
    public function index()
    {
        $cartItems = session('cart');
        $products = Product::whereNotIn('id', $cartItems ? array_keys($cartItems) : [])->get();

        //$product = $products->first();

        return view('welcome', compact('products'));
    }
}
