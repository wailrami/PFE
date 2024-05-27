<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['res_date','start_time','end_time', 'etat', 'infrastructure_id', 'client_id'];

    public function client():BelongsTo
    {
        return $this->belongsTo(Client::class);
    }


    public function infrastructure():BelongsTo
    {
        return $this->belongsTo(Infrastructure::class);
    }

    //Validate The reservation date and time if it is available or not, if there is a conflict return false
    public static function validateReservation($infrastructure_id, $res_date, $start_time, $end_time):bool
    {
        $reservations = Reservation::where('infrastructure_id', $infrastructure_id)
            ->where('res_date', $res_date)
            ->where('etat', 'accepte')
            ->get();
        foreach($reservations as $reservation){
            if($start_time >= $reservation->start_time && $start_time < $reservation->end_time){
                return false;
            }
            if($end_time > $reservation->start_time && $end_time <= $reservation->end_time){
                return false;
            }
            if($start_time <= $reservation->start_time && $end_time >= $reservation->end_time){
                return false;
            }
        }
        return true;
    }


}
