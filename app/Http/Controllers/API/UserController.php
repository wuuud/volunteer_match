<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
// use App\Models\VolunteerOffer;
use App\Models\Application;

class UserController extends Controller
{
    // public function dashboard(Request $request)
    // {
    //     $params = $request->query();
    //     $volunteer_offers = VolunteerOffer::myVolunteerOffer($params)->paginate(5);

    //     return view('dashboard', compact('volunteer_offers'));
    // }

    public function myApplication()
    {
        // 認証後
        $application = Application::myApplication()->first();
        if (isset($application)) {
            // return redirect()->route('applications.show', $application);
            return response()->json(compact('application'));
        }
        // return redirect()->route('applications.create')->withErrors('経歴を先に登録してください。');
        return response()->json($application, 204);

        // API後
        $application = Application::myApplication()->first();
        if (isset($application)) {
            // return redirect()->route('applications.show', $application);
            return response()->json(compact('application'));
        }
        // return redirect()->route('applications.create')->withErrors('経歴を先に登録してください。');
        return response()->json($application, 204);

        // API前
        //     $application = Application::myApplication()->first();
        //     if (isset($application)){
        //         return redirect()->route('applications.show', $application);
        //     }
        //     return redirect()->route('applications.create')->withErrors('経歴を先に登録してください。');
        // }
    }
}
