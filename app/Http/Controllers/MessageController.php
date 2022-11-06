<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\VolunteerOffer;

class MessageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\VolunteerOffer  $volunteer_offer
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VolunteerOffer $volunteer_offer, Request $request)
    {
        $message = new Message($request->all());
        $message->messageable_type = 'App\Models\VolunteerOffer';
        $message->messageable_id = $request->messageable_id;
        $message->user_id = Auth::user()->id;
        $message->message = $request->message;

        try {
            // 登録
            $message->save();
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors('メッセージ登録処理でエラーが発生しました');
        }

        $volunteer_offer = VolunteerOffer::find($request->messageable_id);

        return redirect()
            ->route('volunteer_offers.show', $volunteer_offer)
            ->with('notice', 'メッセージを登録しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VolunteerOffer  $volunteer_offer
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(VolunteerOffer $volunteer_offer, Message $message)
    {
        $volunteer_offer = $message->messageable;

        if (Auth::user()->id != $message->user_id) {
            return redirect()->route('volunteer_offers.show', $volunteer_offer)
                ->withErrors('自分のメッセージ以外は削除できません');
        }

        try {
            $message->delete();
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors('メッセージ削除処理でエラーが発生しました');
        }

        return redirect()->route('volunteer_offers.show', $volunteer_offer)
            ->with('notice', ' メッセージを削除しました');
    }
}
