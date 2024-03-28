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

    protected $fillable = ['name', 'ville', 'cite', 'description', 'gestionnaire_id', 'infrastructable_id', 'infrastructable_type'];

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

    

}
