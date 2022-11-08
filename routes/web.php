<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VolunteerOfferController;
use App\Http\Controllers\ScoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProposeController;


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

Route::get('/', [VolunteerOfferController::class, 'index'])
    ->middleware('auth')
    ->name('root');

// Route::get('/', function () {
//     return view('welcome');
// })->name('welcome');

Route::get('/welcome', function () {
    return view('welcome');
})->middleware('guest')
    ->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])
        ->name('dashboard');
});

Route::get('npo/register', function () {
    return view('npo.register');
})->middleware('guest')
    ->name('npo.register');

//ログイン直後の画面 仕事内容記載
Route::resource('volunteer_offers', VolunteerOfferController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    // authServiceProvider.phpでgateを定義
    ->middleware('can:npo');

Route::resource('volunteer_offers', VolunteerOfferController::class)
    ->only(['show', 'index'])
    ->middleware('auth');


// application
Route::resource('applications', ApplicationController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('can:volunteer');

Route::resource('applications', ApplicationController::class)
    ->only(['show', 'index'])
    ->middleware('can:npo');


// 元のルート エントリー用
Route::patch('/volunteer_offers/{volunteer_offer}/scouts/{scout}/approval', [ScoutController::class, 'approval'])
    ->name('volunteer_offers.scouts.approval')
    ->middleware('can:npo');
// エントリー用
Route::patch('/volunteer_offers/{volunteer_offer}/scouts/{scout}/reject', [ScoutController::class, 'reject'])
    ->name('volunteer_offers.scouts.reject')
    ->middleware('can:npo');
// エントリー
    Route::resource('volunteer_offers.scouts', ScoutController::class)
    ->only(['store', 'destroy'])
    ->middleware('can:user');



// スカウト用
Route::patch('/applications/{application}/proposes/{propose}/accept', [ScoutController::class, 'accept'])
    ->name('applications.proposes.accept')
    ->middleware('can:user');
// スカウト用
Route::patch('/applications/{application}/proposes/{propose}/refuse', [ScoutController::class, 'refuse'])
    ->name('applications.proposes.refuse')
    ->middleware('can:user');
// スカウト用
Route::resource('applications.proposes', ProposeController::class)
    ->only(['store', 'destroy'])
    ->middleware('can:npo');
