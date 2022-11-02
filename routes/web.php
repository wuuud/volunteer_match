<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VolunteerOfferController;

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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
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