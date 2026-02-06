<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return the cart data with the total price for the cart and the payment method details
        return [
            'payment_method' => [
                'id' => $this->paymentMethod->id,
                'name' => $this->paymentMethod->name
            ],
            'address' => $this->address,
            'items'=> CartItemResource::collection($this->items),
            'total_price' => $this->totalCart()
        ];
    }
}
