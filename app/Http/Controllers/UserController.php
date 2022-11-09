<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VolunteerOffer;
use App\Models\Application;

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

    /**
     * dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function prodashboard(Request $request)
    {
        $params = $request->query();
        $applications = Application::myApplication($params)->paginate(5);

        return view('applications.index', compact('applications'));
    }
}
