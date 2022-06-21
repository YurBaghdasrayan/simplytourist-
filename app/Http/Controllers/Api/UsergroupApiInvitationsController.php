<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateUsergroupInvitationsRequest;
use App\Http\Requests\UpdateUsergroupInvitationsRequest;
use App\Models\User;
use App\Models\UsergroupInvitations;
use App\Models\UsergroupMembers;
use App\Models\Usergroups;
use App\Repositories\UsergroupInvitationsRepository;
use App\Http\Controllers\AppBaseController;
use Flash;
use Illuminate\Support\Facades\Auth;
use Response;
use Validator;


class UsergroupApiInvitationsController extends Controller
{

    public function store(Request $request)
    {
        $req=[];
        $validator = Validator::make($request->all(),UsergroupInvitations::$rules);
//        $validator->setAttributeNames(UsergroupInvitations::getAttr());
        if($validator->fails()){
//            Flash::error($validator->errors());
            return response()->json($validator->errors());
        }
        $author=Auth::user();
        //Если поставлена галочка отправлять прикрепленным к туру, извлекаем их id
        if($request->send_attendees=='on') {
            $user_ids=UsergroupMembers::where('usergroup_id', '=',$request->usergroup_id)->pluck('user_id');
            $users=User::whereIn('id',$user_ids)->where('id','<>',$author->id)->get();
            foreach($users as $user){
                array_push($req,[
                    'usergroup_id'=>$request->usergroup_id,
                    'user_email'=>$user->email,
                    'user_id'=>$user->id,
                    'author_id'=>$author->id,
                    'status'=>'new'
                ]);
            }
        }
        $emails=[];
        //Если выбраны только email - пишем их
        switch ($request->type){
            case 'email':
                $emails=$request->emails;
                break;
            case 'nickname':
                foreach ($request->emails as $userNick){
                    $user=User::where('name','=',$userNick)->first();
                    if(isset($user->email)){
                        array_push($emails, $user->email);
                    }
                }
                break;
        }
        if(count($emails)>0){
            foreach($emails as $email){
                array_push($req,[
                    'usergroup_id'=>$request->usergroup_id,
                    'user_email'=>$email,
                    'author_id'=>$author->id,
                    'user_id'=>null,
                    'status'=>'new'
                ]);
            }
        }
        UsergroupInvitations::insert($req);
        return response()->json([
            'data'=>$request->usergroup_id
        ]);
    }
}
