<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Summary of orders
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Order, Product>
     */
    public function orders()
    {
        return $this
            ->belongsToMany(Order::class, 'order_products')
            ->withPivot('quantity');
    }

    /**
     * Get the public URL of a products image if the specified product object's image_filename variable is not null
     * 
     * @param mixed $product
     * 
     * @return string|null
     */
    public function getImageUrl()
    {
        if (!$this->image_filename) {
            return;
        }

        return asset('storage' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR . $this->image_filename);
    }
}
