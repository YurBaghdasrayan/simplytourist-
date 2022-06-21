<?php

use App\Http\Controllers\UsergroupsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','App\Http\Controllers\HomeController@landing');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
Route::get('/help/rating/{type}/{rating}/{ref_ids?}/{show_prepend?}','App\Http\Controllers\HelpController@getRatingHelp');
Route::get('/help/field/{field_name}/','App\Http\Controllers\HelpController@getFieldHelp');

Auth::routes(['verify' => true]);
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/home', 'App\Http\Controllers\ToursController@myTours')->name('home');
    Route::get('/profile/{slug}','App\Http\Controllers\UserController@index');
    Route::resource('profile', App\Http\Controllers\UserController::class);
    Route::get('/user/find','App\Http\Controllers\UserController@find');
    Route::get('/user/findOne','App\Http\Controllers\UserController@findOne');
    Route::get('/user/contacts/{user_id}','App\Http\Controllers\UserController@getContacts');


    Route::get('/tours/themes/{theme_id}','App\Http\Controllers\ToursController@tourDiscussionIndex');
    Route::get('/tours/{tour_id}/theme/create','App\Http\Controllers\ToursController@tourDiscussionCreate');
    Route::get('/tours/{tour_id}/status/{tour_status}','App\Http\Controllers\ToursController@setStatus');
    Route::get('/tours/{tour_id}/sendStatusChange/','App\Http\Controllers\ToursController@sendStatusChange');
    Route::get('/tours/{tour_id}/invitations/','App\Http\Controllers\ToursController@invitations');
    Route::get('/tours/{tour_id}/candidate','App\Http\Controllers\TourCandidatesController@index');
    Route::get('/tourCandidates/{request_id}/status/{status}','App\Http\Controllers\TourCandidatesController@setStatus');
    Route::get('/tourInvitations/{tour_id}/status/{tour_status}','App\Http\Controllers\TourInvitationsController@setStatus');
    Route::resource('/invitations/tours', App\Http\Controllers\TourInvitationsController::class);
    Route::get('/usergroupInvitations/{group_id}/status/{group_status}','App\Http\Controllers\UsergroupInvitationsController@setStatus');
    Route::resource('/invitations/groups', App\Http\Controllers\UsergroupInvitationsController::class);
    Route::post('/tour/validate','App\Http\Controllers\ToursController@checkValidation');
    Route::put('/tour/validate','App\Http\Controllers\ToursController@checkValidation');
    Route::resource('tours', App\Http\Controllers\ToursController::class);
    Route::resource('tourAttendees', App\Http\Controllers\TourAttendeesController::class);
    Route::resource('tourEquipments', App\Http\Controllers\TourEquipmentController::class);

    Route::resource('toursConditions', App\Http\Controllers\ToursConditionsController::class);
    Route::resource('tourCandidates', App\Http\Controllers\TourCandidatesController::class);
    Route::resource('toursTypes', App\Http\Controllers\ToursTypesController::class);
    Route::resource('toursConditionsRatings', App\Http\Controllers\ToursConditionsRatingsController::class);
    Route::resource('toursTypesRatings', App\Http\Controllers\ToursTypesRatingsController::class);

    Route::get('/bagCheck/{equipment_id}/{qty}','App\Http\Controllers\UserEquipmentController@bagCheck');
    Route::get('/equipmentType/{id}/get','App\Http\Controllers\UserEquipmentController@getMyEquipByType');
    Route::resource('userEquipment',App\Http\Controllers\UserEquipmentController::class);
    Route::get('/equipmentType/{id}/all','App\Http\Controllers\EquipmentController@getEquipByType');
    Route::get('/equipment/find/{ids}/','App\Http\Controllers\EquipmentController@getByIds');
    Route::get('/equipment/add','App\Http\Controllers\EquipmentController@addMyEquipment');
    Route::get('/equipment/remove','App\Http\Controllers\EquipmentController@removeMyEquipment');
    Route::resource('equipment', App\Http\Controllers\EquipmentController::class);
    Route::resource('equipmentTypes', App\Http\Controllers\EquipmentTypeController::class);


    Route::get('/usergroup/themes/{theme_id}','App\Http\Controllers\UsergroupCommentsController@index');
    Route::get('/usergroup/{usergroup_id}','App\Http\Controllers\UsergroupThemesController@index');
    Route::get('/usergroups/{usergroup_id}/invitations/','App\Http\Controllers\UsergroupsController@invitations');
    Route::get('/usergroups/{group_id}/candidate','App\Http\Controllers\UsergroupCandidatesController@index');
    Route::get('/usergroupCandidates/{request_id}/status/{status}','App\Http\Controllers\UsergroupCandidatesController@setStatus');
    Route::resource('usergroupCandidates', App\Http\Controllers\UsergroupCandidatesController::class);

    Route::resource('usergroups', App\Http\Controllers\UsergroupsController::class);
    Route::resource('usergroupThemes', App\Http\Controllers\UsergroupThemesController::class);
    Route::get('/usergroup/{usergroup_id}/theme/create','App\Http\Controllers\UsergroupThemesController@create')->name('usergroupThemes.create');
    Route::resource('usergroupMembers', App\Http\Controllers\UsergroupMembersController::class);
    Route::resource('usergroupComments', App\Http\Controllers\UsergroupCommentsController::class);

    Route::get('help','App\Http\Controllers\HomeController@help');
    Route::get('/help/{slug}', function($slug){
        $post = \TCG\Voyager\Models\Post::where('slug', '=', $slug)->firstOrFail();
        return view('help.show', compact('post'));
    })->name('help.show');
    Route::get('/geo_object/find','App\Http\Controllers\GeoObjectController@find');


});
Route::get('login/{provider}', 'App\Http\Controllers\SocialController@redirect');
Route::get('login/{provider}/callback','\App\Http\Controllers\SocialController@Callback');

