<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Session;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $attributes = parent::toArray($request);

        $attributes['image_url'] = $this->getImageUrl();
        $attributes['quantity'] = Session::get('cart')[$this->getKey()] ?? 0;
        
        return $attributes;
    }
}
