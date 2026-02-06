<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // The attributes that are mass assignable.
    protected $fillable = [
        'name',
    ];

    // Relationships

    // A category has many books
    public function books(){
        return $this->hasMany(Book::class);
    }
}
