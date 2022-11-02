<?php

namespace App\Http\Controllers;

use App\Models\VolunteerOffer;
use App\Models\VolunteerOfferView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Models\Occupation;

class VolunteerOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $occupations = Occupation::all();
        // return view('job_offers.create', compact('occupations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VolunteerOffer  $volunteer_Offer
     * @return \Illuminate\Http\Response
     */
    public function show(VolunteerOffer $volunteer_Offer)
    {
        VolunteerOfferView::updateOrCreate([
            'volunteer_offer_id' => $volunteer_offer->id,
            'user_id' => Auth::user()->id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VolunteerOffer  $volunteer_Offer
     * @return \Illuminate\Http\Response
     */
    public function edit(VolunteerOffer $volunteer_Offer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VolunteerOffer  $volunteer_Offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VolunteerOffer $volunteer_Offer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VolunteerOffer  $volunteer_Offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(VolunteerOffer $volunteer_Offer)
    {
        //
    }
}
