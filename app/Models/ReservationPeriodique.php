<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationPeriodique extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'start_time',
        'end_time',
        'type_period',
        'end_date',
        'etat',
        'client_id',
        'infrastructure_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function infrastructure()
    {
        return $this->belongsTo(Infrastructure::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
