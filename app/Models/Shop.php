<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Shop
 * @package App\Models
 * @version October 1, 2021, 9:04 am UTC
 *
 * @property string $name_ru
 * @property string $name_en
 * @property integer $name_de
 * @property integer $equipment_id
 * @property integer $equipment_type_id
 * @property integer $shop_url_ru
 * @property integer $shop_url_en
 * @property integer $shop_url_de
 * @property string $is_default
 */
class Shop extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'shop';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name_ru',
        'name_en',
        'name_de',
        'equipment_id',
        'equipment_type_id',
        'shop_url_ru',
        'shop_url_en',
        'shop_url_de',
        'is_default'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name_ru' => 'string',
        'name_en' => 'string',
        'name_de' => 'string',
        'equipment_id' => 'integer',
        'equipment_type_id' => 'integer',
        'shop_url_ru' => 'string',
        'shop_url_en' => 'string',
        'shop_url_de' => 'string',
        'is_default' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name_ru' => 'nullable|string|max:256',
        'name_en' => 'nullable|string|max:256',
        'name_de' => 'nullable|integer',
        'equipment_id' => 'nullable|integer',
        'equipment_type_id' => 'nullable|integer',
        'shop_url_ru' => 'nullable|integer',
        'shop_url_en' => 'nullable|integer',
        'shop_url_de' => 'nullable|integer',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable',
        'is_default' => 'nullable|string|max:3'
    ];


}
