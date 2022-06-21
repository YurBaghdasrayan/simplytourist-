<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ToursTypesRatings
 * @package App\Models
 * @version September 24, 2021, 12:50 pm UTC
 *
 * @property integer $tour_type_id
 * @property boolean $tour_type_rating
 * @property string $description_de
 * @property string $description_en
 * @property string $description_ru
 */
class ToursTypesRatings extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'tours_types_ratings';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'id',
        'tour_type_rating',
        'description_de',
        'description_en',
        'description_ru'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'tour_type_id' => 'integer',
        'tour_type_rating' => 'integer',
        'description_de' => 'string',
        'description_en' => 'string',
        'description_ru' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'tour_type_rating' => 'required|boolean',
        'description_de' => 'nullable|string',
        'description_en' => 'nullable|string',
        'description_ru' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];


}
