<?php

namespace App\Http\Controllers;

use App\Models\VolunteerOffer;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\VolunteerOfferRequest;

class VolunteerOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $volunteer_offers = VolunteerOffer::with('npo')
            ->published()->latest()->paginate(5);
        return view('volunteer_offers.index', compact('volunteer_offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        //npoなら テキストから変更  ！issetだった
        $scout = !isset(Auth::user()->npo)
            ? $volunteer_offer->scouts()->firstWhere('user_id', Auth::user()->id)
            : '';
        $scouts = Auth::user()->id == $volunteer_offer->npo->user_id
            ? $scouts = $volunteer_offer->scouts()->with('user')->get()
            : [];

        return view('volunteer_offers.show', compact('volunteer_offer', 'scout', 'scouts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VolunteerOffer  $volunteer_offer
     * @return \Illuminate\Http\Response
     */
    public function edit(VolunteerOffer $volunteer_offer)
    {
        // $occupations = Occupation::all();
        return view('volunteer_offers.edit', compact('volunteer_offer'));
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
        if (Auth::user()->cannot('update', $volunteer_offer)) {
            return redirect()->route('volunteer_offers.show', $volunteer_offer)
                ->withErrors('自分の募集情報以外は更新できません');
        }
        $volunteer_offer->fill($request->all());
        try {
            $volunteer_offer->save();
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors('募集情報更新処理でエラーが発生しました');
        }
        return redirect()->route('volunteer_offers.show', $volunteer_offer)
            ->with('notice', '募集情報を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VolunteerOffer  $volunteer_offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(VolunteerOffer $volunteer_offer)
    {
        if (Auth::user()->cannot('delete', $volunteer_offer)) {
            return redirect()->route('volun$volunteer_offers.show', $volunteer_offer)
                ->withErrors('自分の募集情報以外は削除できません');
        }
        try {
            $volunteer_offer->delete();
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors('募集情報削除処理でエラーが発生しました');
        }
        return redirect()->route('volunteer_offers.index')
            ->with('notice', '募集情報を削除しました');
    }
}
