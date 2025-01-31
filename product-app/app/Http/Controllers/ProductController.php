<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
     * Return the view for publishing a product
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $edit = false;

        return view('products.product', compact('edit'));
    }

    /**
     * Return the view for editing a product with a specified id

     * @param int $id

     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $edit = true;

        return view('products.product', compact('edit', 'product'));
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

    /**
     * Attempts to destroy a product by its id
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Product::findOrFail($id);

        Product::destroy($id);

        $image = findImageName($id);

        if ($image) {
            unlink(storage_path('app/public/products/' . $image));
        }

        return redirect('/products');
    }

    /**
     * Attempts to store a product in the database and saves the images associated with it if it exists
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        request()->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => ['required', 'max:50'],
            'description' => ['required', 'max:300'],
            'price' => ['required', 'numeric', 'min:1'],
        ]);

        $product = new Product();
        $product->title = request('title');
        $product->description = request('description');
        $product->price = request('price');
        $product->save();

        if (request()->hasFile('image')) {
            $image = request()->file('image');
            $fileName = $product->id . '.' . $image->extension();
            $imagePath = $image->storeAs('products', $fileName, 'public');
        }

        return redirect('/product/' . $product->id . '/edit');
    }

    /**
     * Attempts to update a product in the database and saves the images associated with it if it exists
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        request()->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => ['required', 'max:50'],
            'description' => ['required', 'max:300'],
            'price' => ['required', 'numeric', 'min:1'],
        ]);

        $product = Product::findOrFail($id);
        $product->title = request('title');
        $product->description = request('description');
        $product->price = request('price');
        $product->save();

        if (request()->hasFile('image')) {
            $image = request()->file('image');
            $fileName = $product->id . '.' . $image->extension();

            $originalFile = findImageName($product->id);

            if ($originalFile) {
                unlink(storage_path('app/public/products/' . $originalFile));
            }

            $imagePath = $image->storeAs('products', $fileName, 'public');
        }

        return redirect('/product/' . $product->id . '/edit');
    }
}
