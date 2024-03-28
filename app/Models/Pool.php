<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pool extends Model
{
    use HasFactory;

    protected $fillable = ['pool_type'];

    public function infrastructure()
    {
        return $this->morphOne(Infrastructure::class, 'infrastructureable')->withDefault();
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($pool) {
            $pool->infrastructure()->delete();
        });
    }

    

}
