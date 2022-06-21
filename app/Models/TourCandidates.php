<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class TourCandidates
 * @package App\Models
 * @version November 30, 2021, 3:40 pm UTC
 *
 * @property integer $user_id
 * @property integer $tour_id
 * @property string $status
 */
class TourCandidates extends Model
{

    use HasFactory;

    public $table = 'tour_candidates';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'tour_id',
        'status',
        'comment'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'tour_id' => 'integer',
        'status' => 'string',
        'comment' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required|integer',
        'tour_id' => 'required|integer',
        'status' => 'nullable|string',
        'comment'=>'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    public function tour()
    {
        return $this->belongsTo(\App\Models\Tours::class, 'tour_id');
    }
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id')->withDefault([
            'name' => 'Deleted User',
            'email'=>null
        ]);
    }
}
