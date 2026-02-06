<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    // The attributes that are mass assignable.
    protected $fillable = [
        'name',
    ];

    // Relationships

    // A payment method has many orders
    public function orders(){
        return $this->hasMany(Order::class);
    }
}
