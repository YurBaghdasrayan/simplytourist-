<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUsergroupInvitationsRequest;
use App\Http\Requests\UpdateUsergroupInvitationsRequest;
use App\Models\User;
use App\Models\UsergroupInvitations;
use App\Models\UsergroupMembers;
use App\Models\Usergroups;
use App\Repositories\UsergroupInvitationsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Response;
use Validator;

class UsergroupInvitationsController extends AppBaseController
{
    /** @var  UsergroupInvitationsRepository */
    private $usergroupInvitationsRepository;
    private static $slug = 'usergroup-invitations';

    public function __construct(UsergroupInvitationsRepository $usergroupInvitationsRepo)
    {
        $this->usergroupInvitationsRepository = $usergroupInvitationsRepo;
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
        // GET THE SLUG, ex. 'posts', 'pages', etc.
        $user=Auth::user();
        $group_ids=UsergroupInvitations::where('status','=','new')
            ->where('user_id','=',null)
            ->where('user_email','=',$user->email)
            ->pluck('usergroup_id');
        $usergroups=Usergroups::whereIn('id',$group_ids)->paginate(15);
        $browserable_rows = self::getFields('usergroups', $this);

        return view('usergroup_invitations.index')
            ->with([
                'usergroups'=>$usergroups,
                'rows'=>$browserable_rows
            ]);
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
        $req=[];
        $validator = Validator::make($request->all(),UsergroupInvitations::$rules);
//        $validator->setAttributeNames(UsergroupInvitations::getAttr());
        if($validator->fails()){
            Flash::error($validator->errors());
            return Redirect::back()->withErrors($validator->errors())->withInput();
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
        return redirect('/usergroup/'.$request->usergroup_id);
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
     */
//    public function update($id, UpdateToursRequest $request)
//    {
//        $tours = $this->toursRepository->find($id);
//
//        if (empty($tours)) {
//            Flash::error('Tours not found');
//
//            return redirect(route('tours.index'));
//        }
//
//        $tours = $this->toursRepository->update($request->all(), $id);
//
//        Flash::success('Tours updated successfully.');
//
//        return redirect(route('tours.index'));
//    }
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
            return back();
        }else{
            return abort(403);
        }
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
}