Route::get('lang/{lang}', '\App\Http\Controllers\LanguageController@switchLang')->name('lang.switch');
Route::get('/languages/{country_iso}/show/','\App\Http\Controllers\LanguageController@showApi');
Route::get('/languages/{lang_name}/','\App\Http\Controllers\LanguageController@indexApi');
Route::get('/public/usergroups/','App\Http\Controllers\UsergroupsController@publicIndex')->name('usergroupsPublic');
Route::get('/public/tour/{tour}','App\Http\Controllers\ToursController@publicShow')->name('toursPublic.show');
Route::get('/public/tours/','App\Http\Controllers\ToursController@publicIndex')->name('toursPublic');
Route::get('/public/post/{slug}', function($slug){
    $post = \TCG\Voyager\Models\Post::where('slug', '=', $slug)->whereIn('status',['PUBLISHED','DRAFT'])->firstOrFail();
    $title=$post->title;
    $description=$post->meta_description;
    return view('public.posts.show', compact('post','title','description'));
})->name('posts.show');
Route::get('/public/posts/{category?}', 'App\Http\Controllers\HomeController@posts')->name('posts');
Route::get('/pages/{slug}', function($slug){
    $post = \TCG\Voyager\Models\Page::where('slug', '=', $slug)->firstOrFail();
    $title=$post->title;
    $description=$post->meta_description;
    return view('public.pages.show', compact('post','title','description'));
});
Route::get('runtime','App\Http\Controllers\UserController@runtime');

Route::get('/tstheader',function (\Illuminate\Http\Request $request){
//    if(strlen($request->server('HTTP_ACCEPT_LANGUAGE'))>2)
        echo 'локаль браузера - '.$request->server('HTTP_ACCEPT_LANGUAGE');
});

Route::get('/test', [App\Http\Controllers\TestController::class,"index"])->name('test');







