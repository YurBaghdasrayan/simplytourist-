<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ToursConditionsRatings
 * @package App\Models
 * @version September 24, 2021, 12:50 pm UTC
 *
 * @property integer $tour_condition_id
 * @property boolean $tour_condition_rating
 * @property string $description_de
 * @property string $description_en
 * @property string $description_ru
 */
class ToursConditionsRatings extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'tours_conditions_ratings';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'id',
        'tour_condition_rating',
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
        'tour_condition_id' => 'integer',
        'tour_condition_rating' => 'integer',
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
        'tour_condition_rating' => 'required|boolean',
        'description_de' => 'nullable|string',
        'description_en' => 'nullable|string',
        'description_ru' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];


}
