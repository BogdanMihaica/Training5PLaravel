<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->map(function ($productResource) {
            $product = $productResource->resource;

            return array_merge($product->toArray(), [
                'image_url' => getImageUrl($product),
            ]);
        })->toArray();
    }
}
