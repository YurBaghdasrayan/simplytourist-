<?php

namespace App\Http\Controllers;

use App\Models\Languages;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller
{
    //
    public function switchLang($lang)
    {
        if (in_array($lang, Config::get('app.locales'))) {
            Cookie::queue('locale', $lang, 999999999);
//            if (Auth::check()) {
//                $user=User::find(Auth::id());
//                $user->update(['user_locale'=>$lang]);
//            }
        }
        return Redirect::back();
    }

    public function indexApi(String $lang_name){
        return Languages::where('name_en','LIKE','%'.$lang_name.'%')->paginate(20)->toJson();
    }
    public function showApi(String $country_iso){
        return Languages::where('language_iso','=',$country_iso)->first()->toJson();
    }
}
