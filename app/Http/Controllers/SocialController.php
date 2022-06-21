<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Socialite;


class SocialController extends Controller
{
    //
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function Callback($provider)

    {
        $userSocial =   Socialite::driver($provider)->stateless()->user();
        $users       =   User::where(['email' => $userSocial->getEmail()])->first();
        if($users){
            Auth::login($users);
            return redirect('/home');
        }else{
            $user = User::create([
                //Никнейм
                'name'          => $userSocial->getEmail(),
                //Фио
                'about_surname'       => $userSocial->getName(),
                'email'         => $userSocial->getEmail(),
                'avatar'         =>($provider=='facebook')? $userSocial->getAvatar()."&access_token={$userSocial->token}":$userSocial->getAvatar(),
                'provider_id'   => $userSocial->getId(),
                'provider'      => $provider,
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
            Auth::login($user);
            return redirect('/home');
        }
    }
}
