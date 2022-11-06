<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VolunteerOffer;
use App\Models\Scout;
use Illuminate\Support\Facades\Auth;

class ScoutController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\VolunteerOffer  $Volunteer_offer
     * @return \Illuminate\Http\Response
     */
    public function store(VolunteerOffer $volunteer_offer)
    {
        $scout = new Scout([
            'volunteer_offer_id' => $volunteer_offer->id,
            'user_id' => Auth::user()->id,
        ]);

        try {
            // 登録
            $scout->save();
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors('エントリーでエラーが発生しました');
        }

        return redirect()
            ->route('volunteer_offers.show', $volunteer_offer)
            ->with('notice', 'エントリーしました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VolunteerOffer  $volunteer_offer
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(VolunteerOffer $volunteer_offer, Scout $scout)
   {
        $scout->elete();

        return redirect()->route('Volunteer_offers.show', $volunteer_offer)
            ->with('notice', 'エントリーを取り消しました'); 
}
}
