<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTourCandidatesRequest;
use App\Http\Requests\UpdateTourCandidatesRequest;
use App\Models\TourAttendees;
use App\Models\TourCandidates;
use App\Models\Tours;
use App\Models\User;
use App\Repositories\TourCandidatesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Response;

class TourCandidatesController extends AppBaseController
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
        if($request->tour_id){
            $tourCandidates = TourCandidates::where('tour_id','=',$request->tour_id)->latest()->get();
            $tour=Tours::where('id','=',$request->tour_id)->first();
            return view('tour_candidates.index',[
                'tourCandidates'=>$tourCandidates,
                'tour'=>$tour
            ]);
        }else{
            return response('access_error','403');
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
        $tour=Tours::where('id','=',$request->tour_id)->first();
        $isAlreadyTourMember=Tours::isTourMember($request->tour_id);
        if(!$tour->tour_private&&!$isAlreadyTourMember){
            $req=[
                'tour_id'=>$request->tour_id,
                'user_id'=>Auth::id(),
                'status'=>'new',
                'comment'=>$request->comment
            ];
            ToursController::sendEmailNotification($tour->id,'new_candidate_to_tour');
            TourCandidates::create($req);
            return back();
        }else{
            return back('403');
        }
    }

    public function setStatus($request_id,$status){
        $tc=TourCandidates::findOrFail($request_id);
        //Проверяем что пользователь действительно существует
        $user=User::findOrFail($tc->user_id);
        $tour=Tours::findOrFail($tc->tour_id);
        $isAlreadyTourMember=Tours::isTourMember($tc->tour_id,$tc->user_id);
        if($tour->canEdit&&!$isAlreadyTourMember){
            switch ($status){
                case 'allow':
                    $tc->update(['status'=>'allow']);
                    TourAttendees::updateAttend($tour,$user->id);
                    break;
                case 'cancel':
                    $tc->update(['status'=>'cancel']);
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
