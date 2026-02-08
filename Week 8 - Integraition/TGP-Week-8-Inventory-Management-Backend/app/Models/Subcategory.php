<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    // Mass assignable attributes
    protected $fillable =
    [
    'name',
    'category_id',
    ];

    // subcategory belongs to a category
    public function category() {
        return $this->belongsTo(Category::class);
    }

    // subcategory has many products
    public function products() {
        return $this->hasMany(Product::class);
    }
}
