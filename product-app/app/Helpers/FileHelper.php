<?php

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

/**
 * Get the public URL of a products image if the specified product object's image_filename variable is not null
 * 
 * @param App\Models\Product $product
 * 
 * @return string|null
 */
function getImageUrl(Product $product)
{
    if (!$product->image_filename) {
        return;
    }

    $separator = DIRECTORY_SEPARATOR;

    return asset('storage' . $separator . 'products' . $separator . $product->image_filename);
}
