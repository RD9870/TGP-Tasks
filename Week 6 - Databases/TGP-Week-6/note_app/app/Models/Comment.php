<?php

namespace App\Models;

use App\Models\Note;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{

     protected $fillable = [
        'content',
        "note_id",
    ];



public function note()
{
    return $this->belongsTo(Note::class, "note_id");
}
}
