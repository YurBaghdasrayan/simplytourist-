<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banners;
use App\Models\Review;
use App\Models\Tours;
use App\Models\ToursConditions;
use App\Models\ToursTypes;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{

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

    public function posts($category){

        $posts= self::getPosts($category);

        $categories = \TCG\Voyager\Models\Category::whereHas('posts', function (Builder $query) {
            $query->where('lang','=',\App::getLocale());
        })->orderBy('order')->get();
        $title=__('Articles');
        return response()->json([
            'success'=>true,
            'data'=>$posts,
            $categories,
            $title
        ]);
    }
}
