<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTourCandidatesRequest;
use App\Http\Requests\UpdateTourCandidatesRequest;
use App\Models\TourCandidates;
use App\Models\Tours;
use App\Models\User;
use App\Models\UsergroupCandidates;
use App\Models\Usergroups;
use App\Repositories\TourCandidatesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Response;

class UsergroupCandidatesController extends AppBaseController
{
    /** @var  TourCandidatesRepository */
    private $tourCandidatesRepository;

    public function __construct(TourCandidatesRepository $tourCandidatesRepo)
    {
        $this->tourCandidatesRepository = $tourCandidatesRepo;
    }

    /**
     * Display a listing of the TourCandidates.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->group_id) {
            $groupCandidates = UsergroupCandidates::where('group_id', '=', $request->group_id)->latest()->get();
            $group = Usergroups::where('id', '=', $request->group_id)->first();
            return view('usergroup_candidates.index', [
                'groupCandidates' => $groupCandidates,
                'group' => $group
            ]);
        } else {
            return response('access_error', '403');
        }
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
        $group = Usergroups::where('id', '=', $request->group_id)->first();
        //Проверяем, что пользователь уже состоит в группе
        if(!\App\Models\Usergroups::isGroupMember($group->id)){
            $req = [
                'group_id' => $request->group_id,
                'user_id' => Auth::id(),
                'status' => 'new',
                'comment' => $request->comment
            ];
            UsergroupsController::sendEmailNotification($group->id,'new_candidate_to_group');
            UsergroupCandidates::create($req);
        }
        return back();

    }

    public function setStatus($request_id, $status)
    {
        $tc = UsergroupCandidates::findOrFail($request_id);
        //Проверяем что пользователь действительно существует
        $user = User::findOrFail($tc->user_id);
        $group = Usergroups::findOrFail($tc->group_id);
        $isAlreadyGroupMember = Usergroups::isGroupMember($tc->group_id,$tc->user_id);
        if ($group->canEdit&&!$isAlreadyGroupMember) {
            switch ($status) {
                case 'allow':
                    $tc->update(['status' => 'allow']);
                    \App\Models\UsergroupMembers::create([
                        'usergroup_id' => $group->id,
                        'user_id' => $user->id,
                        'admin' => 0,
                    ]);
                    $group->update(['member_count' => $group->member_count + 1]);
                    break;
                case 'cancel':
                    $tc->update(['status' => 'cancel']);
                    break;
            }
        }
        return back();
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
}
