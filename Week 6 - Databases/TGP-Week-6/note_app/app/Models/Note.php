<?php

namespace App\Models;

use App\Models\SubNote;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class note extends Model
{
    protected $fillable = [
    'title',
    'description',
    'isChecked',
    'user_id',
];

public function subNotes(){
    return $this->hasMany(SubNote::class,"main_note");
}

public function user()
{
    return $this->belongsTo(User::class);
}

public function noteComments(){
    return $this->hasMany(Comment::class,"note_id");
}

}
