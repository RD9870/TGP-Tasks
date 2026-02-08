<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Mass assignable attributes
    protected $fillable =
    [
    'code',
    'name',
    'subcategory_id',
    'price',
    'manufacture_id',
    'import_company_id',
    'image',
    'minimum',
    'isStockLow',
    ];

    // product belongs to a manufacturer
    public function manufacture() {
        return $this->belongsTo(Manufacturer::class, 'manufacture_id');
    }

    // product belongs to an import company
    public function importCompany(){
        return $this->belongsTo(ImportCompany::class, 'import_company_id');
    }

    // product belongs to a subcategory
    public function subcategory(){
        return $this->belongsTo(Subcategory::class ,'subcategory_id');
    }

    // product has one stock
    public function stock(){
        return $this->hasOne(Stock::class);
    }
}
