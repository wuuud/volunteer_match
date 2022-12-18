<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VolunteerOfferController;
use App\Http\Controllers\ScoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProposeController;
// SNS認証用
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ChatController;



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

// １.トップ
Route::get('/', [VolunteerOfferController::class, 'index'])
    ->middleware('auth')
    ->name('root');

// 2.ゲスト用
Route::get('/welcome', function () {
    return view('welcome');
})->middleware('guest')
    ->name('welcome');

// ３. ダッシュボード
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])
        ->name('dashboard');
});

// 4.npo 新規登録
Route::get('npo/register', function () {
    return view('npo.register');
})->middleware('guest')
    ->name('npo.register');

//５.ボランティア活動
Route::resource('volunteer_offers', VolunteerOfferController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    // authServiceProvider.phpでgateを定義
    ->middleware('can:npo');
Route::resource('volunteer_offers', VolunteerOfferController::class)
    ->only(['show', 'index'])
    ->middleware('auth');

//６.経歴用 ダッシュボード
Route::get('/myapplication', [UserController::class, 'myapplication'])
        ->name('myapplication')
        ->middleware('can:volunteer');


//７.メッセージ application
Route::resource('applications.messages', MessageController::class)
    ->only(['store', 'destroy'])
    ->middleware('auth');

// 8.スカウト
Route::resource('applications', ApplicationController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('can:volunteer');
Route::resource('applications', ApplicationController::class)
    ->only(['show', 'index'])
    ->middleware('auth');

// 9. ５エントリーの承認、却下  ボランティア活動
Route::patch('/volunteer_offers/{volunteer_offer}/scouts/{scout}/approval', [ScoutController::class, 'approval'])
    ->name('volunteer_offers.scouts.approval')
    ->middleware('can:npo');
Route::patch('/volunteer_offers/{volunteer_offer}/scouts/{scout}/reject', [ScoutController::class, 'reject'])
    ->name('volunteer_offers.scouts.reject')
    ->middleware('can:npo');
    // エントリーボタンを押した際の保存
    Route::resource('volunteer_offers.scouts', ScoutController::class)
    ->only(['store', 'destroy'])
    ->middleware('can:volunteer');

// 10. ８スカウトの承認、却下  ボランティア人材
Route::patch('/applications/{application}/proposes/{propose}/accept', [ProposeController::class, 'accept'])
    ->name('applications.proposes.accept')
    ->middleware('can:volunteer');
Route::patch('/applications/{application}/proposes/{propose}/refuse', [ProposeController::class, 'refuse'])
    ->name('applications.proposes.refuse')
    ->middleware('can:volunteer');
    // スカウトボタンを押した際の保存
Route::resource('applications.proposes', ProposeController::class)
    ->only(['store', 'destroy'])
    ->middleware('can:npo');

// 11.リアルタイムチャット
Route::resource('proposes.messages', ChatController::class)
        ->only(['index', 'store', 'destroy'])
        ->middleware('auth');

//12.SNS認証用
// authから始まるルーティングに認証前にアクセスがあった場合
Route::prefix('auth')->middleware('guest')->group(function () {
    // auth/githubにアクセスがあった場合はOAuthControllerのredirectToProviderアクションへルーティング
    Route::get('/github', [OAuthController::class, 'redirectToProvider'])
        ->name('redirectToProvider');

    // auth/github/callbackにアクセスがあった場合はOAuthControllerのoauthCallbackアクションへルーティング
    Route::get('/github/callback', [OAuthController::class, 'oauthCallback'])
        ->name('oauthCallback');
});
