<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
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
        'nom',
        'prenom',
        'email',
        'tel',
        /* 'userable_id',
        'userable_type', */
        'role',
        'password',
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
        'password' => 'hashed',
    ];

    /* public function userable():MorphTo
    {
        return $this->morphTo();
    }

    public function isGestionnaire(): bool
    {
        return $this->userable instanceof Gestionnaire;
    }

    public function isClient(): bool
    {
        return $this->userable instanceof Client;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            $user->userable()->delete();
        });
    } */

    public function isGestionnaire(): bool
    {
        return $this->role === 'gestionnaire';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function client():HasOne
    {
        return $this->hasOne(Client::class);
    }

    public function gestionnaire():HasOne
    {
        return $this->hasOne(Gestionnaire::class);
    }

}