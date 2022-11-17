<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ApplicationController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\ProposeController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\API\ChatController;
use App\Http\Controllers\API\VolunteerOfferController;
// 余裕あれば
// use App\Http\Controllers\ScoutController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// <     不要       >
// // １.トップ
// Route::get('/', [VolunteerOfferController::class, 'index'])
//     ->middleware('auth')
//     ->name('root');

// // 2.ゲスト用
// Route::get('/welcome', function () {
//     return view('welcome');
// })->middleware('guest')
//     ->name('welcome');
//５.ボランティア活動
Route::apiResource('volunteer_offers', VolunteerOfferController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->names('api.volunteer_offers')
    ->middleware('can:npo')
    ->middleware('auth:api');
Route::apiResource('volunteer_offers', VolunteerOfferController::class)
    ->only(['show', 'index'])
    ->middleware('auth:api');

// ３. ダッシュボード
// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('/dashboard', [UserController::class, 'dashboard'])
//         ->name('dashboard');
// });

// 4.npo 新規登録                apiいるの？？？？
Route::get('npo/register', function () {
    return view('npo.register');
})->middleware('guest')
    ->name('api.npo.register')
    ->middleware('auth:api');


//６.経歴用 ダッシュボード
Route::get('/myapplication', [UserController::class, 'myapplication'])
    ->name('api.myapplication')
    ->middleware('can:volunteer')
    ->middleware('auth:api');


//７.メッセージ application
Route::apiResource('applications.messages', MessageController::class)
    ->only(['store', 'destroy'])
    ->names('api.applications.messages')
    // ->middleware('auth')
    ->middleware('auth:api');
// Route::resource('applications.messages', MessageController::class)
//     ->only(['store', 'destroy'])
//     ->middleware('auth');

// 8.スカウト
Route::apiResource('applications', ApplicationController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->names('api.applications')
    ->middleware('can:volunteer')
    ->middleware('auth:api')
    ;
Route::apiResource('applications', ApplicationController::class)
    ->only(['show', 'index'])
    ->middleware('auth:api');
// Route::resource('applications', ApplicationController::class)
//     ->only(['create', 'store', 'edit', 'update', 'destroy'])
//     ->middleware('can:volunteer');
// Route::resource('applications', ApplicationController::class)
//     ->only(['show', 'index'])
//     ->middleware('auth');

// 余裕あれば
// 9. ５エントリーの承認、却下  ボランティア活動
// Route::patch('/volunteer_offers/{volunteer_offer}/scouts/{scout}/approval', [ScoutController::class, 'approval'])
//     ->name('volunteer_offers.scouts.approval')
//     ->middleware('can:npo');
// Route::patch('/volunteer_offers/{volunteer_offer}/scouts/{scout}/reject', [ScoutController::class, 'reject'])
//     ->name('volunteer_offers.scouts.reject')
//     ->middleware('can:npo');
// // エントリーボタンを押した際の保存
// Route::resource('volunteer_offers.scouts', ScoutController::class)
//     ->only(['store', 'destroy'])
//     ->middleware('can:volunteer');

// 10. ８スカウトの承認、却下  ボランティア人材
Route::patch('/applications/{application}/proposes/{propose}/accept', [ProposeController::class, 'accept'])
    ->name('api.applications.proposes.accept')
    ->middleware('can:volunteer')
    ->middleware('auth:api');
Route::patch('/applications/{application}/proposes/{propose}/refuse', [ProposeController::class, 'refuse'])
    ->name('api.applications.proposes.refuse')
    ->middleware('can:volunteer')
    ->middleware('auth:api');
Route::apiResource('applications.proposes', ProposeController::class)
    ->only(['store', 'destroy'])
    ->middleware('can:npo')
    ->middleware('auth:api');
// Route::patch('/applications/{application}/proposes/{propose}/accept', [ProposeController::class, 'accept'])
//     ->name('applications.proposes.accept')
//     ->middleware('can:volunteer');
// Route::patch('/applications/{application}/proposes/{propose}/refuse', [ProposeController::class, 'refuse'])
//     ->name('applications.proposes.refuse')
//     ->middleware('can:volunteer');
//     // スカウトボタンを押した際の保存
// Route::resource('applications.proposes', ProposeController::class)
//     ->only(['store', 'destroy'])
//     ->middleware('can:npo');

// 11.リアルタイムチャット
Route::apiResource('proposes.messages', ChatController::class)
    ->only(['index', 'store', 'destroy'])
    ->middleware('auth:api');
// Route::resource('proposes.messages', ChatController::class)
//     ->only(['index', 'store', 'destroy'])
//     ->middleware('auth');

//12.SNS認証用
// authから始まるルーティングに認証前にアクセスがあった場合
Route::prefix('auth')->middleware('guest')->group(function () {
    // auth/githubにアクセスがあった場合はOAuthControllerのredirectToProviderアクションへルーティング
    Route::get('/github', [OAuthController::class, 'redirectToProvider'])
        ->name('api.redirectToProvider')
        ->middleware('auth:api');

    // auth/github/callbackにアクセスがあった場合はOAuthControllerのoauthCallbackアクションへルーティング
    Route::get('/github/callback', [OAuthController::class, 'oauthCallback'])
        ->name('api.oauthCallback')
        ->middleware('auth:api');
});
