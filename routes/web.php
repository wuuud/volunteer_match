<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VolunteerOfferController;
use App\Http\Controllers\ScoutController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Volunteer;


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

Route::resource('volunteer_offers', VolunteerOfferController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('can:npo');

Route::resource('volunteer_offers', VolunteerOfferController::class)
    ->only(['show', 'index'])
    ->middleware('auth');

// scout用追加  indexのみ                要修正
// Route::resource('volunteers', VolunteerController::class)
//     ->name('volunteers.index')
//     ->only(['index, show'])
//     ->middleware('can:npo');
    
//     Route::get('/volunteers', function () {
//     return view('volunteers.index');
// })->middleware('can:npo')
//     ->name('volunteers.index');

// エントリー用
Route::patch('/volunteer_offers/{volunteer_offer}/scouts/{scout}/approval', [ScoutController::class, 'approval'])
    ->name('volunteer_offers.scouts.approval')
    ->middleware('can:npo');
// エントリー用
Route::patch('/volunteer_offers/{volunteer_offer}/scouts/{scout}/reject', [ScoutController::class, 'reject'])
    ->name('volunteer_offers.scouts.reject')
    ->middleware('can:npo');
Route::resource('volunteer_offers.messages', MessageController::class)
    ->only(['store', 'destroy'])
    ->middleware('auth');

// 削除 volunteerエントリー用
// Route::resource('volunteer_offers.scouts', ScoutController::class)
//     ->only(['store', 'destroy'])
//     ->middleware('can:user');

    Route::resource('volunteer_offers.scouts', ScoutController::class)
    ->only(['store', 'destroy'])
    ->middleware('can:user');
