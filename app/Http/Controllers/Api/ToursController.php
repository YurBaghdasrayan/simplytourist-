<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateToursRequest;
use App\Http\Requests\UpdateToursRequest;
use App\Mail\TourCandidate;
use App\Mail\TourEmail;
use App\Mail\TourDescriptionEmail;
use App\Mail\TourNewTheme;
use App\Mail\TourNewThemeComment;
use App\Models\Equipment;
use App\Models\GeoObject;
use App\Models\Languages;
use App\Models\TourAttendees;
use App\Models\TourEquipment;
use App\Models\TourInvitations;
use App\Models\Tours;
use App\Models\ToursConditions;
use App\Models\ToursConditionsRatings;
use App\Models\ToursTypes;
use App\Models\ToursTypesRatings;
use App\Models\User;
use App\Models\UsergroupComments;
use App\Repositories\ToursRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\TourDificultiesList;
use App\Models\TourDificultly;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TCG\Voyager\Facades\Voyager;


class ToursController extends AppBaseController
{
    /** @var  ToursRepository */
    private $toursRepository;
    private static $slug = 'tours';

    public function __construct(ToursRepository $toursRepo)
    {
        $this->toursRepository = $toursRepo;
    }

    public function getSlug(Request $request)
    {
        // dd($request);
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
        $tours = QueryBuilder::for(Tours::class)
            ->allowedFilters([
                'tour_name',
                'country_iso',
                'tour_status',
                AllowedFilter::exact('tour_type_id'),
                AllowedFilter::exact('tour_condition_id'),
                AllowedFilter::scope('more_type_rating'),
                AllowedFilter::scope('more_condition_rating'),
                AllowedFilter::scope('more_open_places'),
                AllowedFilter::scope('guide'),
                AllowedFilter::scope('dificult'),
                ]);
        $tours=$tours->allowedTours(1);

        //По умолчанию ставим статус открыт, иначе смущает Степана
        if(!isset(request('filter')['tour_status']))
        $tours=$tours->where('tour_status','=','open');
        $tours=$tours->where('tour_private','=',0);
        $dataTypeContent = self::getData(self::$slug, $request, $tours)->withQueryString();
        $rows = self::getFields(self::$slug, $this);
        $tours = $dataTypeContent;
        $dataType = Voyager::model('DataType')->where('slug', '=', self::$slug)->first();
        $tourTypes = ToursTypes::orderBy('name_'.\App::getLocale())->get();
        $tourConditions = ToursConditions::orderBy('name_'.\App::getLocale())->paginate(10);
        $tourDificults = TourDificultly::orderBy('name_'.\App::getLocale())->paginate(10);

        return Voyager::view('tours.index', compact(
            'tours',
            'rows',
            'dataType',
            'dataTypeContent',
            'tourTypes',
            'tourConditions',
            'tourDificults'
        ));
    }
    public function myTours(Request $request){
        
        $tours = QueryBuilder::for(Tours::class)
            ->allowedFilters([
                'tour_name',
                'country_iso',
                'tour_status',
                AllowedFilter::exact('tour_type_id'),
                AllowedFilter::exact('tour_condition_id'),
                AllowedFilter::scope('more_type_rating'),
                AllowedFilter::scope('more_condition_rating'),
                AllowedFilter::scope('more_open_places'),
                AllowedFilter::scope('guide'),
                AllowedFilter::scope('dificult'),
            ]);
        $tours=$tours->attend(1);
        //По умолчанию ставим статус открыт, иначе смущает Степана
        if(!isset(request('filter')['tour_status'])){
            $tours=$tours->where('tour_status','=','open');
            $toursgroup = TourAttendees::leftJoin('tours', 'tour_attendees.tour_id', '=', 'tours.id')
            ->where('user_id', auth()->user()->id)->get();
            $dataTypeContent = self::getData(self::$slug, $request, $tours)->withQueryString();
            $rows = self::getFields(self::$slug, $this);
            $tours = $dataTypeContent;
            $dataType = Voyager::model('DataType')->where('slug', '=', self::$slug)->first();
            $tourTypes = ToursTypes::orderBy('name_'.\App::getLocale())->paginate(10);
            $tourConditions = ToursConditions::orderBy('name_'.\App::getLocale())->paginate(10);
            $tourDificults = TourDificultly::orderBy('name_'.\App::getLocale())->paginate(10);
            
            return response()->json([
                "data" =>['my_tours' => $tours,
                'my_tours_group' => $toursgroup]
                
                // 'rows' => $rows,
                // 'dataType' => $dataType,
                // 'dataTypeContent' => $dataTypeContent,
                // 'tourTypes' => $tourTypes,
                // 'tourConditions' => $tourConditions,
                // 'tourDificults' => $tourDificults
                ]);
        }            
    }

    
    public function publicIndex(Request $request)
    {
        $tours = QueryBuilder::for(Tours::class)
            ->allowedFilters([
                'tour_name',
                'country_iso',
                'tour_status',
                AllowedFilter::exact('tour_type_id'),
                AllowedFilter::exact('tour_condition_id'),
                AllowedFilter::scope('more_type_rating'),
                AllowedFilter::scope('more_condition_rating'),
                AllowedFilter::scope('more_open_places'),
                AllowedFilter::scope('guide'),
                AllowedFilter::scope('dificult'),
            ]);
        $tours=$tours->where('tour_private','=',0)->where('tour_status','=','open');
        $dataTypeContent = self::getData(self::$slug, $request, $tours)->withQueryString();
        $rows = self::getFields(self::$slug, $this);
        $tours = $tours->paginate(4);
        $dataType = Voyager::model('DataType')->where('slug', '=', self::$slug)->first();
        $tourTypes = ToursTypes::orderBy('name_'.\App::getLocale())->paginate(10);
        $tourConditions = ToursConditions::orderBy('name_'.\App::getLocale())->paginate(10);
        $tourDificults = TourDificultly::orderBy('name_'.\App::getLocale())->paginate(10);
        $title=__('Public tours');
        return Voyager::view('public.tours.index', compact(
            'title',
            'tours',
            'rows',
            'dataType',
            'dataTypeContent',
            'tourTypes',
            'tourConditions',
            'tourDificults'
        ));
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

        $tourTypes = ToursTypes::orderBy('name_'.\App::getLocale())->paginate(10);
        $tourConditions = ToursConditions::orderBy('name_'.\App::getLocale())->paginate(10);
        $tourDificults = TourDificultly::orderBy('name_'.\App::getLocale())->paginate(10);
//        $dataTypeContent = self::getData(self::$slug, $request, $query);
        $browserable_rows = self::getFields(self::$slug, $this);
        $dataType = Voyager::model('DataType')->where('slug', '=', self::$slug)->first();
        return view('tours.create')
            ->with(['dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent,
            'tourTypes'=>$tourTypes,
            'rows'=>$browserable_rows,
            'data'=>$dataTypeContent,
            'tourConditions'=>$tourConditions,
            'tourDificults' =>$tourDificults
        ]);
    }

