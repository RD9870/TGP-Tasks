<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $fillable = [ 'name'];

    // define relationship manufacturer has many products
    public function products(){
        return $this->hasMany(Product::class);
    }
}
