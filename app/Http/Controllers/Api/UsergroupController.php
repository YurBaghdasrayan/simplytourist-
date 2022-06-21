<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateUsergroupsRequest;
use App\Http\Requests\UpdateUsergroupsRequest;
use App\Mail\UsergroupCandidate;
use App\Mail\UsergroupNewTheme;
use App\Mail\UsergroupNewThemeComment;
use App\Models\Tours;
use App\Models\User;
use App\Models\UsergroupInvitations;
use App\Models\UsergroupMembers;
use App\Models\Usergroups;
use App\Repositories\UsergroupsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Database\Eloquent\SoftDeletes;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TCG\Voyager\Facades\Voyager;

class UsergroupController extends Controller
{

    private $usergroupsRepository;
    private static $slug = 'usergroups';

    public function __construct(UsergroupsRepository $usergroupsRepo)
    {
        $this->usergroupsRepository = $usergroupsRepo;
    }

    public function getSlug(Request $request)
    {
        return self::$slug;
    }

    public function index()
    {
        // Группы к которым есть доступ
        $query = QueryBuilder::for(Usergroups::class)
            ->allowedFilters([
                'usergroup_name',
                'usergroup_description',
                'country_iso',
            ]);
        $query = $query->AllowedGroups(1);
        $gorups = $query->where(['group_creator' => auth()->user()->id])->get();
        $my_member_groups = UsergroupMembers::leftJoin('usergroups', 'usergroup_members.usergroup_id', '=', 'usergroups.id')
            ->where('user_id', auth()->user()->id)->get();

        return response()->json([
            'my_gorups' => $gorups,
            'my_member_groups' => $my_member_groups,
        ]);
    }

    public function store(Request $request)
    {
        $member_count = 0;
        if (isset($request->usergroup_name)) {
            $req = $request->only(['usergroup_name', 'usergroup_description', 'country_iso', 'language_iso']);

            if ($request->selected_users)

                $member_count = count(explode(',', $request->selected_users));

            $req += [
                'member_count' => $member_count,
                'group_creator' => Auth::id(),
                'usergroup_privat' => ($request->usergroup_privat) ?: 0,
            ];
            if ($request->hasFile('image')) {
                $filePath = self::resizeImage($request, 'image', 'groups', 320);
                $req += ['image' => $filePath];
            }

            $group = Usergroups::create($req);
            if ($request->selected_users) {
                $usergroup_attendees_req = self::prepareUserInput($request, $group->id);
                UsergroupMembers::insert($usergroup_attendees_req);
            }
            Flash::success(__('Usergroup created successfully.'));
            return response()->json([
                "success" => true,
                "message" => "Usergroup created successfully",
            ]);
        } else {
            Flash::error(__('Error'));
            return response()->json("error");
        }
    }

    public static function prepareUserInput(Request $request, $usergroup_id)
    {
        //Добавляем пользователей
        $selectedUsers = explode(',', $request->selected_users);
        $selectedAdmins = explode(',', $request->tour_admins);
//        dd($selectedAdmins);
        $tour_attendees_req = [];
        $i = 0;

        $user = User::find($selectedUsers);
        foreach ($selectedUsers as $su) {
            if ($user) {
                $tour_attendees_req[$i]['usergroup_id'] = $usergroup_id;
                $tour_attendees_req[$i]['user_id'] = $su;
                if (in_array($su, $selectedAdmins)) {
                    $tour_attendees_req[$i]['admin'] = 1;
                } else {
                    $tour_attendees_req[$i]['admin'] = 0;
                }
                $i++;
            }
        }
        return $tour_attendees_req;
    }

    public function update(Request $request, $id)
    {
        $member_count = 0;
        Usergroups::checkEditAccess($id);
        $usergroup = Usergroups::find($id);
        $req = $request->only(['usergroup_name', 'usergroup_description', 'country_iso', 'language_iso', 'usergroup_privat']);
        if ($request->selected_users)
            $member_count = count(explode(',', $request->selected_users));
        $req += [
            'member_count' => $member_count,
        ];
        if ($request->hasFile('image')) {
            $filePath = self::resizeImage($request, 'image', 'groups', 320);
            $req += ['image' => $filePath];
        }
        $group = $usergroup->update($req);
        UsergroupMembers::where('usergroup_id', '=', $id)->delete();
        if ($request->selected_users) {
            $usergroup_attendees_req = self::prepareUserInput($request, $id);
            UsergroupMembers::insert($usergroup_attendees_req);
        }
//        Flash::success(__('Usergroup updated successfully.'));
//        return redirect('/usergroups/' . $id . '/edit/');
        return response()->json([
            "/usergroups/' . $id . '/edit/",
            'message' => 'Usergroup updated successfully'
        ]);
    }

    public static function sendEmailNotification($group_id, $type = 'status_change', $theme = false)
    {
//        Tours::checkEditAccess($tour_id);
        //$tour=Usergroups::find($group_id);
        $send_list = Usergroups::getGroupMembers($group_id);
        $objDemo = new \stdClass();
        $objDemo->group_link = env('APP_URL') . 'usergroup/' . $group_id;
        switch ($type) {
            case 'new_theme':
                $objDemo->theme = $theme;
                if ($send_list) {
                    foreach ($send_list as $user) {
                        $user_locale = ($user->user_locale) ?: 'en';
                        Mail::to($user->email)->locale($user_locale)->send(new UsergroupNewTheme($objDemo));
                    }
                }
                break;
            case 'new_comment_in_theme':
                $objDemo->theme = $theme;
                if ($send_list) {
                    foreach ($send_list as $user) {
                        $user_locale = ($user->user_locale) ?: 'en';
                        Mail::to($user->email)->locale($user_locale)->send(new UsergroupNewThemeComment($objDemo));
                    }
                }
                break;
            case 'new_candidate_to_group':
                $group = Usergroups::find($group_id);
                $group_admins = UsergroupMembers::getGroupAdmins($group);
                $objDemo->group_name = $group->usergroup_name;

                foreach ($group_admins as $admin) {
                    $user_locale = ($admin->user_locale) ?: 'en';
                    Mail::to($admin->email)->locale($user_locale)->send(new UsergroupCandidate($objDemo));
                }
                break;

        }
    }
}
