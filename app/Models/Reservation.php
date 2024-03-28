<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    public function client():BelongsTo
    {
        return $this->belongsTo(Client::class);
    }


    public function infrastructure():BelongsTo
    {
        return $this->belongsTo(Infrastructure::class);
    }

}
