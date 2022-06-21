<?php

use App\Http\Controllers\Api\LanguageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ResetsPasswords;
use App\Http\Controllers\Api\ToursController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\HomeApiController;
use App\Http\Controllers\Api\UsergroupController;
use App\Http\Controllers\Api\UsergroupThemesController;
use App\Http\Controllers\Api\SendsPasswordResetEmails;
use App\Http\Controllers\Api\UsergroupApiInvitationsController;
use App\Http\Controllers\Api\TourApiInvitationsController;
use App\Http\Controllers\Api\inviteFriendsController;
use App\Http\Middleware\UnverifiyUsers;
use App\Http\Controllers\Api\ChatController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/testfirst', [\App\Http\Controllers\AuthtestController::class, 'store']);

Route::post('/register', [AuthController::class, 'store']);
Route::post('/login', [AuthController::class, 'storeLogin'])->name('login');
Route::post('/code-sending', [AuthController::class, 'send'])->name('code-sending');
Route::post('/password-reset', [ResetsPasswords::class, 'reset']);
Route::post('/send-email', [SendsPasswordResetEmails::class, 'sendResetLinkEmail']);
Route::get('lang', [LanguageController::class,'switchLang'])->name('lang.switch');
Route::get('posts/{category?}', [HomeController::class,'posts']);

//Route::middleware(['auth','verified'])->group(function () {
Route::group(['middleware' => ['auth:api']], function () {
    Route::middleware(['verify'])->group(function () {
        Route::get('user-data/{id}', [AuthController::class,'getUserData']);
        Route::get('/home', [HomeController::class, 'landing']);
        Route::get('/tours', [ToursController::class, 'myTours']);
        Route::get('/usergroups', [UsergroupController::class, 'index']);
        Route::get('/usergroupsss/{usergroup_id}', [UsergroupController::class, 'prepareUserInput']);
        Route::get('/usergroupInvitations/{group_id}/{group_status}',[App\Http\Controllers\Api\ApiUsergroupInvitationsController::class,'setStatus']);

        Route::resource('/usergroups', App\Http\Controllers\Api\UsergroupController::class);
        Route::resource('/invitations/groups', App\Http\Controllers\Api\ApiUsergroupInvitationsController::class);
        Route::apiResource('usergroupThemes', App\Http\Controllers\Api\UsergroupThemesController::class);
        Route::get('usergroupThemesDelete/{id}', [App\Http\Controllers\Api\usergroupDeleteController::class,'destroy']);
        Route::post('/profile-edit/{id}', [AuthController::class, 'update']);
        Route::post('tour-invations', [TourApiInvitationsController::class,'store']);
        Route::get('tour-invations/{request_id?}/{status?}', [TourApiInvitationsController::class,'setStatus']);
        Route::get('gettour-invations', [TourApiInvitationsController::class,'index']);
        Route::post('user-invations', [inviteFriendsController::class,'store']);
        Route::post('/chat-users', [ChatController::class,'store'])->name('chat.users');
        Route::get('/chat-users/{id}', [ChatController::class,'index'])->name('chat.users.data');
        Route::get('/chat-users-data', [ChatController::class,'allChat']);
    });
    Route::middleware(['unverify'])->group(function () {
        Route::post('/verifycode', [\App\Http\Controllers\Api\AuthController::class, 'verifycodeapi'])->name('verifycode')->name('ver');
        Route::post('/coderepeat', [\App\Http\Controllers\Api\AuthController::class, 'CodeRepeat'])->name('coderepeat');
    });
});




