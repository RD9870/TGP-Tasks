<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // The attributes that are mass assignable.
    protected $fillable = [
        'user_id',
        'payment_method_id',
        'address',
        'total',
        'status',
    ];

    // Relationships

    // An order belongs to a user
    public function user(){
        return $this->belongsTo(User::class);
    }

    // An order belongs to a payment method
    public function paymentMethod(){
        return $this->belongsTo(PaymentMethod::class);
    }

    // An order has many order items
    public function items(){
        return $this->hasMany(OrderItem::class);
    }
}
