<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable =
    [
    'cashier_id',
    'total',
    ];
    public function items()
{
    return $this->hasMany(Receipt_items::class, 'recipt_id');
}
}
