<?php

namespace App\Models;


use Carbon\Carbon;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class UsergroupThemes
 * @package App\Models
 * @version September 23, 2021, 12:49 pm UTC
 *
 * @property \App\Models\Usergroup $usergroup
 * @property \App\Models\User $user
 * @property integer $usergroup_id
 * @property string $theme
 * @property integer $user_id
 * @property integer $tour_id
 */
class UsergroupThemes extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'usergroup_themes';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'usergroup_id',
        'theme',
        'user_id',
        'tour_id',
        'file'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'usergroup_id' => 'integer',
        'theme' => 'string',
        'user_id' => 'integer',
        'tour_id' => 'integer',
        'file'=>'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'usergroup_id' => 'required|integer',
        'theme' => 'required|string|max:256',
        'user_id' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable',
        'tour_id' => 'nullable|integer'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function usergroup()
    {
        return $this->belongsTo(\App\Models\Usergroup::class, 'usergroup_id');
    }
    
    public function getCreatedAtAttribute($value){
    $date = Carbon::parse($value);
    return $date->format('H:i');
    }
    public function getUpdatedAtAttribute($value){
    $date = Carbon::parse($value);
    return $date->format('H:i');
    }
    
    public function tour()
    {
        return $this->belongsTo(\App\Models\Tours::class, 'tour_id');
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
}
