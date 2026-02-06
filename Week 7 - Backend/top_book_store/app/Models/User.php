<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    // The attributes that are mass assignable.
    protected $fillable = [
        'name',
        'username',
        'password',
        'type',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */

    // The attributes that should be hidden for serialization.
    protected $hidden = [
        'password',
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

    // Relationships

    // A user can be an author or a customer
    public function author(){
        return $this->hasOne(Author::class);
    }

    // A user can be an author or a customer
    public function customer(){
        return $this->hasOne(Customer::class);
    }

    // A user can have many books (if they are an author)
    public function books(){
        return $this->belongsToMany(Book::class, 'book_user');
    }

    // An aurhoe has to be approved before they can add books
    public function approve(){
        $this->status = 'approve';
        $this->save();
    }

    // Translate the status to Arabic
    public function translateStatus()
    {
        if($this->status == 'approve')
        {
            return 'تم القبول';
        }
        return $this->status;
    }
}
