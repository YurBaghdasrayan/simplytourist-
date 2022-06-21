<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTourInvitationsRequest;
use App\Http\Requests\UpdateTourInvitationsRequest;
use App\Models\TourAttendees;
use App\Models\TourInvitations;
use App\Models\Tours;
use App\Models\User;
use App\Repositories\TourInvitationsRepository;
use App\Http\Controllers\AppBaseController;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Response;
use Validator;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Str;


class TourApiInvitationsController extends Controller
{
    private $tourInvitationsRepository;
    private static $slug = 'tour-invitations';

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

    public function __construct(TourInvitationsRepository $tourInvitationsRepo)
    {
        $this->tourInvitationsRepository = $tourInvitationsRepo;
    }

    public function getSlug(Request $request)
    {
        return self::$slug;
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        // GET THE SLUG, ex. 'posts', 'pages', etc.
        //Собираем id'шники туров для новорегов
        $tour_ids = TourInvitations::where('status', '=', 'new')
            ->where('user_id', '=', null)
            ->where('user_email', '=', $user->email)
            ->pluck('tour_id');
        $tours = Tours::whereIn('id', $tour_ids);
        $dataTypeContent = ToursController::getData('tours', $request, $tours)->withQueryString();
        $rows = self::getFields('tours', $this);
        $tours = $tours->paginate(15);
        $dataType = Voyager::model('DataType')->where('slug', '=', 'tours')->first();

        return response()->json([
            'success' => true,
            'tours' => $tours,
            'rows' => $rows,
            'dataTypeContent' => $dataTypeContent,
            'dataType' => $dataType
        ], 200);
    }

    public function store(Request $request)
    {
        $req = [
            "tour_id" => $request->tour_id,
            "user_email" => $request->emails,
            "author_id" => $request->author_id,
            "status" => $request->status,
            "send_status" => $request->send_attendees,
            'created_at' => now(),
            'updated_at' => now(),
//            "type"=>$request->type
        ];
//        $request->all();
        $validator = Validator::make($request->all(), TourInvitations::$rules);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $author = Auth::user();


        //Если поставлена галочка отправлять прикрепленным к туру, извлекаем их id

        if ($request->send_attendees == 'on') {
            $user_ids = TourAttendees::where('tour_id', '=', $request->tour_id)->pluck('user_id');
            $users = User::whereIn('id', $user_ids)->where('id', '<>', $author->id)->get();
        }

        $emails = [];

        //Если выбраны только email - пишем их

        switch ($request->type) {
            case 'email':
                $emails = $request->email;
                break;
            case 'nickname':
                foreach ($request->email as $userNick) {
                    $user = User::where('name', '=', $userNick)->first();
                    if (isset($user->email)) {
                        array_push($emails, $user->email);
                    }
                }
                break;
        }

        TourInvitations::insert($req);

        if ($req) {
            return response()->json([
                'success' => true,
                'data' => [
                    'tour_id' => $request->tour_id],
                'message' => "successfully send"
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "something was wrong"
            ], 422);
        }
    }

    public function setStatus($request_id, $status)
    {
        $user = Auth::user();

        $ti = TourInvitations::where('tour_id', '=', $request_id)->where('user_email', '=', $user->email)->first();

        if ($ti) {
            $tour = Tours::findOrFail($ti->tour_id);
            switch ($status) {
                case 'allow':
                    TourInvitations::where('tour_id', '=', $tour->id)->update(['status' => 'allow']);
                    \App\Models\TourAttendees::updateOrCreate([
                        'tour_id' => $tour->id,
                        'user_id' => $user->id,
                        'tour_admin' => 0,
                    ]);
                    $tour->update(['open_places' => $tour->OpenPlacez]);
                    break;
                case 'cancel':
                    TourInvitations::where('tour_id', '=', $tour->id)->where('user_email', '=', $user->email)->update(['status' => 'cancel']);
                    return response()->json('cancel');
                    break;

            }
            return response()->json([
                'success' => true,
                'message' => 'your status allowed',
            ]);
        } else {
            return abort(403);
        }
    }
}