    public function checkValidation(Request $request){
        $req=$request->only([
            'tour_type_id',
            'tour_condition_id',
            'tour_status',
            'tour_type_rating',
            'tour_condition_rating',
            'tour_type_description',
            'tour_condition_description',
            'attendees_min',
            'attendees_max',
            'estimated_costs',
            'tour_name',
            'tour_link',
            'tour_description',
            'country_iso',
        ]);
        //Если выбран существующий геообъект,ищем его координаты
        if(isset($request->geo_object_id)&&is_numeric($request->geo_object_id)){
            $geo=GeoObject::find($request->geo_object_id);
            $req+=[
                'geo_object_id'=>$request->geo_object_id,
                'target_coordinates'=>$geo->coordinates,
            ];
        }
        //Иначе создаем новый геообъект
        else {
            if(isset($request->geo_object_coordinates)&&$request->geo_object_coordinates!='') {
                $geo=GeoObject::updateOrCreate([
                    'name_' . \App::getLocale() => $request->geo_object_name,
                    'coordinates' => $request->geo_object_coordinates,
                    'country_iso'=>$request->geo_country_iso,
                    'countries'=>Languages::getCountry($request->geo_country_iso)
                ]);
                $req+=[
                    'geo_object_id'=>$geo->id,
                    'target_coordinates'=>$geo->coordinates
                ];
            }
        }
        $validator = Validator::make($req,Tours::$rules);
        $validator->setAttributeNames(Tours::getAttr());
        if($validator->fails()){
            return $validator->errors();
        }
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
        $validator = Validator::make($request->all(),Tours::$rules);
        $validator->setAttributeNames(Tours::getAttr());
        if($validator->fails()){
            Flash::error($validator->errors());
            return Redirect::to('/tours/create')->withErrors($validator->errors())->withInput();
        }
        $req=self::prepareInput($request);
        $req+=['tour_creator'=>Auth::id()];

        $tour=Tours::create($req);
        if($request->tour_equipment){
            $equips_res=self::prepareEquipmentInput($request,$tour->id);
            TourEquipment::insert($equips_res);
        }
        if($request->selected_users){
            $tour_attendees_req=self::prepareUserInput($request,$tour->id);
            TourAttendees::insert($tour_attendees_req);
        }
        if($request->tour_dificult){
            //Уровни сложности тура
            $dificults=explode(',',$request->tour_dificult);
            $tourDifRequest=[];
            $i=0;
            foreach($dificults as $d){
                $tourDifRequest[$i]['tour_id']=$tour->id;
                $tourDifRequest[$i]['dificult_id']=$d;
                $i++;
            }
            TourDificultiesList::insert($tourDifRequest);
        }
        Flash::success(__('Tour created successfully.'));
        return redirect()->route("tours.index");
    }

