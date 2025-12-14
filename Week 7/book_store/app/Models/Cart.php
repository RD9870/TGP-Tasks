<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
    'user_id',
    'address',
    'payment_method_id',
    ]
    
    public function user() {
        return $this->belongsTo(User::Class);
    }

    
    public function paymentMethod() {
        return $this->belongsTo(PaymentMethod::Class);
    }

    public function CartItem() {
        return $this->hasMany(CartItem::Class);
    }
}
