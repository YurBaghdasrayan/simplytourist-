<?php

namespace App\Http\Controllers;

use App\Models\FieldsHelp;
use App\Models\Banners;
use App\Models\GeoObject;
use App\Models\Languages;
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

class GeoObjectController extends Controller
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

    public function find(Request $request)
    {
        $term = $request->q;

        if (empty($term)) {
            return \Response::json([]);
        }
        $geoObjects = GeoObject::where('name_en', 'LIKE', '%' . $term . '%')
            ->orWhere('name_de','LIKE', '%' . $term . '%')
            ->orWhere('name_ru','LIKE', '%' . $term . '%')->limit(20)->get();

        $formatted_tags = [];

        foreach ($geoObjects as $geo) {
            $formatted_tags[] = ['id' => $geo->id, 'text' => $geo['name_'.\App::getLocale()].' ('.Languages::getCountry($geo->country_iso).')'];
        }

        return \Response::json($formatted_tags);
    }
}
