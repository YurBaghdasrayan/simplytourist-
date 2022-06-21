<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ToursTypes
 * @package App\Models
 * @version September 24, 2021, 12:49 pm UTC
 *
 * @property string $name_de
 * @property string $name_en
 * @property string $name_ru
 */
class ToursTypes extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'tours_types';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name_de',
        'name_en',
        'name_ru'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name_de' => 'string',
        'name_en' => 'string',
        'name_ru' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name_de' => 'required|string|max:255',
        'name_en' => 'required|string|max:255',
        'name_ru' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    
}
