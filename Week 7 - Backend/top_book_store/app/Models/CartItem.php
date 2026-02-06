<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    // The attributes that are mass assignable.
    protected $fillable = [
        'cart_id',
        'book_id',
        'qty',
    ];

    // Relationships

    // A cart item belongs to a cart
    public function cart(){
        return $this->belongsTo(Cart::class);
    }

    // A cart item belongs to a book
    public function book(){
        return $this->belongsTo(Book::class);
    }

    // Calculate the total price of the cart item
    public function totalItem(){
        return $this->book->price * $this->qty;
    }
}
