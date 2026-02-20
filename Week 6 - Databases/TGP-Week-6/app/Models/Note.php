<?php

namespace App\Models;

use App\Models\SubNote;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class note extends Model
{
    // The attributes that are mass assignable.
    protected $fillable = [
    'title',
    'description',
    'isChecked',
    'user_id',
];

// Define the relationship with the SubNote model
public function subNotes(){
    return $this->hasMany(SubNote::class,"main_note");
}

// Define the relationship with the User model
public function user(){
    return $this->belongsTo(User::class);
}

// Define the relationship with the Comment model
public function noteComments(){
    return $this->hasMany(Comment::class,"note_id");
}
}
