<?php

namespace App\Models;

use App\Mail\UsergroupInvitation;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Mail;

/**
 * Class UsergroupInvitations
 * @package App\Models
 * @version September 23, 2021, 12:50 pm UTC
 *
 * @property \App\Models\Usergroup $usergroup
 * @property \App\Models\User $user
 * @property integer $usergroup_id
 * @property integer $user_id
 */
class UsergroupInvitations extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'usergroup_invitations';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'usergroup_id',
        'user_id',
        'send_status',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'usergroup_id' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'usergroup_id' => 'required|integer',
//        'emails.*' => 'nullable|email',
//        'email_default' => 'nullable|email',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];
//    //Переводы для сообщений валидации
//    public static function getAttr()
//    {
//        $messages=[];
//        foreach (request('emails') as $key => $val) {
//            $messages["emails.$key"] = __('Email');
//        }
//        return $messages;
//    }
    public static function sendInvitations(){
        $group_invs=self::unsend()->get();
        foreach ($group_invs as $gi){
            $objDemo = new \stdClass();
            $objDemo->group_link = env('APP_URL').'usergroup/'.$gi->usergroup->id;
            $objDemo->group_name = $gi->usergroup->usergroup_name;
            $objDemo->email=$gi->user_email;
            var_dump($objDemo);
            Mail::to($gi->user_email)->locale('en')->send(new UsergroupInvitation($objDemo));
            $gi->update(['send_status'=>1]);
        }
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function usergroup()
    {
        return $this->belongsTo(\App\Models\Usergroups::class, 'usergroup_id');
    }

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

    public function scopeUnsend($query){
        return $query->whereNull('send_status');
    }
}
