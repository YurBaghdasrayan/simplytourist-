<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

/**
 * Class TourEquipment
 * @package App\Models
 * @version September 24, 2021, 9:30 am UTC
 *
 * @property integer $tour_id
 * @property integer $equipment_id
 * @property integer $equipment_type_id
 * @property string $equipment_note
 */
class TourEquipment extends Model
{

    use HasFactory;

    public $table = 'tour_equipment';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    protected $appends = ['InMyEquipment'];
//
    public $fillable = [
        'tour_id',
        'equipment_id',
        'equipment_type_id',
        'equipment_note',
        'equipment_qty'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'tour_id' => 'integer',
        'equipment_id' => 'integer',
        'equipment_type_id' => 'integer',
        'equipment_note' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'tour_id' => 'required|integer',
        'equipment_id' => 'required|integer',
        'equipment_type_id' => 'required|integer',
        'equipment_note' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];
    public function equipment()
    {
        return $this->belongsTo(\App\Models\Equipment::class, 'equipment_id');
    }
    public function shop()
    {
        return $this->hasMany(\App\Models\Shop::class, 'equipment_id');
    }
    public function getInMyEquipmentAttribute(){
        $qty=1;
        if($this->equipment_qty)
            $qty=$this->equipment_qty;
        return UserEquipment::inMyBag($this->equipment_id,$qty);
    }
}
