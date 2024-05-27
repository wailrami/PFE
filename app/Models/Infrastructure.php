<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Infrastructure extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'ville', 'cite', 'description','main_image', 'main_image_mime' , 'gestionnaire_id', 'infrastructable_id', 'infrastructable_type'];

    public function gestionnaire(): BelongsTo
    {
        return $this->belongsTo(Gestionnaire::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function infrastructable(): MorphTo
    {
        return $this->morphTo();
    }

    // Add the following method to enable cascading delete
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($infrastructure) {
            $infrastructure->infrastructable()->delete();
        });
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    //get All Stadiums 
    public static function getAllStadiums()
    {
        return Infrastructure::where('infrastructable_type', 'stadium')->get();
    }

    //get All Pools
    public static function getAllPools()
    {
        return Infrastructure::where('infrastructable_type', 'pool')->get();
    }

    //get All Halls
    public static function getAllHalls()
    {
        return Infrastructure::where('infrastructable_type', 'hall')->get();
    }


}
