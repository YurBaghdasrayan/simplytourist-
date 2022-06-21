<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourDificultiesList extends Model
{
    use HasFactory;

    protected $table='tour_dificulties_list';

    public function diff()
    {
        return $this->belongsTo(\App\Models\TourDificultly::class,'dificult_id');
    }
}
