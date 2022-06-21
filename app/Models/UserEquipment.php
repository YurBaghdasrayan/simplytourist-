<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserEquipment
 * @package App\Models
 * @version September 29, 2021, 10:09 am UTC
 *
 * @property \App\Models\User $user
 * @property integer $user_id
 * @property integer $equipment_id
 * @property integer $equipment_type_id
 * @property string $note
 */
class UserEquipment extends Model
{
//    use SoftDeletes;

    use HasFactory;

    public $table = 'user_equipment';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $primaryKey = 'user_equipment_id';

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'equipment_id',
        'equipment_type_id',
        'note'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_equipment_id' => 'integer',
        'user_id' => 'integer',
        'equipment_id' => 'integer',
        'equipment_type_id' => 'integer',
        'note' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'equipment_id' => 'required|integer',
        'equipment_type_id' => 'required|integer',
        'note' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    public static function getFields(){

    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function equipmentType()
    {
        return $this->belongsTo(\App\Models\EquipmentType::class, 'equipment_type_id');
    }
    public function equipment()
    {
        return $this->belongsTo(\App\Models\Equipment::class, 'equipment_id');
    }
    public function shop()
    {
        return $this->hasMany(\App\Models\Shop::class, 'equipment_id');
    }

    /**
     * Проверка наличия снаряжения в рюкзаке
     * @param $equipment_id
     * @param $qty
     * @return bool
     */
    public static function inMyBag($equipment_id, $qty){
        $userEq=self::where('user_id','=',Auth::id())->where('equipment_id','=',$equipment_id)->get()->count();
        if($userEq>=$qty){
            return true;
        }else{
            return false;
        }
    }
}
