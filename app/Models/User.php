<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'user_id', 'favorite_user_id');
    }

    public function favorite()
    {
        return $this->belongsToMany(User::class, 'favorites', 'favorite_user_id')
                    ->where('user_id', auth()->user()->id);
    }

    public function unreadMessages()
    {
        return $this->hasMany(Message::class, 'sender_id')
                    ->where('read', false)
                    ->where('receiver_id', auth()->user()->id);
    }

    public function preference()
    {
        return $this->hasOne(Preference::class);
    }

    public function allUsers()
    {
        return $this->inRandomOrder()
                    ->where('id', '!=', auth()->user()->id)
                    ->with(['favorite', 'unreadMessages', 'preference'])
                    ->get();
    }
}
