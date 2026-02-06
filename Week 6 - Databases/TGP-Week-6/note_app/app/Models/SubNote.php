<?php

namespace App\Models;

use App\Models\Note;
use Illuminate\Database\Eloquent\Model;

class SubNote extends Model
{
    // The attributes that are mass assignable.
    protected $fillable = [
        'main_note',
        "title",
        'description',
        "isChecked",
    ];

// Define the relationship to the Note model
public function note(){
    return $this->belongsTo(Note::class, "main_note");
}
}
