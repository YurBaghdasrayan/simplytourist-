<?php

namespace App\Models;

use Eloquent as Model;
use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class Equipment
 * @package App\Models
 * @version September 20, 2021, 7:45 am UTC
 *
 * @property \App\Models\EquipmentType $equipmentType
 * @property string $name_en
 * @property string $name_de
 * @property string $name_ru
 * @property integer $equipment_type_id
 * @property string $packlist_hiking_daytour
 * @property string $packlist_skitour
 * @property string $packlist_via_ferrata
 * @property string $packlist_ice_climbing
 * @property string $packlist_bouldering_on_rock
 * @property string $packlist_expedition
 * @property string $packlist_indoor_climbing
 * @property string $packlist_snowshoe_tour
 */
class Equipment extends Model
{
//    use SoftDeletes;

    use HasFactory;

    public $table = 'equipment';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    protected $appends = ['shop_ru','shop_en','shop_de','in_my_equip'];


    public $fillable = [
        'name_en',
        'name_de',
        'name_ru',
        'equipment_type_id',
        'packlist_hiking_daytour',
        'packlist_skitour',
        'packlist_via_ferrata',
        'packlist_ice_climbing',
        'packlist_bouldering_on_rock',
        'packlist_expedition',
        'packlist_indoor_climbing',
        'packlist_snowshoe_tour'
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
        'name_ru' => 'string',
        'equipment_type_id' => 'integer',
        'packlist_hiking_daytour' => 'string',
        'packlist_skitour' => 'string',
        'packlist_via_ferrata' => 'string',
        'packlist_ice_climbing' => 'string',
        'packlist_bouldering_on_rock' => 'string',
        'packlist_expedition' => 'string',
        'packlist_indoor_climbing' => 'string',
        'packlist_snowshoe_tour' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name_en' => 'nullable|string|max:255',
        'name_de' => 'nullable|string|max:255',
        'name_ru' => 'nullable|string|max:255',
        'equipment_type_id' => 'nullable|integer',
        'packlist_hiking_daytour' => 'nullable|string|max:3',
        'packlist_skitour' => 'nullable|string|max:3',
        'packlist_via_ferrata' => 'nullable|string|max:3',
        'packlist_ice_climbing' => 'nullable|string|max:3',
        'packlist_bouldering_on_rock' => 'nullable|string|max:3',
        'packlist_expedition' => 'nullable|string|max:3',
        'packlist_indoor_climbing' => 'nullable|string|max:3',
        'packlist_snowshoe_tour' => 'nullable|string|max:3',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function equipmentType()
    {
        return $this->belongsTo(\App\Models\EquipmentType::class, 'equipment_type_id');
    }
    public function user_equip(){
        return $this->hasMany(\App\Models\UserEquipment::class);
    }
    public function tour_equip(){
        return $this->hasMany(\App\Models\TourEquipment::class);
    }

    /**
     * Проверка наличия в рюкзаке пользователя необходимого снаряжения
     * В необходимом количестве
     * @return bool
     */
    public function getInMyEquipAttribute(){
        $equip=UserEquipment::where('user_id','=',Auth::id())->where('equipment_id','=',$this->id)->get();
        return (bool)$equip;
    }
    public static function addMyEquipment($equipment_ids){
        $user_id=Auth::id();
        $equipments=Equipment::whereIn('id',$equipment_ids)->get();
        foreach($equipments as $equip){
            DB::table('user_equipment')->insert([
                'user_id' => $user_id,
                'equipment_id' => $equip->id,
                'equipment_type_id'=>$equip->equipment_type_id
            ]);
        }
    }
    public static function removeMyEquipment($equipment_ids){
        $user_id=Auth::id();
        if(gettype($equipment_ids)==='array'&&count($equipment_ids)>0){
            DB::table('user_equipment')
                ->where('user_id','=',$user_id)
                ->whereIn('user_equipment_id',$equipment_ids)
                ->delete();
        }
    }
    public function getShopRuAttribute(){
        $shop=Shop::where('equipment_id','=',$this->id)->first();
        if($shop)
            return '<a href="'.$shop->shop_url_ru.'" target="_blank">'.$shop->name_ru.'</a>';
        $shop=Shop::where('equipment_type_id','=',$this->equipment_type_id)->first();
        if($shop)
            return '<a href="'.$shop->shop_url_ru.'" target="_blank">'.$shop->name_ru.'</a>';
        $shop=Shop::where('is_default','=','1')->first();
        if($shop)
            return '<a href="'.$shop->shop_url_ru.'" target="_blank">'.$shop->name_ru.'</a>';
        return '';
    }
    public function getShopEnAttribute(){
        $shop=Shop::where('equipment_id','=',$this->id)->first();
        if($shop)
            return '<a href="'.$shop->shop_url_en.'" target="_blank">'.$shop->name_en.'</a>';
        $shop=Shop::where('equipment_type_id','=',$this->equipment_type_id)->first();
        if($shop)
            return '<a href="'.$shop->shop_url_en.'" target="_blank">'.$shop->name_en.'</a>';
        $shop=Shop::where('is_default','=','1')->first();
        if($shop)
            return '<a href="'.$shop->shop_url_en.'" target="_blank">'.$shop->name_en.'</a>';
        return '';
    }
    public function getShopDeAttribute(){
        $shop=Shop::where('equipment_id','=',$this->id)->first();
        if($shop)
            return '<a href="'.$shop->shop_url_de.'" target="_blank">'.$shop->name_de.'</a>';
        $shop=Shop::where('equipment_type_id','=',$this->equipment_type_id)->first();
        if($shop)
            return '<a href="'.$shop->shop_url_de.'" target="_blank">'.$shop->name_de.'</a>';
        $shop=Shop::where('is_default','=','1')->first();
        if($shop)
            return '<a href="'.$shop->shop_url_de.'" target="_blank">'.$shop->name_de.'</a>';
        return '';
    }
}
