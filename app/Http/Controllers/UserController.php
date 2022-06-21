<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateToursRequest;
use App\Http\Requests\UpdateToursRequest;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\TourAttendees;
use App\Models\Tours;
use App\Models\User;
use App\Models\UserEquipment;
use App\Models\UsergroupMembers;
use App\Models\Usergroups;
use App\Repositories\ToursRepository;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Response;
use TCG\Voyager\Facades\Voyager;
use Validator;


class UserController extends AppBaseController
{
    private static $slug = 'users';
    private static $route_prefix = 'profile';
    public function getSlug(Request $request)
    {
        return self::$slug;
    }

    /**
     * Display a listing of the Tours.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $view='index';
        $views=['equipment','certification','privacy'];
        if(in_array($request->slug,$views))
            $view=$request->slug;
        // GET THE SLUG, ex. 'posts', 'pages', etc.
        $query = User::where('id', '=', Auth::id());
        $dataTypeContent = self::getData(self::$slug, $request, $query);
        $browserable_rows = self::getFields(self::$slug, $this);
        $userEquipments = UserEquipment::select('equipment_type_id')
            ->where('user_id','=',Auth::id())
            ->groupBy('equipment_type_id')
            ->get()->pluck('equipment_type_id');
        $equipmentsType=EquipmentType::whereIn('id',$userEquipments)->orderBy('name_'.\App::getLocale())->get();
        $browserable_rows=User::makeInactiveInput('certification_mountain_guide_approved',$browserable_rows);
        $browserable_rows=User::makeInactiveInput('certification_hiking_guide_approved',$browserable_rows);
        $browserable_rows=User::makeInactiveInput('settings_email_visible_for_simplytourit_only',$browserable_rows);
        $browserable_rows=User::makeInactiveInput('settings_phone_visible_for_simplytourit_only',$browserable_rows);
        $isUserContactable=User::checkPrivacyCanContact();
        return view(self::$route_prefix.'.'.$view)
            ->with(['data' => $dataTypeContent, 'rows' => $browserable_rows, 'equipmentsType'=>$equipmentsType,'isUserContactable'=>$isUserContactable]);
    }

    /**
     * Show the form for creating a new Tours.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        return false;
    }

    /**
     * Store a newly created Tours in storage.
     *
     * @param CreateToursRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        return false;
    }


    /**
     * @param Request $request
     * @param $id
     * @return bool
     */
    public function show(Request $request, $id)
    {
        return false;
    }

