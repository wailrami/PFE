<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gestionnaire extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    /* public function user()
    {
        return $this->morphOne(User::class,'userable');
    } */

    public function infrastructures():HasMany
    {
        return $this->hasMany(Infrastructure::class);
    }


    /* protected static function boot()
    {
        parent::boot();

        static::deleting(function ($gestionnaire) {
            $gestionnaire->user()->delete();
        });
    } */

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
