<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stadium extends Model
{
    use HasFactory;

    protected $table = 'stadiums';
    public $timestamps = false;
    protected $fillable = ['stadium_type'];

    public function infrastructure()
    {
        return $this->morphOne(Infrastructure::class, 'infrastructable')->withDefault();
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($stadium) {
            $stadium->infrastructure()->delete();
        });
    }

    public static function getAllInfrastructureStadiums()
    {
        return Stadium::join('infrastructures', 'infrastructures.infrastructable_id', '=', 'stadiums.id')
            ->where('infrastructures.infrastructable_type', 'stadium')
            ->select('stadiums.*')
            ->get();
    }

}
