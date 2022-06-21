<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;
use TCG\Voyager\Traits\Spatial;
use TCG\Voyager\Models\User as VoyagerUser;

class User extends VoyagerUser implements MustVerifyEmail
{
    
    use HasApiTokens, HasFactory, Notifiable, Spatial;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
//    protected $fillable = [
//        'name',
//        'email',
//        'password',
//        'avatar',
//        'provider',
//        'provider_id',
//    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'min:3|max:255|unique:users',
        'avatar' => 'max:10000'
    ];
    //Переводы для сообщений валидации

    public function reciver()
    {
        return $this->hasMany(Chat::class,'reciver_id');
    }

    public function sender()
    {
        return $this->hasMany(Chat::class,'sender_id');
    }

    public static function getAttr(){
        return [
            'name' => __('Nickname'),
            'avatar' => __('My photo'),
        ];
    }
    public function getCreatedAtAttribute($value){
    $date = Carbon::parse($value);
    return $date->format('Y-m-d');
    }
    public function getUpdatedAtAttribute($value){
    $date = Carbon::parse($value);
    return $date->format('Y-m-d');
    }
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function makeInactiveInput($input_name,$rows){
        $i=0;
        foreach ($rows as $row){
            if($row['field']===$input_name){
                $rows[$i]['disabled']=true;
            }
            $i++;
        }
        return $rows;
    }
    // this is a recommended way to declare event handlers

    /**
     *В данном методе до удаления пользователя мы удаляем из участников тура и юзергрупп
     * При этом мы обновляем счетчики open_places(кол-во) свободных мест в туре, members_count - количество членов группы
     */
    public static function boot() {
        parent::boot();

        static::deleting(function($user) { // before delete() method call this
            //Получаем список туров(id), в которых участвует юзер
            $tour_ids=TourAttendees::where('user_id','=',$user->id)->pluck('tour_id');
            $tours=Tours::find($tour_ids);
            if($tours){
                foreach ($tours as $tour){
                    TourAttendees::deleteAttend($tour,$user->id);
                }
            }
            //Получаем список групп(id), в которых состоит юзер
            $group_ids=UsergroupMembers::where('user_id','=',$user->id)->pluck('usergroup_id');
            $groups=Usergroups::find($group_ids);
            if($groups){
                foreach ($groups as $group){
                    UsergroupMembers::deleteMembers($group,$user->id);
                }
            }
        });
    }

    /**
     *Позволяют ли текущие настройки приватности пользователя контактировать с ним
     */
    public static function checkPrivacyCanContact(){
        $user=Auth::user();
        $canContact=false;
        $important_fields=['settings_email_visible_for_all_tour_members','settings_email_visible_for_tour_admin_only',
            'settings_phone_visible_for_all_tour_members','settings_phone_visible_for_tour_admin_only',
            'settings_email_visible_for_all_group_members','settings_email_visible_for_group_admin_only',
            'settings_phone_visible_for_all_group_members','settings_phone_visible_for_group_admin_only'];
        //Если хотя-бы одна настройка включена-с ним хоть как-то можно связаться
        foreach ($important_fields as $field){
            if($user[$field]=='on'||$user[$field]==1){
                $canContact=true;
            }
        }
        return $canContact;
    }
}
