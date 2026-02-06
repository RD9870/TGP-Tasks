<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return the cart item data with the total price for that item
        return [
            'id'=>$this->id,
            'book'=>$this->book,
            'qty' => $this->qty,
            'total'=>$this->totalItem()
        ];
    }
}
