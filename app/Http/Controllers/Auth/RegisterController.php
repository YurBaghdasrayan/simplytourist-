<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tours;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'policy' => ['required']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user=User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            //Указываем текущую локаль пользователя
            'user_locale' => \App::getLocale(),
            //По-умолчанию делаем так что настройки приватности включены
            'settings_phone_visible_for_simplytourit_only'=>1,
            'settings_phone_visible_for_tour_admin_only'=>1,
            'settings_phone_visible_for_all_tour_members'=>1,
            'settings_phone_visible_for_group_admin_only'=>1,
            'settings_phone_visible_for_all_group_members'=>1,
            'settings_email_visible_for_simplytourit_only'=>1,
            'settings_email_visible_for_tour_admin_only'=>1,
            'settings_email_visible_for_all_tour_members'=>1,
            'settings_email_visible_for_group_admin_only'=>1,
            'settings_email_visible_for_all_group_members'=>1,

        ]);
        //После создания пользователя присоединяем его в приглашения туров и групп к attends и  members
        //NEW - больше не присоединяем
        /*if($user){
            $tours=\App\Models\TourInvitations::where('user_email','=',$data['email'])->pluck('tour_id');
            if(count($tours)>0){
                foreach ($tours as $tour){
                    //[user_id,tour_id,tour_admin]
                    \App\Models\TourAttendees::create([
                        'tour_id'=>$tour,
                        'user_id'=>$user->id,
                        'tour_admin'=>0,
                    ]);
                    Tours::where('tour_id','=',$tour->id)->update(['open_places'=>$tour->open_places-1]);
                }
            }
            $groups=\App\Models\UsergroupInvitations::where('user_email','=',$data['email'])->pluck('usergroup_id');
            if(count($groups)>0){
                foreach ($groups as $group){
                    //[user_id,usergroup_id,admin]
                    \App\Models\UsergroupMembers::create([
                        'usergroup_id'=>$group,
                        'user_id'=>$user->id,
                        'admin'=>0,
                    ]);
                }
            }
        }*/

        return $user;
    }
}
