<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // The attributes that are mass assignable.
    protected $fillable = [
        'title',
        'publish_year',
        'price',
        'isbn',
        'category_id',
        "stock",
    ];

// Relationships

    // A book belongs to a category
    public function category(){
        return $this->belongsTo(Category::class);
    }

    // A book belongs to many users (many-to-many relationship)
    public function user(){
        return  $this->belongsToMany(User::class, 'book_user');
    }
}
