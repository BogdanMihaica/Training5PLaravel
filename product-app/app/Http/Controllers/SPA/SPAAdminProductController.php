<?php

namespace App\Http\Controllers\SPA;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class SPAAdminProductController extends Controller
{
    /**
     * Returns a collection of all the products
     * 
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return ProductResource::collection(Product::orderByDesc('created_at')->get());
    }

    /**
     * Get a specific product

     * @param Product $product

     * @return ProductResource
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Deletes a product from the database, as well as its corresponding image from the storage if there is one
     * 
     * @param Product $product
     */
    public function destroy(Product $product)
    {
        if ($product->image_filename) {
            Storage::disk('public')->delete('products' . DIRECTORY_SEPARATOR . $product->image_filename);
        }

        $product->delete();
    }

    /**
     * Inserts a new product in the database and returns it as response
     * 
     * @return ProductResource
     */
    public function store(Request $request)
    {
        $product = new Product();
        $this->save($product, true);

        return new ProductResource($product);
    }

    /**
     * Updates a product from the database and returns it as response
     * 
     * @return ProductResource
     */
    public function update(Product $product)
    {
        $this->save($product);

        return new ProductResource($product);
    }

    /**
     * Validates and saves a product from the request
     * 
     * @param \App\Models\Product $product
     * 
     * @return Product
     */
    private function save(Product $product, bool $newProduct = false)
    {
        $validated = request()->validate([
            'title' => ['required', 'max:50'],
            'description' => ['required', 'max:300'],
            'price' => ['required', 'numeric', 'min:1'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $product->title = $validated['title'];
        $product->description = $validated['description'];
        $product->price = $validated['price'];

        if ($newProduct) {
            $product->save();
        }

        if (request()->hasFile('image')) {
            $image = request()->file('image');
            $fileName = $product->getKey() . '.' . $image->extension();

            if ($product->image_filename) {
                Storage::disk('public')->delete('products/' . $product->image_filename);
            }

            $image->storeAs('products', $fileName, 'public');
            $product->image_filename = $fileName;
        }

        $product->save();

        return $product;
    }
}
