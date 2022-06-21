<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateUsergroupThemesRequest;
use App\Http\Requests\UpdateUsergroupThemesRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UsergroupThemesRepository;
use App\Models\Tours;
use App\Models\UsergroupComments;
use App\Models\Usergroups;
use App\Models\UsergroupThemes;
use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\UsergroupsController;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\Auth;
use Flash;
use Response;

class UsergroupThemesController extends AppBaseController
{
    private $usergroupThemesRepository;
    private static $slug = 'usergroup-themes';

    public function __construct(UsergroupThemesRepository $usergroupThemesRepo)
    {
        $this->usergroupThemesRepository = $usergroupThemesRepo;
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
        if (isset($request->usergroup_id)) {
            $usergroup = Usergroups::where('id', '=', $request->usergroup_id)->AllowedGroups(1)->first();
            if (isset($usergroup->usergroup_name)) {
                // GET THE SLUG, ex. 'posts', 'pages', etc.
                $query = UsergroupThemes::select('*')->where('usergroup_id', '=', (int)$request->usergroup_id)->with('user');
                $dataTypeContent = self::getData(self::$slug, $request, $query);
                $browserable_rows = self::getFields(self::$slug, $this);

                return response()->json([
                    "data" => ['usergroupThemes' => $dataTypeContent,
                        'group_id' => $request->usergroup_id,
                        'rows' => $browserable_rows,
                        'usergroup' => $usergroup]
                ]);
            } else {
                return response()->json([
                    "message" => "abort"
                ], 403);
            }
        } else {
            return response()->json([
                "message" => "abort"
            ], 403);
        }

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

        $usergroup = Usergroups::find($request->usergroup_id);
        // dd($usergroup);
        return response()->json(['dataType' => $dataType, 'data' => $dataTypeContent, 'usergroup' => $usergroup, 'rows' => $browserable_rows]);
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
        $file = $request->file('file');
        if ($file) {
            $destinationPath = 'public/uploads';
            $user_image = time() . $file->getClientOriginalName();
            $file->storeAs($destinationPath, $user_image);
        }
        $access = false;

        //check access
        if (!isset($request->tour_id)) {
            $access = Usergroups::where('id', '=', $request->usergroup_id)->AllowedGroups(1)->first();

        } else {
            //Пользователь является членом тура
            $access = Tours::isTourMember($request->tour_id);
        }
        if ($access) {
            if (isset($user_image)){
                $req = [
                    'usergroup_id' => $request->usergroup_id,
                    'theme' => $request->theme,
                    'user_id' => Auth::id(),
                    'comment' => $request->comment,
                    'tour_id' => $request->tour_id,
                    'file' => $user_image
                ];
            }else{
                $req = [
                    'usergroup_id' => $request->usergroup_id,
                    'theme' => $request->theme,
                    'user_id' => Auth::id(),
                    'comment' => $request->comment,
                    'tour_id' => $request->tour_id,
                ];
            }
            $theme_id = UsergroupThemes::create($req);

            //Добавляем первый коммент
            UsergroupComments::addComment($request->comment, $theme_id->id);
            return response()->json('Topic created successfully.');

            if (!isset($request->tour_id)) {
                UsergroupsController::sendEmailNotification($request->usergroup_id, 'new_theme', $theme_id);
                return response()->json([
                    "success" => true,
                    "message" => "your email notification",
                    "data" => [$theme_id->id]
                ], 200);
            } else {
                ToursController::sendEmailNotification($request->tour_id, 'new_theme', $theme_id);
                return response()->json([
                    "succes" => true,
                    "message" => "your email notification",
                    $theme_id->id
                ], 200);
            }
        } else {
            abort(403);
        }
    }

//    public function destroy($id)
//    {
//        dd($id);
//
//    }

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
}
