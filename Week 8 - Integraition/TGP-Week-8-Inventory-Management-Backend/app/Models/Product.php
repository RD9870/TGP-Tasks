<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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
       public function manufacture()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacture_id');
    }

    public function importCompany()
    {
        return $this->belongsTo(ImportCompany::class, 'import_company_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class ,'subcategory_id');
    }
 public function stock()
    {
        return $this->hasOne(Stock::class);
    }
        //     public function stock(){
    //     return $this->hasMany(Stock::class);
    // }

}
