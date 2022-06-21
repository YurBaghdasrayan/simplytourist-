<?php

namespace App\Http\Controllers;

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
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TCG\Voyager\Facades\Voyager;

class UsergroupsController extends AppBaseController
{
    /** @var  UsergroupsRepository */
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

    /**
     * Display a listing of the Tours.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // Группы к которым есть доступ
        $query = QueryBuilder::for(Usergroups::class)
            ->allowedFilters([
                'usergroup_name',
                'usergroup_description',
                'country_iso',
            ]);
        $query = $query->AllowedGroups(1);

        $dataTypeContent = self::getData(self::$slug, $request, $query);
        $browserable_rows = self::getFields(self::$slug, $this);

        return view('usergroups.index')
            ->with(['usergroups' => $dataTypeContent, 'rows' => $browserable_rows]);
    }

    public function publicIndex(Request $request)
    {
        // GET THE SLUG, ex. 'posts', 'pages', etc.
        $query = Usergroups::select('*')->where('usergroup_privat', '!=', 1);
        $dataTypeContent = self::getData(self::$slug, $request, $query);
        $browserable_rows = self::getFields(self::$slug, $this);
        $title=__('Usergroups');

        return view('public.usergroups.index')
            ->with(['title'=>$title,'usergroups' => $dataTypeContent, 'rows' => $browserable_rows]);
    }

    /**
     * Show the form for creating a new Tours.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        $dataTypeContent = (strlen($dataType->model_name) != 0)
            ? new $dataType->model_name()
            : false;

        foreach ($dataType->addRows as $key => $row) {
            $dataType->addRows[$key]['col_width'] = $row->details->width ?? 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'add');

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        // Eagerload Relations
        $this->eagerLoadRelations($dataTypeContent, $dataType, 'add', $isModelTranslatable);


//        $dataTypeContent = self::getData(self::$slug, $request, $query);
        $browserable_rows = self::getFields(self::$slug, $this);
        $dataType = Voyager::model('DataType')->where('slug', '=', self::$slug)->first();
        return view('usergroups.create')
            ->with(['data' => $dataTypeContent, 'dataTypeContent' => $dataTypeContent, 'rows' => $browserable_rows]);
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
                $filePath=self::resizeImage($request,'image','groups',320);
                $req += ['image' => $filePath];
            }
            $group = Usergroups::create($req);
            if ($request->selected_users) {
                $usergroup_attendees_req = self::prepareUserInput($request, $group->id);
                UsergroupMembers::insert($usergroup_attendees_req);
            }
            Flash::success(__('Usergroup created successfully.'));
            return redirect()->route("usergroups.index");
        } else {
            Flash::error(__('Error'));
            return back();
        }
    }

    public static function prepareUserInput(Request $request, $usergroup_id)
    {
        //Добавляем пользователей
        $selectedUsers = explode(',', $request->selected_users);
        $selectedAdmins = explode(',', $request->tour_admins);
        $tour_attendees_req = [];
        $i = 0;
        foreach ($selectedUsers as $su) {
            $user = User::find($su);
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
    public function edit(Request $request, $id)
    {
        $slug = $this->getSlug($request);
        Usergroups::checkEditAccess($id);
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);
            $query = $model->query()->allowedGroups(1);

            // Use withTrashed() if model uses SoftDeletes and if toggle is selected
            if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
                $query = $query->withTrashed();
            }
            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
                $query = $query->{$dataType->scope}();
            }
            $dataTypeContent = call_user_func([$query, 'findOrFail'], $id);
        } else {
            // If Model doest exist, get data from table name
            $dataTypeContent = DB::table($dataType->name)->where('id', $id)->get();
        }

        foreach ($dataType->editRows as $key => $row) {
            $dataType->editRows[$key]['col_width'] = isset($row->details->width) ? $row->details->width : 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'edit');

        // Check permission
        $this->authorize('edit', $dataTypeContent);

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        // Eagerload Relations
        $this->eagerLoadRelations($dataTypeContent, $dataType, 'edit', $isModelTranslatable);
        $browserable_rows = self::getFields(self::$slug, $this);
        $groupMembers = UsergroupMembers::where('usergroup_id', '=', $id)->where('user_id', '>', 0)->get()->toJson();
        return view('usergroups.edit')
            ->with(['usergroups' => $dataTypeContent->toArray(), 'groupMembers' => $groupMembers, 'dataType' => $dataType, 'data' => [$dataTypeContent->toArray()], 'dataTypeContent' => $dataTypeContent, 'rows' => $browserable_rows]);
    }

    /**
     * Update the specified Tours in storage.
     *
     * @param int $id
     * @param UpdateToursRequest $request
     *
     * @return Response
     */
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
            $filePath=self::resizeImage($request,'image','groups',320);
            $req += ['image' => $filePath];
        }
        $group = $usergroup->update($req);
        UsergroupMembers::where('usergroup_id', '=', $id)->delete();
        if ($request->selected_users) {
            $usergroup_attendees_req = self::prepareUserInput($request, $id);
            UsergroupMembers::insert($usergroup_attendees_req);
        }
        Flash::success(__('Usergroup updated successfully.'));
        return redirect('/usergroups/' . $id . '/edit/');
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
    public function destroy(Request $request, $id)
    {
        return false;
    }

    public function invitations($usergroup_id)
    {
//        Tours::checkEditAccess($tour_id);
        $group = Usergroups::find($usergroup_id);
        $invitationsList=UsergroupInvitations::where('usergroup_id','=',$usergroup_id)->get();

        //Если статус поменяли-шлем уведомление всем участникам тура
        return view('usergroups.invite', compact('usergroup_id', 'group','invitationsList'));
    }

    public static function sendEmailNotification($group_id, $type = 'status_change', $theme = false)
    {
//        Tours::checkEditAccess($tour_id);
        //$tour=Usergroups::find($group_id);
        $send_list = Usergroups::getGroupMembers($group_id);
       
        $objDemo = new \stdClass();
        $objDemo->group_link = env('APP_URL').'usergroup/'.$group_id;
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
