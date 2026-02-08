<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    // Mass assignable attributes
    protected $fillable =
    [
    'cashier_id',
    'total',
    ];

    // receipt has many receipt items
    public function items() {
    return $this->hasMany(Receipt_items::class, 'recipt_id');
}
}
