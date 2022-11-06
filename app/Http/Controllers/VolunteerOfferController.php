<?php

namespace App\Http\Controllers;

use App\Models\VolunteerOffer;
// use App\Models\VolunteerOfferView;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
// use App\Models\Occupation;
use App\Http\Requests\VolunteerOfferRequest;

class VolunteerOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    // 職種による検索 public function index(Request $request)
    {
        // $volunteer_offers = VolunteerOffer::with('npo')->latest()->paginate(5);
        $volunteer_offers = VolunteerOffer::with('npo')
            ->published()->latest()->paginate(5);

        // 職種による検索時
        // $params = $request->query();
        // $job_offers = JobOffer::search($params)->published()
        //     ->with(['company', 'occupation'])->latest()->paginate(5);
        // $job_offers->appends($params);
        
        // $occupations = Occupation::all();
        return view('volunteer_offers.index', compact('volunteer_offers'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $occupations = Occupation::all();
        // return view('volunteer_offers.create', compact('occupations'));
        return view('volunteer_offers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\VolunteerOfferRequest  $request 
     * @return \Illuminate\Http\Response
     */
    public function store(VolunteerOfferRequest  $request)
    {
        $volunteer_offer = new VolunteerOffer($request->all());
        $volunteer_offer->npo_id = $request->user()->npo->id;

        try {
            // 登録
            $volunteer_offer->save();
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors('ボランティア募集情報の登録処理でエラーが発生しました');
        }

        return redirect()
            ->route('volunteer_offers.show', $volunteer_offer)
            ->with('notice', 'ボランティア募集情報を登録しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VolunteerOffer  $volunteer_offer
     * @return \Illuminate\Http\Response
     */
    public function show(VolunteerOffer $volunteer_offer)
    {
        // VolunteerOfferView::updateOrCreate([
        //     'volunteer_offer_id' => $volunteer_offer->id,
        //     'user_id' => Auth::user()->id,
        // ]);
        $scout = !isset(Auth::user()->npo)
            ? $volunteer_offer->scouts()->firstWhere('user_id', Auth::user()->id)
            : '';

        $scouts = Auth::user()->id == $volunteer_offer->npo->user_id
            ? $scouts = $volunteer_offer->scouts()->with('user')->get()
            : [];

        $messages = $volunteer_offer->messages->load('user');

        //    return view('volunteer_offers.show', compact('volunteer_offer', 'scout'));
        return view('volunteer_offers.show', compact('volunteer_offer', 'scout', 'scouts', 'messages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VolunteerOffer  $volunteer_offer
     * @return \Illuminate\Http\Response
     */
    public function edit(VolunteerOffer $volunteer_offer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\VolunteerOfferRequest  $request 
     * @param  \App\Models\VolunteerOffer  $volunteer_offer
     * @return \Illuminate\Http\Response
     */
    public function update(VolunteerOfferRequest  $request, VolunteerOffer $volunteer_offer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VolunteerOffer  $volunteer_offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(VolunteerOffer $volunteer_offer)
    {
        //
    }
}
