<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourDificultly extends Model
{
    use HasFactory;

    protected $table="tour_dificultly";
    public function diff()
    {
        return $this->hasMany(\App\Models\TourDificultiesList::class,'dificult_id');
    }
}
