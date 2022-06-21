<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UsergroupInvitations;
use App\Models\UsergroupMembers;
use App\Models\Usergroups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Facades\Voyager;
use Validator;

class ApiUsergroupInvitationsController extends Controller
{
    public static function getFields($slug, $context)
    {
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        // Check permission
        //$context->authorize('browse', app($dataType->model_name));
        $browserable_rows = [];
        foreach ($dataType->addRows as $field) {
            if ($field->browse) {
                $browserable_rows[] = [
                    'field' => $field->field,
                    'type' => $field->type,
                    'display_name' => $field->display_name
                ];
            }
        }
        return $browserable_rows;
    }

    public function index(Request $request)
    {
        // GET THE SLUG, ex. 'posts', 'pages', etc.
        $user = Auth::user();
        $group_ids = UsergroupInvitations::where('status', '=', 'new')
            ->where('user_id', '=', null)
            ->where('user_email', '=', $user->email)
            ->pluck('usergroup_id');
        $usergroups = Usergroups::whereIn('id', $group_ids)->paginate(15);

        $browserable_rows = self::getFields('usergroups', $this);

        return response()->json([
            'usergroups' => $usergroups,
            'rows' => $browserable_rows
        ]);
    }

    public function store(Request $request)
    {
        $req = [];
        $validator = Validator::make($request->all(), UsergroupInvitations::$rules);
//        $validator->setAttributeNames(UsergroupInvitations::getAttr());
        if ($validator->fails()) {
//            Flash::error($validator->errors());
            return response()->json($validator->errors());
        }
        $author = Auth::user();
        //Если поставлена галочка отправлять прикрепленным к туру, извлекаем их id
        if ($request->send_attendees == 'on') {
            $user_ids = UsergroupMembers::where('usergroup_id', '=', $request->usergroup_id)->pluck('user_id');

            $users = User::whereIn('id', $user_ids)->where('id', '<>', $author->id)->get();

            foreach ($users as $user) {
                array_push($req, [
                    'usergroup_id' => $request->usergroup_id,
                    'user_email' => $user->email,
                    'user_id' => $user->id,
                    'author_id' => $author->id,
                    'status' => 'new'
                ]);
            }
        }

        $emails = [];
        //Если выбраны только email - пишем их
        switch ($request->type) {
            case 'email':
                $emails = $request->emails;
                break;
            case 'nickname':
                foreach ($request->emails as $userNick) {
                    $user = User::where('name', '=', $userNick)->first();
                    if (isset($user->email)) {
                        array_push($emails, $user->email);
                    }
                }
                break;
        }
//        dd($emails);

        if (count([$emails]) > 0) {
            foreach ([$emails] as $email) {
                array_push($req, [
                    'usergroup_id' => $request->usergroup_id,
                    'user_email' => $email,
                    'author_id' => $author->id,
                    'user_id' => null,
                    'status' => 'new'
                ]);
            }
        }

        UsergroupInvitations::insert($req);
        if ($req) {
            dump(10);
        }
        return response()->json(['/usergroup/' . $request->usergroup_id]);
    }

    public function setStatus($request_id, $status)
    {
        $user=Auth::user();

        $gi = UsergroupInvitations::where('usergroup_id','=',$request_id)->where('user_email','=',$user->email)->first();
        if($gi){
            $group = Usergroups::findOrFail($gi->usergroup_id);

            switch ($status) {
                case 'allow':
                    UsergroupInvitations::where('usergroup_id','=',$group->id)->where('user_email','=',$user->email)->update(['status' => 'allow']);
                    \App\Models\UsergroupMembers::create([
                        'usergroup_id'=>$group->id,
                        'user_id'=>$user->id,
                        'admin'=>0,
                    ]);

                    //Берем значение из атрибута
                    $group->update(['member_count' => $group->MembersCount]);
                    break;
                case 'cancel':
                    UsergroupInvitations::where('usergroup_id','=',$group->id)->where('user_email','=',$user->email)->update(['status' => 'cancel']);
                    break;
            }
            return response()->json('ok');
        }else{
            return abort(403);
        }
    }
}
