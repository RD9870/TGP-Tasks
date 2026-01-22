<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Transfer;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    'name',
    'phone',
    'password',
    'balance',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function allTransfers()
{
    return Transfer::where('sender_id', $this->id)
                   ->orWhere('receiver_id', $this->id);
}

      public function sentTransfers()
    {
        return $this->hasMany(Transfer::class, 'sender_id');
    }

    // Transfers this user received
    public function receivedTransfers()
    {
        return $this->hasMany(Transfer::class, 'receiver_id');
    }

    //TODO ADD LSTER
    //     public function topUps()
    // {
    //     return $this->hasMany(TopUps::class, 'user_id');
    // }
}
