<?php

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

/**
 * Get the public URL of a products image if it is not null
 * 
 * @param App\Models\Product $product
 * 
 * @return string|null
 */
function getImageUrl(Product $product)
{
    if ($product->image_filename == null) {
        return null;
    }

    $separator = DIRECTORY_SEPARATOR;
    # $path = 'public' . $separator . 'products' . $separator . $product->image_filename;

    return asset('storage' . $separator . 'products' . $separator . $product->image_filename);
}
