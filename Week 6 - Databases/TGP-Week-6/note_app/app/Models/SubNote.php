<?php

namespace App\Models;

use App\Models\Note;
use Illuminate\Database\Eloquent\Model;

class SubNote extends Model
{
    protected $fillable = [
        'main_note',
        "title",
        'description',
        "isChecked",
    ];


public function note()
{
    return $this->belongsTo(Note::class, "main_note");
}
}
