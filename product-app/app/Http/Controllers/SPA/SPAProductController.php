<?php

namespace App\Http\Controllers\SPA;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class SPAProductController extends Controller
{
    /**
     * Returns the collection of products that are not part of the cart
     * 
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $cartItems = Session::get('cart',[]);
        $products = Product::whereNotIn('id', $cartItems ? array_keys($cartItems) : [])->where('deleted',0)->paginate(10);

        return ProductResource::collection($products);
    }
}
