<?php

namespace App\Http\Controllers;

use App\Models\VolunteerOffer;
use App\Models\Scout;
use App\Models\Volunteer;
use Illuminate\Support\Facades\Auth;

class ScoutController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\VolunteerOffer  $VolunteerOffer
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
     * @param  \App\Models\Scout  $scout
     * @return \Illuminate\Http\Response
     */
    public function destroy(VolunteerOffer $volunteer_offer, Scout $scout)
    {
        $scout->delete();
        return redirect()->route('volunteer_offers.show', $volunteer_offer)
            ->with('notice', 'エントリーを取り消しました');
    }
/**
     *
     * @param  \App\Models\VolunteerOffer  $volunteer_offer
     * @param  \App\Models\Scout $scout
     * @return \Illuminate\Http\Response
     */
    public function approval(VolunteerOffer $volunteer_offer, Scout $scout)
    {
        $scout->status = Scout::STATUS_APPROVAL;
        $scout->save();

        return redirect()->route('volunteer_offers.show', $volunteer_offer)
            ->with('notice', 'エントリーを承認しました');
    }

    /**
     *
     * @param  \App\Models\VolunteerOffer  $volunteer_offer
     * @param  \App\Models\Scout $scout
     * @return \Illuminate\Http\Response
     */
    public function reject(VolunteerOffer $volunteer_offer, Scout $scout)
    {
        $scout->status = Scout::STATUS_REJECT;
        $scout->save();

        return redirect()->route('volunteer_offers.show', $volunteer_offer)
            ->with('notice', 'エントリーを却下しました');
    }
}
