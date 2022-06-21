<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeoObject extends Model
{
    use HasFactory;
    public $table='geo_objects';
    protected $fillable=[
      'countries','country_iso','coordinates','name_en','name_ru','name_de','country_iso'
    ];
}
