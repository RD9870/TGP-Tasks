<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    // Mass assignable attributes
    protected $fillable =
    [
    'product_id',
    'quantity',
    'cost_price',
    ];

    // stock belongs to a product
    public function product(){
    return $this->belongsTo(Product::class);
    }
}
