<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;

    protected $fillable = ['hall_type'];
    public $timestamps = false;

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


    public static function getAllInfrastructureHalls()
    {
        return Hall::join('infrastructures', 'infrastructures.infrastructable_id', '=', 'halls.id')
            ->where('infrastructures.infrastructable_type', 'hall')
            ->select('halls.*')
            ->get();
    }

    


}
