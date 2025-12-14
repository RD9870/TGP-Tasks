<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    'user_id',
    'total',
    'payment_methos_id',
    'adress',
    'status'
    ]

    
    public function user() {
        return $this->belongsTo(User::Class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    
    public function orderItem() {
        return $this->hasMany(OrderItem::Class);
    }
}