    public static function prepareInput(Request $request){
        $req=$request->only([
            'tour_type_id',
            'tour_condition_id',
            'tour_status',
            'tour_type_rating',
            'tour_condition_rating',
            'tour_type_description',
            'tour_condition_description',
            'attendees_min',
            'attendees_max',
            'estimated_costs',
            'tour_name',
            'tour_link',
            'tour_description',
            'country_iso',
        ]);
        //Если выбран существующий геообъект,ищем его координаты
        if(isset($request->geo_object_id)&&is_numeric($request->geo_object_id)){
            $geo=GeoObject::find($request->geo_object_id);
            $req+=[
                'geo_object_id'=>$request->geo_object_id,
                'target_coordinates'=>$geo->coordinates,
            ];
        }
        //Иначе создаем новый геообъект
        else {
            if(isset($request->geo_object_coordinates)&&$request->geo_object_coordinates!='') {
                $geo=GeoObject::updateOrCreate([
                    'name_' . \App::getLocale() => $request->geo_object_name,
                    'coordinates' => $request->geo_object_coordinates,
                    'country_iso'=>$request->geo_country_iso,
                    'countries'=>Languages::getCountry($request->geo_country_iso)
                ]);
                $req+=[
                    'geo_object_id'=>$geo->id,
                    'target_coordinates'=>$geo->coordinates
                ];
            }
        }
        if($request->hasFile('image')){
            $filePath=self::resizeImage($request,'image','tours',320);
            $req+=['image'=>$filePath];
        }
        $open_places=$request->attendees_max;
        //Если были указаны участники тура - считаем их количество
        if($request->selected_users){
            $selectedUsers=explode(',',$request->selected_users);
            if(count($selectedUsers)>$open_places){
                $open_places=0;
            }else{
                $open_places=$open_places-count($selectedUsers);
            }
        }
        $req+=[
            'tour_date_start'=>Carbon::parse($request->tour_date_start),
            'tour_date_end'=>Carbon::parse($request->tour_date_end),
            'tour_private'=>($request->tour_private=='yes')?1:0,
            'guide_needed'=>($request->guide_needed=='yes')?1:0,
            'guided'=>($request->guided=='yes')?1:0,
            'open_places'=>$open_places
        ];

        return $req;
    }
    public static function prepareEquipmentInput(Request $request,$tour_id){
        //Добавляем снаряжение тура
        $tours_equips=explode(',',$request->tour_equipment);
        $tours_equips_comments=json_decode($request->tour_equipment_notes);
        $tours_equips_qty=json_decode($request->tour_equipment_qty);
        $i=0;
        foreach ($tours_equips as $te){
            $equip_element=Equipment::find($te);
            $equips_res[$i]['tour_id']=$tour_id;
            $equips_res[$i]['equipment_id']=$te;
            $equips_res[$i]['equipment_note']='';
            $equips_res[$i]['equipment_qty']=1;
            $equips_res[$i]['equipment_type_id']=$equip_element->equipment_type_id;
            foreach ($tours_equips_comments as $tec){
                if($tec->id==$te){
                    $equips_res[$i]['equipment_note']=$tec->note;
                }
            }
            foreach ($tours_equips_qty as $teq){
                if($teq->id==$te){
                    $equips_res[$i]['equipment_qty']=$teq->qty;
                }
            }
            $i++;
        }

        return $equips_res;
    }
    public static function prepareUserInput(Request $request,$tour_id){
        //Добавляем пользователей
        $selectedUsers=explode(',',$request->selected_users);
        $selectedAdmins=explode(',',$request->tour_admins);
        $tour_attendees_req=[];
        $i=0;
        foreach ($selectedUsers as $su){
            $user=User::find($su);
            if($user){
                $tour_attendees_req[$i]['tour_id']=$tour_id;
                $tour_attendees_req[$i]['user_id']=$su;
                if(in_array($su,$selectedAdmins)){
                    $tour_attendees_req[$i]['tour_admin']=1;
                }else{
                    $tour_attendees_req[$i]['tour_admin']=0;
                }
                $i++;
            }
        }
        return $tour_attendees_req;
    }
    /**
     * @param Request $request
     * @param $id
     * @return bool
     */
    public function show(Request $request,$id)
    {

        $tour=Tours::where('id','=',$id)->with(['tourType','tourDificult','tourDificult.diff'])->allowedTours(1)->first();
        $tourAttend=TourAttendees::where('tour_id','=',$id)->where('user_id','>',0)->with('user')->get();
        $tourEquipment = TourEquipment::where('tour_id','=',$id)->pluck('equipment_note','equipment_id')->toJson();
        $tourEquipmentQTY = TourEquipment::where('tour_id','=',$id)->get(['equipment_id','equipment_qty','equipment_id as id','equipment_qty as qty'])->toJson();
        $tc = ToursConditionsRatings::where('tour_condition_id','=',$tour->tour_condition_id)
            ->where('tour_condition_rating','=',$tour->tour_condition_rating)->first();
        $tour->tour_condition_description=$tc['description_'.\App::getLocale()];
        $tt = ToursTypesRatings::where('tour_type_id','=',$tour->tour_type_id)
            ->where('tour_type_rating','=',$tour->tour_type_rating)->first();
        $tour->tour_condition_description=$tc['description_'.\App::getLocale()];
        $tour->tour_type_description=$tt['description_'.\App::getLocale()];
        if (empty($tour)) {
            Flash::error('Tours not found');

            return redirect(route('tours.index'));
        }

        return view('tours.show',compact('tour','tourEquipment','tourAttend','tourEquipmentQTY'));
    }
    public function publicShow($tour)
    {
        $tour=Tours::where('id','=',$tour)->where('tour_private','=',0)->with(['tourType','tourDificult','tourDificult.diff'])->first();
        if (empty($tour)) {
            Flash::error('Tours not found');

            return redirect(route('toursPublic'));
        }
        $tc = ToursConditionsRatings::where('tour_condition_id','=',$tour->tour_condition_id)
            ->where('tour_condition_rating','=',$tour->tour_condition_rating)->first();
        $tour->tour_condition_description=$tc['description_'.\App::getLocale()];
        $tt = ToursTypesRatings::where('tour_type_id','=',$tour->tour_type_id)
            ->where('tour_type_rating','=',$tour->tour_type_rating)->first();
        $tour->tour_condition_description=$tc['description_'.\App::getLocale()];
        $tour->tour_type_description=$tt['description_'.\App::getLocale()];
        $tourEquipment = TourEquipment::where('tour_id','=',$tour->id)->pluck('equipment_note','equipment_id')->toJson();
        $tourAttend=TourAttendees::where('tour_id','=',$tour->id)->where('user_id','>',0)->with('user')->get();
        $tourEquipmentQTY = TourEquipment::where('tour_id','=',$tour->id)->get(['equipment_id','equipment_qty','equipment_id as id','equipment_qty as qty'])->toJson();
        $title=$tour->tour_name;
        return view('public.tours.show', compact('title','tour','tourEquipment','tourAttend','tourEquipmentQTY'));
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
        $slug = $this->getSlug($request);
        Tours::checkEditAccess($id);
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);
            $query = $model->query()->allowedTours(1);

