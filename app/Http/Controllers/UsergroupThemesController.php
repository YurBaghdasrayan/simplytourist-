<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUsergroupThemesRequest;
use App\Http\Requests\UpdateUsergroupThemesRequest;
use App\Models\Tours;
use App\Models\UsergroupComments;
use App\Models\Usergroups;
use App\Models\UsergroupThemes;
use App\Repositories\ToursRepository;
use App\Repositories\UsergroupThemesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Response;
use TCG\Voyager\Facades\Voyager;

class UsergroupThemesController extends AppBaseController
{
    /** @var  UsergroupThemesRepository */
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
        if(isset($request->usergroup_id)){
            $usergroup=Usergroups::where('id','=',$request->usergroup_id)->AllowedGroups(1)->first();
            if(isset($usergroup->usergroup_name)){
                // GET THE SLUG, ex. 'posts', 'pages', etc.
                $query=UsergroupThemes::select('*')->where('usergroup_id','=',(int)$request->usergroup_id);
                $dataTypeContent = self::getData(self::$slug, $request, $query);
                $browserable_rows = self::getFields(self::$slug, $this);
                return view('usergroup_themes.index')
                    ->with(['usergroupThemes'=>$dataTypeContent,'group_id'=>$request->usergroup_id,'rows'=>$browserable_rows,'usergroup'=>$usergroup]);
            }else{
                abort(403);
            }
        }else{
            abort(404);
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
        $usergroup=Usergroups::find($request->usergroup_id);
        return view('usergroup_themes.create')
            ->with(['dataType'=>$dataType,'data'=>$dataTypeContent,'usergroup'=>$usergroup,'rows'=>$browserable_rows]);
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
        $access=false;
        //check access
        if(!isset($request->tour_id)){
            $access=Usergroups::where('id','=',$request->usergroup_id)->AllowedGroups(1)->first();
        }else{
            //Пользователь является членом тура
            $access=Tours::isTourMember($request->tour_id);
        }
        if($access){
            $req=$request->except(['user_id']);
            $req+=['user_id'=>Auth::id()];
            $theme_id=UsergroupThemes::create($req);

            //Добавляем первый коммент
            UsergroupComments::addComment($request->comment,$theme_id->id);
            Flash::success(__('Topic created successfully.'));

            if(!isset($request->tour_id)){
                UsergroupsController::sendEmailNotification($request->usergroup_id,'new_theme',$theme_id);
                return redirect("/usergroup/themes/".$theme_id->id);
            }else{
                ToursController::sendEmailNotification($request->tour_id,'new_theme',$theme_id);
                return redirect("/tours/themes/".$theme_id->id);
            }
        }else{
            abort(403);
        }
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
