<?php

namespace App\Models;

use App\Mail\TourInvitation;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Mail;

/**
 * Class TourInvitations
 * @package App\Models
 * @version September 24, 2021, 11:22 am UTC
 *
 * @property integer $tour_id
 * @property integer $user_id
 */
class TourInvitations extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'tour_invitations';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'tour_id',
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
        'tour_id' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'tour_id' => 'required|integer',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];
    //Переводы для сообщений валидации
//    public static function getAttr()
//    {
//        $messages=[];
//        foreach (request('emails') as $key => $val) {
//            $messages["emails.$key"] = __('Email');
//        }
//        return $messages;
//    }
    public function scopeUnsend($query){
        return $query->whereNull('send_status');
    }
    public static function sendInvitations(){
        $tour_invs=self::unsend()->get();
        foreach ($tour_invs as $ti){
            $objDemo = new \stdClass();
            $objDemo->tour_link = env('APP_URL').'tours/'.$ti->tour_id;
            $objDemo->tour_name = $ti->tour->tour_name;
            $objDemo->email=$ti->user_email;
            var_dump($objDemo);
            Mail::to($ti->user_email)->locale('en')->send(new TourInvitation($objDemo));
            $ti->update(['send_status'=>1]);

        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
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
