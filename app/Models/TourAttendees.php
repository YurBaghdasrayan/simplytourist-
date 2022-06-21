<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class TourAttendees
 * @package App\Models
 * @version September 24, 2021, 9:21 am UTC
 *
 * @property integer $tour_id
 * @property integer $user_id
 * @property string $tour_admin
 */
class TourAttendees extends Model
{
    use HasFactory;

    public $table = 'tour_attendees';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'tour_id',
        'user_id',
        'tour_admin'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'tour_id' => 'integer',
        'user_id' => 'integer',
        'tour_admin' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'tour_id' => 'required|integer',
        'user_id' => 'required|integer',
        'tour_admin' => 'nullable|string|max:3',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id')->withDefault([
            'name' => 'Deleted User',
            'email'=>null
        ]);
    }

    public static function updateAttend(Tours $tour,$user_id){
        self::create([
            'tour_id'=>$tour->id,
            'user_id'=>$user_id,
            'tour_admin'=>0,
        ]);
        //Обновляем количество через атрибут
        $tour->update(['open_places'=>$tour->OpenPlacez]);
    }
    public static function deleteAttend(Tours $tour,$user_id){
        self::where('tour_id','=',$tour->id)
            ->where('user_id','=',$user_id)
            ->delete();
        //Обновляем количество через атрибут
        $tour->update(['open_places'=>$tour->OpenPlacez]);
    }
    public static function getTourAdmins(Tours $tour){
        $tour_admins=self::where('tour_id','=',$tour->id)->where('tour_admin','=',1)->pluck('user_id')->toArray();
        array_push($tour_admins,$tour->tour_creator);
        return User::whereIn('id',$tour_admins)->get();
    }
    public static function isTourAdmin($tour_id,$user_id){
        $tour_admins=self::where('tour_id','=',$tour_id)->where('tour_admin','=',1)->pluck('user_id')->toArray();
        $tour=Tours::find($tour_id);
        array_push($tour_admins,$tour->tour_creator);
        return in_array($user_id,$tour_admins);
    }
}
