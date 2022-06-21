<?php

namespace App\Http\Controllers;

use App\Models\Banners;
use App\Models\Review;
use App\Models\Tours;
use App\Models\ToursConditions;
use App\Models\ToursTypes;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function landing(Request $request)
    {
        $tours_unfiltered=Tours::where('tour_private','=',0)->where('tour_status','=','open')->get();
        $tours_count=$tours_unfiltered->count();
        $tours = QueryBuilder::for(Tours::class)
            ->allowedFilters([
                'tour_name',
                'tour_type_id',
                'tour_condition_id',
                'country_iso',
                AllowedFilter::scope('more_type_rating'),
                AllowedFilter::scope('more_condition_rating'),
                AllowedFilter::scope('more_open_places'),
                AllowedFilter::scope('guide'),
            ]);
        $tours=$tours->where('tour_private','=',0)->where('tour_status','=','open');
        $dataTypeContent = ToursController::getData('tours', $request, $tours)->withQueryString();
        $rows = ToursController::getFields('tours', $this);
        $tours = $tours->paginate(4);
        $dataType = Voyager::model('DataType')->where('slug', '=', 'tours')->first();
        $tourTypes = ToursTypes::all();
        $tourConditions = ToursConditions::all();
        $reviews = Review::take(3)->get();
        $banners = Banners::take(5)->get();
        return view('welcome',compact(
            'tours',
            'rows',
            'dataType',
            'dataTypeContent',
            'tourTypes',
            'tourConditions',
            'reviews',
            'banners',
            'tours_count',
            'tours_unfiltered'
        ));
    }
    public static function getPosts($category){
        $category_ids=[];
        $posts=null;
        if($category!=''){
            $category_ids = \TCG\Voyager\Models\Category::where('slug','=',$category)->pluck('id');
            $posts = \TCG\Voyager\Models\Post::whereIn('category_id', $category_ids)->where('lang','=',\App::getLocale())->where('status','=','PUBLISHED')->get();
        }else{
            $posts = \TCG\Voyager\Models\Post::where('status','=','PUBLISHED')->where('lang','=',\App::getLocale())->get();
        }
        return $posts;
    }
    public function posts($category=''){
        $posts=self::getPosts($category);
        $categories = \TCG\Voyager\Models\Category::whereHas('posts', function (Builder $query) {
            $query->where('lang','=',\App::getLocale());
        })->orderBy('order')->get();
        $title=__('Articles');
        return view('public.posts.index', compact('posts','categories','title'));
    }
    public function help(){
        $posts=self::getPosts('help');
        return view('help.index',compact('posts'));
    }
}
