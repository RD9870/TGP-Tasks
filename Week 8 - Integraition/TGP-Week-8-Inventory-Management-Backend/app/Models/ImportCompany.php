<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportCompany extends Model
{
    // Mass assignable attributes
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    // Define relationship with import company has many products
    public function products(){
        return $this->hasMany(Product::class);
    }
}
