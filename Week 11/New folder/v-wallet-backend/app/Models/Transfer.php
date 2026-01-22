<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transfer  extends Model
{

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'sender_id',
        'receiver_id',
        'amount',
        'status',
        'expires_at'
    ];


      public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }


    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
