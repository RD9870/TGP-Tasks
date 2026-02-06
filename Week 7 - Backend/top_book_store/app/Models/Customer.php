<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // The attributes that are mass assignable.
    protected $fillable = [
        'phone_number',
        'address',
        'email',
    ];
}
