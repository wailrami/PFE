<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    public function user():BelongsTo
    {
        //return $this->morphOne(User::class,'userable');
        return $this->belongsTo(User::class);
    }

    public function reservations():HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($client) {
            $client->user()->delete();
        });
    }

}
