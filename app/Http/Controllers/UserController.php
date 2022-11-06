<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VolunteerOffer;

class UserController extends Controller
{
    /**
     * dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {
        $params = $request->query();
        $volunteer_offers = VolunteerOffer::myVolunteerOffer($params)->paginate(5);

        return view('dashboard', compact('volunteer_offers'));
    }
}
