<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
"title",
'price',
'publication_year',
'ISBN',
'category_id',
    ];

    public function category() {
        return $this->belongsTo(Category::Class);
    }

    public function user() {
        return $this->belongsToMany(User::Class);
    }
}
