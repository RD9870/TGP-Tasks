<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt_items extends Model
{
    protected $fillable =
    [
    'recipt_id',
    'product_id',
    'quantity',
    'item_total',
    ];

   public function receipt()
{
    return $this->belongsTo(Receipt::class, 'recipt_id');
}
public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
