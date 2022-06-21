<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ToursConditions
 * @package App\Models
 * @version September 24, 2021, 11:58 am UTC
 *
 * @property string $name_en
 * @property string $description_en
 * @property string $name_de
 * @property string $description_de
 * @property string $name_ru
 * @property string $description_ru
 */
class ToursConditions extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'tours_conditions';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name_en',
        'description_en',
        'name_de',
        'description_de',
        'name_ru',
        'description_ru'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name_en' => 'string',
        'description_en' => 'string',
        'name_de' => 'string',
        'description_de' => 'string',
        'name_ru' => 'string',
        'description_ru' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name_en' => 'required|string|max:255',
        'description_en' => 'required|string',
        'name_de' => 'required|string|max:255',
        'description_de' => 'required|string',
        'name_ru' => 'required|string|max:255',
        'description_ru' => 'required|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    
}
