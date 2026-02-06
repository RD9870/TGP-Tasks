<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    // The attributes that are mass assignable.
    protected $fillable = [
        'user_id',
        'payment_method_id',
        'address',
    ];

    // Relationships

    // A cart belongs to a user
    public function user(){
        return $this->belongsTo(User::class);
    }

    // A cart belongs to a payment method
    public function paymentMethod(){
        return $this->belongsTo(PaymentMethod::class);
    }

    // A cart has many cart items
    public function items(){
        return $this->hasMany(CartItem::class);
    }

    // Calculate the total price of the cart
    public function totalCart(){
        $total = 0;
        foreach($this->items as $item){
            $total = $total + $item->totalItem();
        }
        return $total;
    }
}
