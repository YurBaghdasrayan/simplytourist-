<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

/**
 * Class UsergroupComments
 * @package App\Models
 * @version September 23, 2021, 12:55 pm UTC
 *
 * @property \App\Models\User $user
 * @property \App\Models\UsergroupTheme $theme
 * @property integer $user_id
 * @property string $comment
 * @property integer $theme_id
 */
class UsergroupComments extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'usergroup_comments';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    protected $appends=['HasAccess'];

    public $fillable = [
        'user_id',
        'comment',
        'theme_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'comment' => 'string',
        'theme_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'text' => 'required|string|min:2',
        'theme_id' => 'nullable|integer',
    ];
    //Переводы для сообщений валидации
    public static function getAttr(){
        return [
            'text' => __('Comment'),
        ];
    }

    public static function addComment($text,$theme_id){
        UsergroupComments::create([
           'user_id'=>Auth::id(),
           'comment'=>$text,
           'theme_id'=>$theme_id
        ]);
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function theme()
    {
        return $this->belongsTo(\App\Models\UsergroupThemes::class, 'theme_id');
    }

    public function getHasAccessAttribute(){
        $group=Usergroups::where('id','=',$this->theme->usergroup_id)->AllowedGroups(1)->first();
        if(isset($group->id))
            return true;
        else
            return false;
    }
    public static function checkThemeAccess($theme_id){
        $theme=UsergroupThemes::find($theme_id);
        if($theme){
            if(isset($theme->usergroup_id)){
                $group=Usergroups::where('id','=',$theme->usergroup_id)->first();
                return Usergroups::isGroupMember($group->id);
            }else{
                $tour=Tours::where('id','=',$theme->tour_id)->first();
                return Tours::isTourMember($tour->id);
            }

        }
        return false;
    }
}
