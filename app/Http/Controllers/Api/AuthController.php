<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Response;
use TCG\Voyager\Facades\Voyager;
use Validator;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\RessetpasswordMail;


class AuthController extends AppBaseController
{
    public function getUserData($id)
    {
        $user_data = User::where('id', $id)->get();
        return response()->json([
            'success' => true,
            'message' => 'this is user data',
            'data' => $user_data
        ]);
    }

    public function store(Request $request)
    {

        $randomNumber = random_int(100000, 999999);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'policy' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $data = [
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password,
            "policy" => $request->policy,
            'verified_code' => $randomNumber
        ];

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            //Указываем текущую локаль пользователя
            'user_locale' => \App::getLocale(),
            //По-умолчанию делаем так что настройки приватности включены
            'settings_phone_visible_for_simplytourit_only' => 1,
            'settings_phone_visible_for_tour_admin_only' => 1,
            'settings_phone_visible_for_all_tour_members' => 1,
            'settings_phone_visible_for_group_admin_only' => 1,
            'settings_phone_visible_for_all_group_members' => 1,
            'settings_email_visible_for_simplytourit_only' => 1,
            'settings_email_visible_for_tour_admin_only' => 1,
            'settings_email_visible_for_all_tour_members' => 1,
            'settings_email_visible_for_group_admin_only' => 1,
            'settings_email_visible_for_all_group_members' => 1,
            'verified_code' => $randomNumber
        ]);
        if ($user) {
            $details = [
                'email' => $user->email,
                'verification_at' => $randomNumber,
            ];

            Mail::to($user->email)->send(new SendMail($details));

            $login_data = array(
                'email' => $request->email,
                'password' => $request->password,
            );

            if (Auth::attempt($login_data)) {
                $token = auth()->user()->createToken('API Token')->accessToken;

                return response(['user' => auth()->user(), 'token' => $token], 200);
            } else {
                return response(['error_message' => 'неверный логин или пароль']);
            }

        }
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'user successfuly registered'
            ], 200);
        } else {
            return response()->json([
                'success' => false
            ], 401);
        }
    }

    public function verifycodeapi(Request $request)
    {

        $user_code = $request->verified_code;

        $users = User::where('verified_code', '=', $user_code)->get();


        if (!$users->isEmpty()) {

            $user_id = $users[0]->id;

            $updating = User::where('id', '=', $user_id)->update(['verified_code' => 1]);
            return response()->json([
                'success' => true,
                'message' => 'your account successfully verified'
            ], 200);

            if (!$updating) {
                return response()->json([
                    'success' => false,
                    'message' => 'something was wrong'
                ], 200);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'something was wrong'
            ], 200);
        }
    }

    public function CodeRepeat(Request $request)
    {
        $randomNumber = random_int(100000, 999999);
        $user = Auth::user();

        if ($user) {
            $details = [
                'email' => $user->email,
                'verification_at' => $randomNumber,
            ];
            Mail::to($user->email)->send(new SendMail($details));
            $updating = User::where('id', '=', $user->id)->update(['verified_code' => $randomNumber]);
            if ($updating) {
                return response()->json([
                    'success' => true,
                    'message' => 'your verify code'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'something was wrong'
                ], 422);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'something was wrong'
            ], 200);
        }
    }

    public function storeLogin(Request $request)
    {

        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];


        $validator = Validator::make($request->all(), [

            'email' => 'required|string|email',
            'password' => 'required|string|min:8',

        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        if (Auth::attempt($data)) {
            $token = auth()->user()->createToken('API Token')->accessToken;

            return response([
                'user' => auth()->user(), 'token' => $token, 200,
                'message' => 'welcome your account'
            ], 200);
        } else {
            return response(['error_message' => 'Incorrect Details. Please try again']);
        }
    }

    public function send(Request $request)
    {
        $email = $request->email;
        $email_exist = User::where(['email' => $email, 'role_id' => '2'])->get();


        if (!$email_exist->isEmpty()) {

            $randomNumber = random_int(100000, 999999);
            $user_id = $email_exist[0]->id;

            $details = [
                'title' => 'Mail from BOWY.com',
                'code' => $randomNumber,
                'body' => 'This is for forggot password'
            ];

            Mail::to($email)->send(new RessetpasswordMail($details));

            $code = RessetPassword::create([
                "user_id" => $user_id,
                "random_int" => $randomNumber,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'code os sended to your email'
            ], 200);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'Email не существует !'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::find(Auth::id());
        $req = $request->except(['provider', 'provider_id', 'simplytourit_certification_note', 'role_id', 'email_verified_at',
            'remember_token', 'email', 'avatar', 'certification_mountain_guide_approved', 'certification_hiking_guide_approved',
            'settings_email_visible_for_simplytourit_only', 'settings_phone_visible_for_simplytourit_only']);
        if ($request->hasFile('avatar')) {
            $filePath = self::resizeImage($request, 'avatar', 'users', 320);
            $req += ['avatar' => $filePath];
        }
        if (isset($request->country_iso)) {
            if (in_array($request->country_iso, Config::get('app.locales'))) {
                Cookie::queue('locale', $request->country_iso, 999999999);
                $req += ['user_locale' => $request->country_iso];
            }
        }
        //Если у нас новый ник - его нужно валидировать

        if ($user->name !== $request->name) {
            $validator = Validator::make($req, User::$rules);
            $validator->setAttributeNames(User::getAttr());
            if ($validator->fails()) {
                return response()->json([($validator->errors())]);
            }
        }
        if (empty($user)) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ]);
        }
        $user->update($req);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.'
        ], 200);
    }
}