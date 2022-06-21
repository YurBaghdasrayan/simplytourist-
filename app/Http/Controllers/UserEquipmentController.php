<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserEquipmentRequest;
use App\Http\Requests\UpdateUserEquipmentRequest;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\UserEquipment;
use App\Repositories\UserEquipmentRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Response;
use TCG\Voyager\Facades\Voyager;

class UserEquipmentController extends Controller
{
    /** @var  UserEquipmentRepository */
    private $userEquipmentRepository;

    public function __construct(UserEquipmentRepository $userEquipmentRepo)
    {
        $this->userEquipmentRepository = $userEquipmentRepo;
    }

    /**
     * Display a listing of the UserEquipment.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {

//        $userEquipments = UserEquipment::select('equipment_type_id')
//            ->where('user_id','=',Auth::id())
//            ->groupBy('equipment_type_id')
//            ->get();
//        $equipmentsType=EquipmentType::whereIn('id',$userEquipments)->orderBy('name_'.\App::getLocale())->get();
//        return view('user_equipments.index', compact('equipmentsType'));


    }

    public function getMyEquipByType($id){
        $userEquipments=UserEquipment::where('user_id','=',Auth::id())
            ->where('equipment_type_id','=',$id)
            ->with('equipment')
            //->groupBy('equipment_id')
            ->get()->sortBy('equipment.name_'.\App::getLocale())->toArray();
        $result['data']=[];
        foreach ($userEquipments as $equip){
            $equip['name_ru']=$equip['equipment']['name_ru'];
            $equip['name_en']=$equip['equipment']['name_en'];
            $equip['name_de']=$equip['equipment']['name_de'];
            $equip['shop_ru']=$equip['equipment']['shop_ru'];
            $equip['shop_en']=$equip['equipment']['shop_en'];
            $equip['shop_de']=$equip['equipment']['shop_de'];
            $result['data'][]=$equip;
        }
//        dd($result);

        $columns=[
            [
                'field'=>'name_'.\App::getLocale(),
                'key'=>"b",
                "title"=>__('Name'),
                "width"=>200,
                "align"=>"left"
            ],
            [
                'field'=>'note',
                'key'=>"bc",
                "title"=>__('Note'),
                "width"=>200,
                "align"=>"left"
            ],
            [
                'field'=>'shop_'.\App::getLocale(),
                'key'=>"c",
                "title"=>__('Shop'),
                "width"=>300,
                "align"=>"left",
            ]];
//        $equips=Equipment::whereIn('id',$userEquipments)->with(['user_equip' => function($q) {
//            $q->where('user_id', '=', Auth::id());
//        }])->get()->toArray();
//        $result['data']=[];
//        foreach ($equips as $equip){
//            $equip['note']=$equip['user_equip'][0]['note'];
//            $result['data'][]=$equip;
//        }
        $result['columns']=$columns;
//        dd($result);
        return json_encode($result);
    }
    //Обновляем заметку о товаре
    public function update($id, Request $request)
    {
        $equip = UserEquipment::where('user_equipment_id','=',$id)
            ->where('user_id','=',Auth::id())
            ->first();
        if (empty($equip)) {
            return response('not found',404);
        }
        $id = $equip->update($request->only(['note']));
        return response($id,200);
    }
    public function bagCheck($equipment_id,$qty){
        return UserEquipment::inMyBag($equipment_id,$qty);
    }
}
