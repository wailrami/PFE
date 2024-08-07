<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'mime','infrastructure_id'];
    protected $table = 'images';

    public function infrastructure()
    {
        return $this->belongsTo(Infrastructure::class);
    }

    
}
