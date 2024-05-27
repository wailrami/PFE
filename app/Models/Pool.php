<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pool extends Model
{
    use HasFactory;

    protected $fillable = ['pool_type'];
    public $timestamps = false;

    public function infrastructure()
    {
        return $this->morphOne(Infrastructure::class, 'infrastructable')->withDefault();
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($pool) {
            $pool->infrastructure()->delete();
        });
    }

    
    public static function getAllInfrastructurePools()
    {
        return Pool::join('infrastructures', 'infrastructures.infrastructable_id', '=', 'pools.id')
            ->where('infrastructures.infrastructable_type', 'pool')
            ->select('pools.*')
            ->get();
    }

}
