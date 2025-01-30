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

    /**
     * Queries and opens the view for the products dashboard along with the fetched products
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function dashboard()
    {
        $products = Product::query()->simplePaginate(12);
        return view('products.products', compact('products'));
    }
}