            // Use withTrashed() if model uses SoftDeletes and if toggle is selected
            if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
                $query = $query->withTrashed();
            }
            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
                $query = $query->{$dataType->scope}();
            }
            $dataTypeContent = call_user_func([$query, 'findOrFail'], $id);
        } else {
            // If Model doest exist, get data from table name
            $dataTypeContent = DB::table($dataType->name)->where('id', $id)->first();
        }

        foreach ($dataType->editRows as $key => $row) {
            $dataType->editRows[$key]['col_width'] = isset($row->details->width) ? $row->details->width : 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'edit');

        // Check permission
        $this->authorize('edit', $dataTypeContent);

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        // Eagerload Relations
        $this->eagerLoadRelations($dataTypeContent, $dataType, 'edit', $isModelTranslatable);
        $tourTypes = ToursTypes::orderBy('name_'.\App::getLocale())->paginate(10);
        $tourConditions = ToursConditions::orderBy('name_'.\App::getLocale())->paginate(10);
        $tourEquipment = TourEquipment::where('tour_id','=',$id)->pluck('equipment_note','equipment_id')->toJson();
        $tourEquipmentQTY = TourEquipment::where('tour_id','=',$id)->get(['equipment_id as id','equipment_qty as qty'])->toJson();
        $tourAttend = TourAttendees::where('tour_id','=',$id)->where('user_id','>',0)->paginate(10)->toJson();
        $tourDificults = TourDificultly::orderBy('name_'.\App::getLocale())->paginate(10);
        $tourDificultList = TourDificultiesList::where('tour_id','=',$id)->pluck('dificult_id')->toArray();
        $browserable_rows = self::getFields(self::$slug, $this);
        $geoObject = (isset($dataTypeContent->geo_object_id))?GeoObject::find($dataTypeContent->geo_object_id):null;
        return view('tours.edit')
            ->with([
                'tours' => $dataTypeContent->toArray(),
                'dataType' => $dataType,
                'dataTypeContent' => $dataTypeContent,
                'data'=>$dataTypeContent,
                'rows'=>$browserable_rows,
                'tourTypes' => $tourTypes,
                'tourConditions' => $tourConditions,
                'tourEquipment' => $tourEquipment,
                'tourEquipmentQTY' => $tourEquipmentQTY,
                'tourAttend' => $tourAttend,
                'tourDificults' => $tourDificults,
                'tourDificultList' => implode(',',$tourDificultList),
                'geoObject'=>$geoObject
            ]);
    }

    /**
     * Update the specified Tours in storage.
     *
     * @param int $id
     * @param UpdateToursRequest $request
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        Tours::checkEditAccess($id);
        $validator = Validator::make($request->all(),Tours::$rules);
        $validator->setAttributeNames(Tours::getAttr());
        if($validator->fails()){
            Flash::error($validator->errors());
            return Redirect::back()->withErrors($validator->errors());
        }
        $req=self::prepareInput($request);
        $tour = Tours::find($id);
        $tour->update($req);
        self::sendEmailNotification($tour->id,'description_change');
        TourEquipment::where('tour_id','=',$tour->id)->delete();
        if($request->tour_equipment) {
            $equips_res = self::prepareEquipmentInput($request, $tour->id);
            TourEquipment::insert($equips_res);
        }

        TourAttendees::where('tour_id','=',$tour->id)->delete();
        if($request->selected_users) {
            $tour_attendees_req=self::prepareUserInput($request,$tour->id);
            TourAttendees::insert($tour_attendees_req);
        }
        TourDificultiesList::where('tour_id','=',$tour->id)->delete();
        //Уровни сложности тура
        if($request->tour_dificult) {

            $dificults = explode(',', $request->tour_dificult);
            $tourDifRequest = [];
            $i = 0;
            foreach ($dificults as $d) {
                $tourDifRequest[$i]['tour_id'] = $tour->id;
                $tourDifRequest[$i]['dificult_id'] = $d;
                $i++;
            }
            TourDificultiesList::insert($tourDifRequest);
        }
        Flash::success(__('Tour updated successfully.'));
        return redirect('/tours/'.$tour->id.'/edit/');
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

    public function setStatus($tour_id,$tour_status){
        Tours::checkEditAccess($tour_id);
        //Если статус поменяли-шлем уведомление всем участникам тура
        if(Tours::setStatus($tour_status,$tour_id)){
            self::sendEmailNotification($tour_id);
        }
        return back();
    }

    public static function sendEmailNotification($tour_id,$type='status_change',$theme=false)
    {
        $isMember=Tours::isTourMember($tour_id);
        $tour=Tours::find($tour_id);
        $send_list=Tours::getTourMembers($tour_id,$tour->tour_creator);
        $objDemo = new \stdClass();
        $objDemo->tour_link = env('APP_URL').'tours/'.$tour_id;
        $objDemo->tour_name = $tour->tour_name;
        $objDemo->tour_status = $tour->tour_status;
        if($isMember){
            if(count($send_list)>0){

                switch ($type){
                    case 'status_change':
                        foreach ($send_list as $user){
                            $user_locale=($user->user_locale)?:'en';
                            Mail::to($user->email)
                                ->locale($user_locale)
                                ->send(new TourEmail($objDemo));
                        }

                        break;
                    case 'description_change':
                        foreach ($send_list as $user) {
                            $user_locale = ($user->user_locale) ?: 'en';
                            Mail::to($user->email)
                                ->locale($user_locale)
                                ->send(new TourDescriptionEmail($objDemo));
                        }
                        break;
                    case 'new_theme':
                        $objDemo->theme=$theme;
                        foreach ($send_list as $user) {
                            $user_locale = ($user->user_locale) ?: 'en';
                            Mail::to($user->email)
                                ->locale($user_locale)
                                ->send(new TourNewTheme($objDemo));
                        }
                        break;
                    case 'new_comment_in_theme':
                        $objDemo->theme=$theme;
                        foreach ($send_list as $user) {
                            $user_locale = ($user->user_locale) ?: 'en';
                            Mail::to($user->email)
                                ->locale($user_locale)
                                ->send(new TourNewThemeComment($objDemo));
                        }
                        break;

                }
            }
        }else{
            switch ($type){
                case 'new_candidate_to_tour':
                    $tour_admins=TourAttendees::getTourAdmins($tour);
                    foreach ($tour_admins as $admin){
                        $admin_locale=($admin->user_locale)?:'en';
                        Mail::to($admin->email)
                            ->locale($admin_locale)
                            ->send(new TourCandidate($objDemo));
                    }
                    break;
            }
        }
    }

    public function invitations($tour_id){
        Tours::checkEditAccess($tour_id);
        $tour=Tours::find($tour_id);
        $invitationsList=TourInvitations::where('tour_id','=',$tour_id)->paginate(10);
        //Если статус поменяли-шлем уведомление всем участникам тура
        return view('tours.invite',compact('tour_id','tour','invitationsList'));
    }

    public function tourDiscussionIndex(Request $request){
        if(isset($request->theme_id)) {
            if(UsergroupComments::checkThemeAccess($request->theme_id)) {
                // GET THE SLUG, ex. 'posts', 'pages', etc.
                $query = UsergroupComments::select('*')->where('theme_id', '=', (int)$request->theme_id)->OrderBy('created_at', 'asc');
                $dataTypeContent = self::getData(self::$slug, $request, $query)->withQueryString();
                $browserable_rows = self::getFields(self::$slug, $this);
                return view('usergroup_comments.index')
                    ->with(['usergroupComments' => $query->get(), 'rows' => $dataTypeContent, 'first' => $query->first()]);
            }else{
                Flash::error(__('Access denied'));
                return back()->with('message', 'error|There was an error...');
            }
        }else{
            Flash::error(__('Access denied'));
            return back()->with('message', 'error|There was an error...');
        }
    }
    public function tourDiscussionCreate($tour_id,Request $request){
        $access=Tours::isTourMember($tour_id);
        if($access) {
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
            //$browserable_rows = self::getFields(self::$slug, $this);
            $dataType = Voyager::model('DataType')->where('slug', '=', self::$slug)->first();
            return view('tours.theme_create')
                ->with(['dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'tour_id' => $tour_id]);
        }else{
            return abort(403);
        }
    }
}
