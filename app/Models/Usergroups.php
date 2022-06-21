<?php

namespace App\Models;


use Carbon\Carbon;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Flash;
use TCG\Voyager\Traits\Spatial;

/**
 * Class Usergroups
 * @package App\Models
 * @version September 23, 2021, 8:24 am UTC
 *
 * @property string $usergroup_name
 * @property string $usergroup_description
 * @property string $usergroup_privat
 * @property string $language_iso
 * @property string $country_iso
 * @property integer $member_count
 * @property string $edit_lock
 */
class Usergroups extends Model
{
    use HasFactory, Spatial;

    public $table = 'usergroups';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];
    protected $appends=['MembersCount'];


    public $fillable = [
        'usergroup_name',
        'usergroup_description',
        'usergroup_privat',
        'language_iso',
        'country_iso',
        'member_count',
        'edit_lock',
        'image',
        'group_creator'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'usergroup_name' => 'string',
        'usergroup_description' => 'string',
        'usergroup_privat' => 'string',
        'language_iso' => 'string',
        'country_iso' => 'string',
        'member_count' => 'integer',
        'edit_lock' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
     
     public function getCreatedAtAttribute($value){
    $date = Carbon::parse($value);
    return $date->format('Y-m-d');
    }
    public function getUpdatedAtAttribute($value){
    $date = Carbon::parse($value);
    return $date->format('Y-m-d');
    }
    
    public static $rules = [
        'usergroup_name' => 'required|string|max:49',
        'usergroup_description' => 'nullable|string',
        'usergroup_privat' => 'nullable|string|max:3',
        'language_iso' => 'nullable|string|max:2',
        'country_iso' => 'nullable|string|max:2',
        'member_count' => 'required|integer',
        'edit_lock' => 'nullable|string|max:3',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    public static function getGroupMembers($group_id,$group_creator=false){
        $group_attend=UsergroupMembers::where('usergroup_id','=',$group_id)->where('user_id','>',0)->pluck('user_id');
        $send_list=User::whereIn('id',$group_attend)->get();
        if($group_creator){
            $author=User::where('id','=',$group_creator)->get();
            $send_list=$send_list->merge($author);
        }
        return $send_list;
    }
    public static function getGroupMembersMail($group_id,$group_creator=false){
        //$author=User::find($tour_creator);
        $group_attend=UsergroupMembers::where('usergroup_id','=',$group_id)->where('user_id','>',0)->with('user')->get();
        //$send_list=[$author->email];
        $send_list=[];
        foreach ($group_attend as $ta){
            $send_list[]=$ta->user->email;
        }
        return $send_list;
    }

    //Видят группу только создатели или включенные в таблицу attends(члены туры)
    public function scopeAttend(Builder $query,$value):Builder
    {
        if($value){
            $user_id=Auth::id();
            $query->where('group_creator','=',$user_id)->orWhereHas('attend', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            });
        }
        return $query;
    }

    public function scopeAllowedGroups(Builder $query,$value):Builder
    {
        if($value){
            $query->attend($value)->where('usergroup_privat','=',1)->orWhere('usergroup_privat','=',0);
        }
        return $query;
    }

    //проверяем доступ на возможность редактирования тура
    public function getCanEditAttribute(){
        $user=Auth::user();
        //Если юзер админ
        if($user->role_id==1)
            return true;
        //Если юзер создатель
        if($this->group_creator==$user->id){
            return true;
        }
        //Если юзер член и админ группы
        foreach ($this->attend as $attend){
            if($user->id==$attend->user_id && $attend->admin==1){
                return true;
            }
        }
        return false;
    }
    public static function checkEditAccess($tour_id){
        $tour=Usergroups::where('id','=',$tour_id)->first();
        if (!$tour->CanEdit) {
            Flash::error(__('Access denied'));
            return redirect(route('usergroups.index'))->send();
        }
    }

    public function attend()
    {
        return $this->hasMany(UsergroupMembers::class,'usergroup_id');
    }
    public static function isGroupMember($group_id,$user_id=false){
        $group=self::where('id','=',$group_id)->first();
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
        foreach ($group->attend as $attend){
            if($user->id==$attend->user_id){
                return true;
            }
        }
        return false;
    }
    public function getMembersCountAttribute(){
        return $this->attend()->count();
    }
}
