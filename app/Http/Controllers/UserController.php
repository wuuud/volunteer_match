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
    public function myApplication()
    {
        $application = Application::myApplication()->first();
        if (isset($application)){
            return redirect()->route('applications.show', $application);
        }
        return redirect()->route('applications.create')->withErrors('経歴を先に登録してください。');
    }
}
