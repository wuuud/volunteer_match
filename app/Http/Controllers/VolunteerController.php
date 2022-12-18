<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Volunteer;
use Illuminate\Support\Facades\Auth;


class VolunteerController extends Controller
{
    public function create(Volunteer $volunteer)
    {
        // スカウト済みか
        $scout = !isset(Auth::user()->volunteer)
            ? $volunteer->scouts()->firstWhere('user_id', Auth::user()->id)
            : '';
        // return view('volunteer_offers.show', compact('volunteer_offer', 'entry'));
        return view('volunteer_offers.show', compact('volunteer_id', 'scout'));
    }
}
