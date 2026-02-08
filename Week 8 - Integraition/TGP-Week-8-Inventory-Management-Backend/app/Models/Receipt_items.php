<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt_items extends Model
{
    // Mass assignable attributes
    protected $fillable =
    [
    'recipt_id',
    'product_id',
    'quantity',
    'item_total',
    ];

    // receipt item belongs to a receipt
    public function receipt(){
    return $this->belongsTo(Receipt::class, 'recipt_id');
}

// receipt item belongs to a product
public function product(){
        return $this->belongsTo(Product::class);
    }
}