    /**
     * Show the form for editing the specified Tours.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit(Request $request,$id)
    {
        return false;
    }

    /**
     * Update the specified Tours in storage.
     *
     * @param int $id
     * @param UpdateToursRequest $request
     *
     * @return Response
     *
     */
    public function update(Request $request, $id)
    {
        $user = User::find(Auth::id());
        $req=$request->except(['provider','provider_id','simplytourit_certification_note','role_id','email_verified_at',
            'remember_token','email','avatar','certification_mountain_guide_approved','certification_hiking_guide_approved',
            'settings_email_visible_for_simplytourit_only','settings_phone_visible_for_simplytourit_only']);

        if($request->hasFile('avatar')){
            $filePath=self::resizeImage($request,'avatar','users',320);
            $req+=['avatar'=>$filePath];
        }
        if(isset($request->country_iso)){
            if (in_array($request->country_iso, Config::get('app.locales'))) {
                Cookie::queue('locale', $request->country_iso, 999999999);
                $req+=['user_locale'=>$request->country_iso];
            }
        }
        //Если у нас новый ник - его нужно валидировать
        if($user->name!==$request->name){
            $validator = Validator::make($req,User::$rules);
            $validator->setAttributeNames(User::getAttr());
            if($validator->fails()){
                Flash::error($validator->errors());
                return Redirect::to('/profile')->withErrors($validator->errors());
            }
        }
        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route(self::$route_prefix.'.index'));
        }
        $user->update($req);

        Flash::success(__('Profile updated successfully.'));

        return back();
    }

    /**
     * Remove the specified Tours from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy(Request $request,$id)
    {
        return false;
    }

    public function find(Request $request){
        if($request->search!=''&&strlen($request->search)>1){
            return User::select(['id','name','about_address_country'])
                ->where('name','like','%'.$request->search.'%')
                ->orWhere('email','=',$request->search)
                ->take(50)->get()->toJson();
        }
        if($request->ids!=''){
            $ids_arr=explode(',',$request->ids);
            return User::select(['id','name','about_address_country'])->whereIn('id',$ids_arr)->take(50)->get()->toJson();
        }
        return null;
    }
    public function findOne(Request $request){
        if($request->search!=''&&strlen($request->search)>0){
            return User::select(['id','name','about_address_country'])
                ->where('name','=',$request->search)
                ->first();
        }
        return null;
    }

    /**
     * Получаем контакты пользователя в зависимости от настроек приватности и уровня доступа в туре/группе
     * settings_phone_visible_for_tour_admin_only - админ тура видит телефон
     * settings_email_visible_for_tour_admin_only - админ тура видит емэйл
     * settings_phone_visible_for_all_tour_members - члены тура видят телефон
     * settings_email_visible_for_all_tour_members - члены тура видят email
     * settings_phone_visible_for_group_admin_only - админ группы видит телефон
     * settings_email_visible_for_group_admin_only - админ группы видит емэйл
     * settings_phone_visible_for_all_group_members - члены группы видят телефон
     * settings_email_visible_for_all_group_members - члены группы видят емэйл
     * Если пользователь админ тура или группы - все видят его контакты
     * @param $user_id
     * @param Request $request
     * @return string|null
     * `
     */
    public function getContacts($user_id, Request $request){
        if(is_numeric($user_id)){
            $user=User::find($user_id);
            $viewer=Auth::user();
            $show_phone=false;
            $show_email=false;
            if(isset($request->group_id)){
                $is_user_admin=UsergroupMembers::isGroupAdmin($request->group_id,$user->id);
                $is_viewer_admin=UsergroupMembers::isGroupAdmin($request->group_id,$viewer->id);
                $is_viewer_member=Usergroups::isGroupMember($request->group_id);
                //Если пользователь админ группы-выводим все
                if($is_user_admin){
                    $show_phone=true;
                    $show_email=true;
                }
                //Доступ если кто смотрит - администратор группы
                if($is_viewer_admin){
                    if($user->settings_phone_visible_for_group_admin_only){
                        $show_phone=true;
                    }
                    if($user->settings_email_visible_for_group_admin_only){
                        $show_email=true;
                    }
                }
                if($is_viewer_member){
                    if($user->settings_phone_visible_for_all_group_members){
                        $show_phone=true;
                    }
                    if($user->settings_email_visible_for_all_group_members){
                        $show_email=true;
                    }
                }
            }
            if(isset($request->tour_id)){
                $is_user_admin=TourAttendees::isTourAdmin($request->tour_id,$user->id);
                $is_viewer_admin=TourAttendees::isTourAdmin($request->tour_id,$viewer->id);
                $is_viewer_member=Tours::isTourMember($request->tour_id);
                //Если пользователь админ группы-выводим все
                if($is_user_admin){
                    $show_phone=true;
                    $show_email=true;
                }
                //Доступ если кто смотрит - администратор тура
                if($is_viewer_admin){
                    if($user->settings_phone_visible_for_group_admin_only){
                        $show_phone=true;
                    }
                    if($user->settings_email_visible_for_group_admin_only){
                        $show_email=true;
                    }
                }
                if($is_viewer_member){
                    if($user->settings_phone_visible_for_all_group_members){
                        $show_phone=true;
                    }
                    if($user->settings_email_visible_for_all_group_members){
                        $show_email=true;
                    }
                }
            }
            $phone=($user->about_phone!='')?$user->about_phone:__('Not specified');
            $phone=($show_phone)?$phone:'************';
            $email=($show_email)?$user->email:'************';
            $result=[__('Phone')=>$phone];
            $result+=[__('Email')=>$email];
            return json_encode($result);
        }
        return null;
    }
}
