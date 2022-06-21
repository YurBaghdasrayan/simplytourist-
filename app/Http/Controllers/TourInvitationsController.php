<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTourInvitationsRequest;
use App\Http\Requests\UpdateTourInvitationsRequest;
use App\Models\TourAttendees;
use App\Models\TourInvitations;
use App\Models\Tours;
use App\Models\User;
use App\Repositories\TourInvitationsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Response;
use Validator;
use TCG\Voyager\Facades\Voyager;

class TourInvitationsController extends AppBaseController
{
    /** @var  TourInvitationsRepository */
    private $tourInvitationsRepository;
    private static $slug = 'tour-invitations';

    public function __construct(TourInvitationsRepository $tourInvitationsRepo)
    {
        $this->tourInvitationsRepository = $tourInvitationsRepo;
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
        $user = Auth::user();
        // GET THE SLUG, ex. 'posts', 'pages', etc.
        //Собираем id'шники туров для новорегов
        $tour_ids = TourInvitations::where('status','=','new')
            ->where('user_id', '=', null)
            ->where('user_email', '=', $user->email)
            ->pluck('tour_id');
        $tours = Tours::whereIn('id', $tour_ids);
        $dataTypeContent = ToursController::getData('tours', $request, $tours)->withQueryString();
        $rows = self::getFields('tours', $this);
        $tours = $tours->paginate(15);
        $dataType = Voyager::model('DataType')->where('slug', '=', 'tours')->first();
        return view('tour_invitations.index')
            ->with([
                'tours' => $tours,
                'rows' => $rows,
                'dataTypeContent' => $dataTypeContent,
                'dataType' => $dataType
            ]);
    }


    /**
     * Show the form for creating a new Tours.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        dd('create route');
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
        $req = [];
        $validator = Validator::make($request->all(),TourInvitations::$rules);
        if($validator->fails()){
            Flash::error($validator->errors());
            return Redirect::back()->withErrors($validator->errors())->withInput();
        }
        $author = Auth::user();
        //Если поставлена галочка отправлять прикрепленным к туру, извлекаем их id
        if ($request->send_attendees == 'on') {
            $user_ids = TourAttendees::where('tour_id', '=', $request->tour_id)->pluck('user_id');
            $users = User::whereIn('id', $user_ids)->where('id', '<>', $author->id)->get();
        }
        $emails = [];
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
        if (count($emails) > 0) {
            foreach ($emails as $email) {
                array_push($req, [
                    'tour_id' => $request->tour_id,
                    'user_email' => $email,
                    'author_id' => $author->id,
//                    'user_id' => null,
                    'status' => 'new'
                ]);
            }
        }
        TourInvitations::insert($req);
        return redirect('/tours/' . $request->tour_id);
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
    public function setStatus($request_id, $status)
    {
        $user=Auth::user();
        $ti = TourInvitations::where('tour_id','=',$request_id)->where('user_email','=',$user->email)->first();
        if($ti){
            $tour = Tours::findOrFail($ti->tour_id);

            switch ($status) {
                case 'allow':
                    TourInvitations::where('tour_id','=',$tour->id)->where('user_email','=',$user->email)->update(['status'=>'allow']);
                    \App\Models\TourAttendees::updateOrCreate([
                        'tour_id' => $tour->id,
                        'user_id' => $user->id,
                        'tour_admin' => 0,
                    ]);
                    $tour->update(['open_places' => $tour->OpenPlacez]);
                    break;
                case 'cancel':
                    TourInvitations::where('tour_id','=',$tour->id)->where('user_email','=',$user->email)->update(['status'=>'cancel']);
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
    public function destroy(Request $request, $id)
    {
        return false;
    }
}
