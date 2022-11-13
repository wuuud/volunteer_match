<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\VolunteerOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VolunteerOffer  $volunteer_offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VolunteerOffer $volunteer_offer)
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
