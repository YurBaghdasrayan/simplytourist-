<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Models\Equipment;
use App\Models\UserEquipment;
use App\Repositories\EquipmentRepository;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use TCG\Voyager\Facades\Voyager;

class EquipmentController extends AppBaseController
{
    /** @var  EquipmentRepository */
    private $equipmentRepository;
    private static $slug = 'equipment';

    public function __construct(EquipmentRepository $equipmentRepo)
    {
        $this->equipmentRepository = $equipmentRepo;
    }
    public function getSlug(Request $request)
    {
        return 'equipment';
    }
    /**
     * Display a listing of the Equipment.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
//        $query=Equipment::select('*');
//        $dataTypeContent = self::getData(self::$slug, $request, $query);
//        $browserable_rows = self::getFields(self::$slug, $this);
//
//        return view('equipment.index')
//            ->with(['equipment'=>$dataTypeContent,'rows'=>$browserable_rows]);
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
     * Update the specified Equipment in storage.
     *
     * @param int $id
     * @param UpdateEquipmentRequest $request
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        return false;
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

    /**
     * Возвращает список оборудования для туров и профиля.
     * @param $ids
     * @param false $groupByCategory
     * @return mixed
     */
    public function getByIds($ids){
        $ids_arr=explode(',',$ids);
        return Equipment::whereIn('id',$ids_arr)->with('tour_equip')->orderBy('name_'.\App::getLocale())->get()->toJson();
    }

    public function addMyEquipment(Request $request){
        $equips_qty=collect(json_decode($request->equipment_qty));
        foreach ($request->equipment_ids as $eq_id){
            $e=$equips_qty->where('id','=',$eq_id)->first();
            if(isset($e->qty)&&$e->qty>1){
                for ($i=0;$i<$e->qty;$i++){
                    Equipment::addMyEquipment([$e->id]);
                }
            }else{
                Equipment::addMyEquipment([$eq_id]);
            }
        }
        return back();
    }
    public function removeMyEquipment(Request $request){
        Equipment::removeMyEquipment($request->equipment_ids);
        return back();
    }


    public function getEquipByType($id,Request $request){
        $alreadyInBag=[];//UserEquipment::where('user_id','=',Auth::id())->pluck('equipment_id');
        $columns=[
            [
                'field'=>'name_'.\App::getLocale(),
                'key'=>"b",
                "title"=>__('Name'),
                "width"=>200,
                "align"=>"left"
            ],
            [
                'field'=>'shop_'.\App::getLocale(),
                'key'=>"c",
                "title"=>__('Shop'),
                "width"=>300,
                "align"=>"left"
            ]];
        //if(isset($request->fetchAll))
            $result['data']=Equipment::where('equipment_type_id','=',$id)->orderBy('name_'.\App::getLocale())->get()->toArray();
        //else
        //    $result['data']=Equipment::whereNotIn('id',$alreadyInBag)->where('equipment_type_id','=',$id)->orderBy('name_'.\App::getLocale())->get()->toArray();
        $result['columns']=$columns;
        return json_encode($result);
    }

}
