<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUsergroupCommentsRequest;
use App\Http\Requests\UpdateUsergroupCommentsRequest;
use App\Models\Tours;
use App\Models\UsergroupComments;
use App\Models\UsergroupThemes;
use App\Repositories\UsergroupCommentsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Redirect;
use Response;
use Validator;


class UsergroupCommentsController extends AppBaseController
{
    /** @var  UsergroupCommentsRepository */
    private $usergroupCommentsRepository;
    private static $slug = 'usergroup-comments';


    public function __construct(UsergroupCommentsRepository $usergroupCommentsRepo)
    {
        $this->usergroupCommentsRepository = $usergroupCommentsRepo;
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
        if(isset($request->theme_id)) {
            if(UsergroupComments::checkThemeAccess($request->theme_id)){
                // GET THE SLUG, ex. 'posts', 'pages', etc.
                $query = UsergroupComments::select('*')->where('theme_id','=',(int)$request->theme_id)->OrderBy('created_at','asc');
                $dataTypeContent = self::getData(self::$slug, $request, $query);
                $browserable_rows = self::getFields(self::$slug, $this);
                return view('usergroup_comments.index')
                    ->with(['usergroupComments' => $query->get(), 'rows' => $browserable_rows,'first'=>$query->first()]);
            }else{
                Flash::error(__('Access denied'));
                return back()->with('message', 'error|There was an error...');
                //abort(403);
            }
        }else{
            Flash::error(__('Access denied'));
            return back()->with('message', 'error|There was an error...');
            //abort(404);
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
        $theme = UsergroupThemes::where('id', '=', $request->theme_id)->first();
        $access=UsergroupComments::checkThemeAccess($request->theme_id);
        if($request->text=='null')
            $request->merge(['text' => null]);
        $validator = Validator::make($request->all(),UsergroupComments::$rules);
        $validator->setAttributeNames(UsergroupComments::getAttr());
        if($validator->fails()){
            Flash::error($validator->errors());
            return Redirect::back()->withErrors($validator->errors());
        }
        if($access){
            $lexer = new \nadar\quill\Lexer($request->text);
            UsergroupComments::addComment($lexer->render(), $request->theme_id);
            if (isset($theme->tour_id)) {
                ToursController::sendEmailNotification($theme->tour_id, 'new_comment_in_theme', $theme);
            }
            if (isset($theme->usergroup_id)) {
                UsergroupsController::sendEmailNotification($theme->usergroup_id, 'new_comment_in_theme', $theme);
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
