<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class EquipmentType
 * @package App\Models
 * @version September 24, 2021, 9:43 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $equipment
 * @property string $name_en
 * @property string $name_de
 * @property string $name_ru
 */
class EquipmentType extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'equipment_type';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name_en',
        'name_de',
        'name_ru'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name_en' => 'string',
        'name_de' => 'string',
        'name_ru' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name_en' => 'nullable|string|max:190',
        'name_de' => 'nullable|string|max:191',
        'name_ru' => 'nullable|string|max:191',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function equipment()
    {
        return $this->hasMany(\App\Models\Equipment::class, 'equipment_type_id');
    }

    public static function getEquipmentsType($locale){
        //Todo переписать чтобы не было сортировки
        return EquipmentType::orderBy('name_'.$locale)->get()->toJson();
    }
}
