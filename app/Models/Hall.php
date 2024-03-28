<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;

    protected $fillable = ['hall_type'];

    public function infrastructure()
    {
        return $this->morphOne(Infrastructure::class, 'infrastructable')->withDefault();
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($hall) {
            $hall->infrastructure()->delete();
        });
    }

    


}
