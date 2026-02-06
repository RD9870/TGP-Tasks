<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    // The attributes that are mass assignable.
    protected $fillable = [
        'order_id',
        'book_id',
        'qty',
        'price',
    ];

    //  Relationships

    // An order item belongs to an order
    public function order(){
        return $this->belongsTo(Order::class);
    }

    // An order item belongs to a book
    public function book(){
        return $this->belongsTo(Book::class);
    }
}
