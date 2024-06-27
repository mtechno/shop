<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'image' => $this->image,
            'price' => $this->price,
            'new' => $this->new,
            'hit' => $this->hit,
            'recommend' => $this->recommend,
            'count' => $this->count,
        ];
    }
}
