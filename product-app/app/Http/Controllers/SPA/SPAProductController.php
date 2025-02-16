<?php

namespace App\Http\Controllers\SPA;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Boolean;

class SPAProductController extends Controller
{
    /**
     * Returns the collection of products that are not part of the cart
     * 
     * @return ProductCollection
     */
    public function index()
    {
        $cartItems = session('cart');
        $products = Product::whereNotIn('id', $cartItems ? array_keys($cartItems) : [])->get();

        return new ProductCollection($products);
    }
}
