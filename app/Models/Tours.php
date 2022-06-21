<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Traits\Spatial;
use Illuminate\Database\Eloquent\Builder;
use Flash;
/**
 * Class Tours
 * @package App\Models
 * @version September 16, 2021, 11:54 am UTC
 *
 * @property string $tour_name
 * @property string $country_iso
 * @property integer $tour_type_id
 * @property boolean $tour_type_rating
 * @property integer $tour_condition_id
 * @property boolean $tour_condition_rating
 * @property string|\Carbon\Carbon $tour_date_start
 * @property string|\Carbon\Carbon $tour_date_end
 * @property string $tour_description
 * @property string $tour_link
 * @property string $tour_creator
 * @property string|\Carbon\Carbon $tour_created_datetime
 * @property boolean $attendees_min
 * @property integer $attendees_max
 * @property integer $open_places
 * @property string $guide_needed
 * @property string $guided
 * @property number $estimated_costs
 * @property string $tour_status
 * @property string $edit_lock
 * @property string $tour_private
 * @property string $target_longitude
 * @property string $target_latitude
 * @property string $target_coordinates
 */
class Tours extends Model
{
    //Todo нужно дописать  проверку с учетом количества оборудования на наличие в рюкзаке
    use HasFactory, Spatial;

    public $table = 'tours';
    protected $perPage = 10;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];
    protected $appends = ['CanEdit', 'OpenPlacez'];


    public $fillable = [
        'tour_name',
        'country_iso',
        'tour_type_id',
        'tour_type_rating',
        'tour_condition_id',
        'tour_condition_rating',
        'tour_date_start',
        'tour_date_end',
        'tour_description',
        'tour_link',
        'tour_creator',
        'tour_created_datetime',
        'attendees_min',
        'attendees_max',
        'open_places',
        'guide_needed',
        'guided',
        'estimated_costs',
        'tour_status',
        'edit_lock',
        'tour_private',
        'target_longitude',
        'target_latitude',
        'target_coordinates',
        'tour_type_description',
        'tour_condition_description',
        'image',
        'geo_object_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'tour_name' => 'string',
        'country_iso' => 'string',
        'tour_type_id' => 'integer',
        'tour_type_rating' => 'integer',
        'tour_condition_id' => 'integer',
        'tour_condition_rating' => 'integer',
        'tour_date_start' => 'date:d.m.Y',
        'tour_date_end' => 'date:d.m.Y',
        'tour_description' => 'string',
        'tour_link' => 'string',
        'tour_creator' => 'string',
        'tour_created_datetime' => 'datetime',
        'attendees_min' => 'integer',
        'attendees_max' => 'integer',
        'open_places' => 'integer',
        'guide_needed' => 'string',
        'guided' => 'string',
        'estimated_costs' => 'string',
        'tour_status' => 'string',
        'edit_lock' => 'string',
        'tour_private' => 'string',
        'target_longitude' => 'string',
        'target_latitude' => 'string',
        'target_coordinates' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'tour_name' => 'required|string|max:255',
        'country_iso' => 'required|string|max:2',
        'tour_type_id' => 'required|integer',
        'tour_condition_id' => 'required|integer',
        'geo_object_coordinates' => 'nullable|required_without:geo_object_id|regex:/^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/|max:255',
        'geo_object_id' => 'nullable|required_without:geo_object_coordinates|integer',
        'tour_link' => 'nullable|url',
    ];

    //Переводы для сообщений валидации
    public static function getAttr()
    {
        return [
            'tour_name' => __('Tour name'),
            'country_iso' => __('Country'),
            'tour_type_id' => __('Tour type'),
            'tour_condition_id' => __('Tour conditions'),
            'target_coordinates' => __('Tour coordinates'),
            'tour_dificult' => __('Tour type complexity'),
            'tour_link' => __('Tour link'),
            'geo_object_id'=>__('Main destination'),
            'geo_object_coordinates'=>"'".__('Create main destination - coordinates')."'"
        ];
    }

    public function scopeMoreTypeRating(Builder $query, $value): Builder
    {
        return $query->where('tour_type_rating', '>=', $value);
    }

    public function scopeMoreConditionRating(Builder $query, $value): Builder
    {
        return $query->where('tour_condition_rating', '>=', $value);
    }

    public function scopeMoreOpenPlaces(Builder $query, $value): Builder
    {
        return $query->where('open_places', '>=', $value);
    }

    public function scopeGuide(Builder $query, $value): Builder
    {
        $values = explode(',', $value);
        if (in_array('guide_needed', $values)) {
            $query = $query->where('guide_needed', '=', 1)->orWhere('guide_needed', '=', 'on');
        }
        if (in_array('guided', $values)) {
            $query = $query->where('guided', '=', 1)->orWhere('guided', '=', 'on');
        }
        return $query;
    }

    public function scopeDificult(Builder $query, $value): Builder
    {
        $values = [];
        if ($value) {
            array_push($values, $value);
            $query->whereHas('dificult', function ($query) use ($values) {
                $query->whereIn('dificult_id', $values);
            });
        }
        return $query;
    }

    //Видят тур только создатели или включенные в таблицу attends(члены туры)
    public function scopeAttend(Builder $query, $value): Builder
    {
        if ($value) {
            $user_id = Auth::id();
            $query->whereHas('attend', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })->orWhere('tour_creator', '=', $user_id);
        }
        return $query;
    }

    public function scopeAllowedTours(Builder $query, $value): Builder
    {
        if ($value) {
            $query->attend($value)->where('tour_private', '=', 1)->orWhere('tour_private', '=', 0);
        }
        return $query;
    }

    public function attend()
    {
        return $this->hasMany(TourAttendees::class,'tour_id');
    }
    public function tourType()
    {
        return $this->belongsTo(\App\Models\ToursTypes::class, 'tour_type_id');
    }
    public function tourConditions()
    {
        return $this->belongsTo(\App\Models\ToursConditions::class, 'tour_condition_id');
    }
    public function tourLanguage()
    {
        return $this->belongsTo(\App\Models\Languages::class, 'country_iso');
    }
    public function tourEquip()
    {
        return $this->hasMany(\App\Models\Equipment::class);
    }
    public function tourReports()
    {
        return $this->hasMany(\App\Models\TourReports::class,'tour_id');
    }
    public function tourDiscussion()
    {
        return $this->hasMany(\App\Models\UsergroupThemes::class,'tour_id');
    }

    public function tourDificult()
    {
        return $this->hasManyThrough(TourDificultiesList::class,TourDificultly::class,
            'id','tour_id',
            'id','id');
    }
    public function dificult()
    {
        return $this->hasMany(TourDificultiesList::class,'tour_id');
    }
    //Доступные статусы для туров
    public static $allowedStatuses=['open','canceled','done'];
    //Установка нового статуса для тура
    public static function setStatus($tour_status,$tour_id){
        if(in_array($tour_status,self::$allowedStatuses)){
            $tour=self::find($tour_id);
            if($tour->tour_status==='open'){
                $tour->update(['tour_status'=>$tour_status]);
                return true;
            }
        }
        return false;
    }

    public static function getTourMembers($tour_id,$tour_creator){
        $author=User::where('id','=',$tour_creator)->get();
        $tour_attendees=TourAttendees::where('tour_id','=',$tour_id)->with('user')->pluck('user_id');
        $attendees_users=User::whereIn('id',$tour_attendees)->get();
        $result=$author->merge($attendees_users);
        return $result;
    }

    public static function getTourMembersMail($tour_id,$tour_creator){
        $author=User::find($tour_creator);
        $tour_attedndees=TourAttendees::where('tour_id','=',$tour_id)->with('user')->get();
        $send_list=[$author->email];
        foreach ($tour_attedndees as $ta){
            if(isset($ta->user)&&isset($ta->user->email))
                $send_list[]=$ta->user->email;
        }
        return $send_list;
    }


    //проверяем доступ на возможность редактирования тура
    public function getCanEditAttribute(){
        $user=Auth::user();
        //Если юзер админ
        if($user->role_id==1)
            return true;
        if($this->tour_creator==$user->id){
            return true;
        }
        foreach ($this->attend as $attend){
            if($user->id==$attend->user_id && $attend->tour_admin==1){
                return true;
            }
        }
        return false;
    }
    public static function checkEditAccess($tour_id){
        $tour=Tours::where('id','=',$tour_id)->first();
        if (!$tour->CanEdit) {
            Flash::error(__('Access denied'));
            return redirect(route('tours.index'))->send();
        }
    }

    /**
     * проверка что текущий или заданный пользователь является членом тура
     * @param $tour_id
     * @return bool
     */
    public static function isTourMember($tour_id, $user_id=false){
        $tour=self::where('id','=',$tour_id)->first();
        if($user_id===false)
            $user=Auth::user();
        else{
            if($user_id!=null)
                $user=User::find($user_id);
            else
                return true;
        }
        //Если юзер админ
        if($user->role_id==1)
            return true;
        //если юзер автор тура
        if($tour->tour_creator==$user->id){
            return true;
        }
        foreach ($tour->attend as $attend){
            if($user->id==$attend->user_id){
                return true;
            }
        }
        return false;
    }
    public function getOpenPlacezAttribute(){
        //Возвращаем 0 в случае если разница между attendees_max и реальным числом негативная
        return max(($this->attendees_max-$this->attend()->count()),0);
    }
}
