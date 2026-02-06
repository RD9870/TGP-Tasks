<?php

namespace App\Models;

use App\Models\Note;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    // The attributes that are mass assignable.
    protected $fillable = [
        'content',
        "note_id",
    ];

// Define the relationship with the Note model
    public function note()
{
    return $this->belongsTo(Note::class, "note_id");
}
}
