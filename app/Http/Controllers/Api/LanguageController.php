<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function switchLang(Request $request){

        $lang =  $request->lang;
        App::setLocale($lang);

        $data = [
            'message' => trans('messages.greeting'),
        ];
        return response()->json($data, 200);

    }

}
