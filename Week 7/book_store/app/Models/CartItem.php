<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
    'book_id',
    'cart_id',
    'quantity',
    ]
    

    
    public function cart() {
        return $this->belongsTo(Cart::Class);
    }

    
    public function book() {
        return $this->belongsTo(Book::Class);
    }
}

