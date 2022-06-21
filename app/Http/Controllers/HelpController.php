<?php

namespace App\Http\Controllers;

use App\Models\FieldsHelp;
use App\Models\Banners;
use App\Models\Review;
use App\Models\Tours;
use App\Models\ToursConditions;
use App\Models\ToursConditionsRatings;
use App\Models\ToursTypes;
use App\Models\ToursTypesRatings;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TCG\Voyager\Facades\Voyager;

class HelpController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }


    public function getRatingHelp(String $type,$rating,$ref_ids='',$show_prepend=1){
        if($show_prepend===1)
            $text=__('Change rating value to show prefered tours.');
        else
            $text='';
        $locale=\App::getLocale();
        $ref_ids=explode(',',$ref_ids);
        if(count($ref_ids)>0){
            switch ($type){
                case 'type_description':
                    $tt=ToursTypesRatings::whereIn('tour_type_id',$ref_ids)
                        ->where('tour_type_rating','=',$rating)
                        ->pluck('description_'.$locale)->toArray();
                    if(count($tt)>0)
                        $text.="<li>".implode('</li><li>', $tt)."</li>";
                    break;
                case 'condition_description':
                    $tc=ToursConditionsRatings::whereIn('tour_condition_id',$ref_ids)
                        ->where('tour_condition_rating','=',$rating)
                        ->pluck('description_'.$locale)->toArray();
                    if(count($tc)>0)
                        $text.="<li>".implode('</li><li>', $tc)."</li>";
                    break;
            }
        }
        return $text;
    }
    public function getFieldHelp(String $field_name){
        $text=$field_name.' - '.__('Not Found');
        $res=FieldsHelp::where('name_en','=',$field_name)->first();
        if($res){
            return $res['description_'.\App::getLocale()];
        }
        return $text;
    }
    public function help(){
        $posts=self::getPosts('help');
        return view('help.index',compact('posts'));
    }
}
