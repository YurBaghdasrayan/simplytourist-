<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTourAttendeesRequest;
use App\Http\Requests\UpdateTourAttendeesRequest;
use App\Models\TourAttendees;
use App\Repositories\TourAttendeesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class TourAttendeesController extends AppBaseController
{
    /** @var  TourAttendeesRepository */
    private $tourAttendeesRepository;
    private static $slug = 'tour-attendees';

    public function __construct(TourAttendeesRepository $tourAttendeesRepo)
    {
        $this->tourAttendeesRepository = $tourAttendeesRepo;
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
//        // GET THE SLUG, ex. 'posts', 'pages', etc.
//        $query=TourAttendees::select('*');
//        $dataTypeContent = self::getData(self::$slug, $request, $query);
//        $browserable_rows = self::getFields(self::$slug, $this);
//
//        return view('tour_attendees.index')
//            ->with(['tourAttendees'=>$dataTypeContent,'rows'=>$browserable_rows]);
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
