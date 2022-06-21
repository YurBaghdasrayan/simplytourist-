<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

/**
 * Class UsergroupMembers
 * @package App\Models
 * @version September 23, 2021, 12:49 pm UTC
 *
 * @property \App\Models\User $user
 * @property \App\Models\Usergroup $usergroup
 * @property integer $user_id
 * @property integer $usergroup_id
 * @property string $admin
 */
class UsergroupMembers extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'usergroup_members';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'usergroup_id',
        'admin'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'usergroup_id' => 'integer',
        'admin' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'nullable',
        'usergroup_id' => 'required|integer',
        'admin' => 'nullable|string|max:3',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id')->withDefault([
            'name' => 'Deleted User',
            'email'=>null
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function usergroup()
    {
        return $this->belongsTo(\App\Models\Usergroup::class, 'usergroup_id');
    }

    public static function updateMembers(Usergroups $group,$user_id){
        self::create([
            'usergroup_id'=>$group->id,
            'user_id'=>$user_id,
            'admin'=>0,
        ]);
        //Обновляем количество через атрибут
        $group->update(['member_count'=>$group->MembersCount]);
    }
    public static function deleteMembers(Usergroups $group,$user_id){
        self::where('usergroup_id','=',$group->id)
            ->where('user_id','=',$user_id)
            ->delete();
        //Обновляем количество через атрибут
        $group->update(['member_count'=>$group->MembersCount]);
    }

    public static function getGroupAdmins(Usergroups $group){
        $group_admins=self::where('usergroup_id','=',$group->id)->where('admin','=',1)->pluck('user_id')->toArray();
        array_push($group_admins,$group->group_creator);
        return User::whereIn('id',$group_admins)->get();
    }
    public static function isGroupAdmin($group_id,$user_id){
        $group_admins=self::where('usergroup_id','=',$group_id)->where('admin','=',1)->pluck('user_id')->toArray();
        $usergroup=Usergroups::find($group_id);
        array_push($group_admins,$usergroup->group_creator);
        return in_array($user_id,$group_admins);
    }
}
